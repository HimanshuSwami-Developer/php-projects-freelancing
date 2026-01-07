<?php
if (!isset($_GET['token'])) {
  die("Order token missing.");
}

$order_id = $_GET['token'];

// Get Access Token
$client_id = 'BAA9jvA10CUbiuRE8FwduWofXpTHgTD-7lTYT-7E5BiHZxsJE49pezoyBFg4fBxCwbeceoHzlLtN0wljxg';
$secret = 'ENUi0CMICicWEATCP7dztIhp_z944WGzZurmJOLOT9k6UmQLFHF2v96egQLxO97LBT95rsgljvE72Rig';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api-m.paypal.com/v1/oauth2/token");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, "$client_id:$secret");
curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Accept: application/json"]);
$tokenResponse = curl_exec($ch);
if (!$tokenResponse) {
  die("Failed to get access token.");
}
$access_token = json_decode($tokenResponse)->access_token;

// Capture the order
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api-m.paypal.com/v2/checkout/orders/$order_id/capture");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  "Content-Type: application/json",
  "Authorization: Bearer $access_token"
]);

$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpcode !== 201) {
  die("<h2>Failed to capture payment.</h2><pre>$response</pre>");
}

$data = json_decode($response, true);
$capture = $data['purchase_units'][0]['payments']['captures'][0] ?? null;
$status = $capture['status'] ?? null;
// Capture was successful
$transaction_id = $capture['id'];
$payer_email = $data['payer']['email_address'];
$payer_name = $data['payer']['name']['given_name'] . ' ' . $data['payer']['name']['surname'];
$email = $data['payer']['email_address'];


if ($status !== 'COMPLETED') {
  $course = $data['purchase_units'][0]['description'] ?? 'N/A';
  $price = $data['purchase_units'][0]['amount']['value'] ?? 'N/A';

  // Payment failed
  $user_subject = "⚠️ Payment Not Completed - $course";
  $user_body = "
<html>
<head>
<style>
  body {
    font-family: Arial, sans-serif;
    background: #f8f8f8;
    margin: 0;
    padding: 20px;
  }
  .email-container {
    background: #ffffff;
    border-radius: 10px;
    padding: 25px;
    max-width: 600px;
    margin: auto;
    box-shadow: 0 3px 8px rgba(0,0,0,0.05);
  }
  .header {
    background: #dc2626;
    color: #ffffff;
    padding: 12px;
    border-radius: 8px;
    text-align: center;
    font-size: 20px;
    font-weight: bold;
  }
  p {
    color: #333333;
    line-height: 1.6;
    font-size: 15px;
  }
  .footer {
    margin-top: 25px;
    font-size: 13px;
    color: #777777;
    text-align: center;
  }
  a {
    color: #dc2626;
    text-decoration: none;
    font-weight: bold;
  }
</style>
</head>
<body>
  <div class='email-container'>
    <div class='header'>Payment Not Completed ⚠️</div>
    <p>Hello There,</p>
    <p>
We noticed that you recently tried to purchase a course from G Security and Training, but it seems the payment didn’t go through successfully. We sincerely apologise for any inconvenience this may have caused.</p>

    <p>If there was an error or you’re facing any difficulties completing the payment, please don’t hesitate to get in touch with us at  <a href='tel:+447736540149'>+44 7736 540149</a>.</p>

    <p>Our team will be happy to help you sort it out quickly.</p>

    <p>Kind regards,<br>
    <strong>The G Security and Training Team</strong></p>

    <div class='footer'>
      This is an automated message. Please do not reply directly to this email.
    </div>
  </div>
</body>
</html>
    ";


  $headers_user = "MIME-Version: 1.0" . "\r\n";
  $headers_user .= "Content-type:text/html;charset=UTF-8" . "\r\n";
  $headers_user .= "From: Info@gsecurityandtraining.co.uk\r\n";
  $headers_user .= "Reply-To: Info@gsecurityandtraining.co.uk\r\n";

  mail($email, $user_subject, $user_body, $headers_user);

  // Redirect to failed page
  header("Location: payment-failed");
  exit;
}

