<?php
include("admin/assets/config/db.php");

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

// if ($httpcode !== 201) {
//   die("<h2>Failed to capture payment.</h2><pre>$response</pre>");
// }

$data = json_decode($response, true);
$capture = $data['purchase_units'][0]['payments']['captures'][0] ?? null;
$status = $capture['status'] ?? null;
// Capture was successful
$transaction_id = $capture['id'];
$payer_email = $data['payer']['email_address'];
$payer_name = $data['payer']['name']['given_name'] . ' ' . $data['payer']['name']['surname'];
$email = $data['payer']['email_address'];

$query = "SELECT email_sent FROM orders WHERE paypal_order_id='$order_id' LIMIT 1";
$query_run = mysqli_query($con, $query);

if (!$query_run) {
    die("Query failed: " . mysqli_error($con));
}
$order = mysqli_fetch_assoc($query_run);
        
if ($status === 'COMPLETED' && $order['email_sent'] == 0) {
//           $sql = "
//         UPDATE orders 
//         SET payment_status='completed'
//         WHERE paypal_order_id='$order_id'
//         LIMIT 1
//     ";

//   if (mysqli_query($con, $sql)) {
//     $msg = "payment status updated successfully!";
//   } else {
//     $msg = "Error: " . mysqli_error($con);
//   }

  // Payment success
  $user_subject = "✅ Payment Successful";
  $user_body = "
<html>
<head>
  <meta charset='UTF-8'>
  <style>
    body {
      font-family: Arial, Helvetica, sans-serif;
      background-color: #f3f4f6;
      margin: 0;
      padding: 20px;
    }
    .email-wrapper {
      max-width: 650px;
      margin: auto;
      background: #ffffff;
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.06);
    }
    .header {
      background: #16a34a;
      color: #ffffff;
      padding: 15px;
      border-radius: 8px;
      text-align: center;
      font-size: 22px;
      font-weight: bold;
    }
    p {
      color: #333333;
      line-height: 1.6;
      font-size: 15px;
      margin: 14px 0;
    }
    ul {
      margin: 10px 0 10px 20px;
      padding: 0;
    }
    li {
      margin-bottom: 8px;
      font-size: 14.5px;
      color: #333;
    }
    .highlight {
      background: #f0fdf4;
      border-left: 5px solid #16a34a;
      padding: 15px;
      margin: 20px 0;
      border-radius: 6px;
    }
    .footer {
      margin-top: 30px;
      text-align: center;
      font-size: 13px;
      color: #6b7280;
    }
    .footer img {
      max-width: 100%;
      margin-top: 20px;
      border-radius: 6px;
    }
  </style>
</head>

<body>
  <div class='email-wrapper'>
    <div class='header'>Payment Successful 🎉</div>

    <p><strong>Dear Applicant,</strong></p>

    <p>
      Thank you for booking your <strong>SIA Security Course</strong> with 
      <strong>G Security & Training</strong>. We are pleased to confirm that 
      your place on the course has been successfully secured.
    </p>

    <p>
      A member of our team will contact you shortly via call or message to provide 
      all relevant course information, including training arrangements and requirements.
      Please ensure your contact details are correct and keep an eye out for further communication from us.
    </p>

    <p><strong>Important Information:</strong></p>
    <ul>
      <li>Attendance on all training days is mandatory. Training hours are set by the SIA and learners must remain for the full duration of each day.</li>
      <li>Please avoid booking any travel before the scheduled course finishing time.</li>
      <li>If your course includes physical intervention training, suitable clothing (trainers & joggers) must be worn.</li>
    </ul>

    <p><strong>Additional Support:</strong></p>
    <p>
      If you have any learning difficulties, medical conditions, or specific learning needs,
      please inform us in advance. All information shared will be treated confidentially.
    </p>

    <p>
      If you have any questions, please feel free to contact us.
      We look forward to welcoming you to <strong>G Security & Training</strong>.
    </p>

    <div class='footer'>
      <p>
        <strong>G Security & Training</strong><br>
        Email: info@gsecurityandtraining.co.uk<br>
        Phone: 07736 540149
      </p>

      <!-- Footer Image -->
      <img src='https://res.cloudinary.com/df0mvniha/image/upload/v1767375669/change_badge_prizvq.png'
           alt='G Security & Training Footer'>
    </div>
  </div>
</body>
</html>
";


  $headers_user = "MIME-Version: 1.0" . "\r\n";
  $headers_user .= "Content-type:text/html;charset=UTF-8" . "\r\n";
  $headers_user .= "From: Info@gsecurityandtraining.co.uk\r\n";
  $headers_user .= "Reply-To: Info@gsecurityandtraining.co.uk\r\n";

//   mail($payer_email, $user_subject, $user_body, $headers_user);

$mailSent = mail($payer_email, $user_subject, $user_body, $headers_user);

if ($mailSent) {
             $sql = "
        UPDATE orders 
        SET payment_status='completed'
        WHERE paypal_order_id='$order_id'
        LIMIT 1
    ";

  if (mysqli_query($con, $sql)) {
    $msg = "payment status updated successfully!";
  } else {
    $msg = "Error: " . mysqli_error($con);
  }
}

}
else{

  // Payment failed
  $user_subject = "⚠️ Payment Not Completed ";
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
        <p>
        <strong>G Security & Training</strong><br>
        Email: info@gsecurityandtraining.co.uk<br>
        Phone: 07736540149
      </p>

      <!-- Footer Image -->
      <img src='https://res.cloudinary.com/df0mvniha/image/upload/v1767375669/change_badge_prizvq.png'
           alt='G Security & Training Footer'>
    </div>
  </div>
</body>
</html>
    ";


  $headers_user = "MIME-Version: 1.0" . "\r\n";
  $headers_user .= "Content-type:text/html;charset=UTF-8" . "\r\n";
  $headers_user .= "From: Info@gsecurityandtraining.co.uk\r\n";
  $headers_user .= "Reply-To: Info@gsecurityandtraining.co.uk\r\n";

  mail($payer_email, $user_subject, $user_body, $headers_user);

  // Redirect to failed page
  header("Location: payment-failed");
  exit;

}


// Email to owner
$owner_email = "Info@gsecurityandtraining.co.uk";
$owner_subject = "New Payment Received";
$owner_message = "
<html>
  <body style='font-family: Arial, sans-serif; color: #000;'>

    <p>
      <strong>New payment received:</strong><br><br>
      <strong>Name:</strong> {$payer_name}<br>
      <strong>Email:</strong> {$payer_email}<br>
      <strong>Transaction ID:</strong> {$transaction_id}<br>
      <strong>Status:</strong> {$status}
    </p>

    <hr style='margin:20px 0;'>

    <!-- Footer -->
    <p>
      <strong>G Security & Training</strong><br>
      Email: info@gsecurityandtraining.co.uk<br>
      Phone: 07736 540149
    </p>

    <img
      src='https://res.cloudinary.com/df0mvniha/image/upload/v1767375669/change_badge_prizvq.png'
      alt='G Security & Training Footer'
      style='max-width:200px; margin-top:10px;'
    >

  </body>
</html>
";

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