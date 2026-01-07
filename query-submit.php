<?php
$msg = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize inputs
    $firstName = htmlspecialchars(trim($_POST['firstName']));
    $lastName = htmlspecialchars(trim($_POST['lastName']));
    $contact = htmlspecialchars(trim($_POST['contact']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(trim($_POST['message']));

    // Email details
    $to = "Info@gsecurityandtraining.co.uk";
    $subject = "New Contact Form Submission from $firstName $lastName";

    $body = "You have received a new message from your website contact form.\n\n";
    $body .= "First Name: $firstName\n";
    $body .= "Last Name: $lastName\n";
    $body .= "Contact: $contact\n";
    $body .= "Email: $email\n\n";
    $body .= "Message:\n$message\n";

    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Send email
    if (mail($to, $subject, $body, $headers)) {
        $msg = "Thank you! Your message has been sent.";
    } else {
        echo "Sorry, something went wrong. Please try again later.";
    }
} else {
    // echo "Invalid request.";
}
?>