if ($status == 'COMPLETED') {
  $sql = "UPDATE orders SET 
                    payment_status='$status' 
                WHERE email='$email'";
  if (mysqli_query($con, $sql)) {
    $msg = "payment status updated successfully!";
  } else {
    $msg = "Error: " . mysqli_error($con);
  }

  $course = $data['purchase_units'][0]['description'] ?? 'N/A';
  $price = $data['purchase_units'][0]['amount']['value'] ?? 'N/A';

  // Payment success
  $user_subject = "✅ Payment Successful";
  $user_body = "
    <html>
    <head>
    <style>
      body { font-family: Arial, sans-serif; background: #f8f8f8; margin: 0; padding: 20px; }
      .email-container { background: #fff; border-radius: 10px; padding: 20px; max-width: 600px; margin: auto; box-shadow: 0 3px 8px rgba(0,0,0,0.05); }
      .header { background: #16a34a; color: #fff; padding: 10px; border-radius: 8px; text-align: center; font-size: 20px; }
      p { color: #333; line-height: 1.5; }
      .footer { margin-top: 20px; font-size: 13px; color: #777; text-align: center; }
    </style>
    </head>
    <body>
    <div class='email-container'>
      <div class='header'>Payment Successful 🎉</div>
      <p>Hello There</strong>,</p>
      <p>Thank you for purchasing the course $course.</p>
      <p>Your payment of <strong>£$price</strong> has been successfully received.</p>
      <p><strong>Transaction ID:</strong> $transaction_id</p>
      <p>We’re excited to have you with us. You’ll receive your course access details soon.</p>
      <p>— The G Security and Training Team</p>
      <div class='footer'>This email confirms your payment. Please retain it for your records.</div>
    </div>
    </body>
    </html>
    ";

  $headers_user = "MIME-Version: 1.0" . "\r\n";
  $headers_user .= "Content-type:text/html;charset=UTF-8" . "\r\n";
  $headers_user .= "From: Info@gsecurityandtraining.co.uk\r\n";
  $headers_user .= "Reply-To: Info@gsecurityandtraining.co.uk\r\n";

  mail($email, $user_subject, $user_body, $headers_user);

}



// Email to user
$user_subject = "Payment Confirmation - Your Order";
$user_message = "Hi $payer_name,\n\nThank you for your payment.\nTransaction ID: $transaction_id\nStatus: $status\n\nRegards,\nYour Company";
$user_headers = "From: Info@gsecurityandtraining.co.uk\r\n";

mail($payer_email, $user_subject, $user_message, $user_headers);

// Email to owner
$owner_email = "Info@gsecurityandtraining.co.uk";
$owner_subject = "New Payment Received";
$owner_message = "New payment received:\n\nName: $payer_name\nEmail: $payer_email\nTransaction ID: $transaction_id\nStatus: $status";
$owner_headers = "From: Info@gsecurityandtraining.co.uk\r\n";

mail($owner_email, $owner_subject, $owner_message, $owner_headers);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Payment Successful</title>

</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PCQD3VJQ" height="0" width="0"
      style="display:none;visibility:hidden"></iframe></noscript>

  <div class="bg-white p-10 rounded-2xl shadow-xl text-center">
    <div class="text-green-500 mb-4">
      <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
      </svg>
    </div>
    <h1 class="text-2xl font-bold mb-2">Payment Successful</h1>
    <p class="text-gray-600 mb-4">Thank you, <?php echo htmlspecialchars($payer_name); ?>! Your payment was completed.
    </p>
    <div class="text-left mb-4">
      <p><strong>Transaction ID:</strong> <?php echo $transaction_id; ?></p>
      <p><strong>Status:</strong> <?php echo $status; ?></p>
      <p><strong>Email:</strong> <?php echo $payer_email; ?></p>
    </div>
    <a href="/" class="inline-block mt-4 px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">Back to Home</a>
  </div>
  <script src="https://cdn.tailwindcss.com"></script>
</body>

</html>