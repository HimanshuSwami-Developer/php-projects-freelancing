<?php
include("admin/assets/config/db.php");
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

// Step 1: Get PayPal Access Token
$client_id = 'BAA9jvA10CUbiuRE8FwduWofXpTHgTD-7lTYT-7E5BiHZxsJE49pezoyBFg4fBxCwbeceoHzlLtN0wljxg';
$secret = 'ENUi0CMICicWEATCP7dztIhp_z944WGzZurmJOLOT9k6UmQLFHF2v96egQLxO97LBT95rsgljvE72Rig';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api-m.paypal.com/v1/oauth2/token");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, "$client_id:$secret");
curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Accept: application/json", "Accept-Language: en_US"]);
$tokenResponse = curl_exec($ch);

if (!$tokenResponse) {
  echo json_encode(["message" => "Failed to get access token: " . curl_error($ch)]);
  exit;
}

$access_token = json_decode($tokenResponse)->access_token;
// $data['amount']
// Create PayPal order
$orderData = [
    "intent" => "CAPTURE",
    "purchase_units" => [[
      "amount" => [
        "currency_code" => "GBP",
        "value" => $data['amount']
      ],
      "description" => $data['course'],
      "custom_id" => json_encode([
          "date" => $data['date'],
          "package_name" => $data['packageName']
        ]),
      "shipping" => [
        "address" => [
          "address_line_1" => $data['address'],
          "admin_area_2" => $data['city'],   // City
          "postal_code"   => $data['zipcode'],
          "country_code"  => "GB"
        ]
      ]
    ]],
    "payer" => [
      "name" => [
        "given_name" => explode(' ', $data['full_name'])[0],
        "surname"    => explode(' ', $data['full_name'])[1] ?? ''
      ],
      "email_address" => $data['email']
    ],
    "application_context" => [
      "return_url" => "https://gsecurityandtraining.co.uk/success",
      "cancel_url" => "https://gsecurityandtraining.co.uk/cancel",
      "shipping_preference" => "GET_FROM_FILE",
      "user_action" => "PAY_NOW",
       "brand_name" => "GSecurity Training",
       "landing_page" => "BILLING"
    ]
  ];
  
curl_setopt($ch, CURLOPT_URL, "https://api-m.paypal.com/v2/checkout/orders");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($orderData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  "Content-Type: application/json",
  "Authorization: Bearer $access_token"
]);

$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpcode != 201) {
  echo json_encode(["message" => "Error creating PayPal order: " . $response]);
  exit;
}

$result = json_decode($response, true);
foreach ($result['links'] as $link) {
  if ($link['rel'] === 'approve') {
    $paypal_order_id = $result['id'];

       $sql = "
  INSERT INTO orders 
  (name, contact, email, course_id, course_date_id, subscription_plan_id,paypal_order_id ,payment_status, created_at)
  VALUES (
    '" . mysqli_real_escape_string($con, $data['full_name']) . "',
    '" . mysqli_real_escape_string($con, $data['phone']) . "',
    '" . mysqli_real_escape_string($con, $data['email']) . "',
    " . (int)$data['course_id'] . ",
    " . (int)$data['course_date_id'] . ",
    " . (int)$data['subscription_plan_id'] . ",
    '$paypal_order_id',
    '" . mysqli_real_escape_string($con, $data['payment_status']) . "',
    NOW()
  )
";

if (mysqli_query($con, $sql)) {
    $msg = "Order added successfully!";
} else {
    $msg = "Error: " . mysqli_error($con);
}

    echo json_encode(["approval_url" => $link['href']]);
    exit;
  }
}
echo json_encode(["message" => "Approval link not found in PayPal response."]);