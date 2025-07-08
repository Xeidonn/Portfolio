<?php
// Replace with your real receiving email address
$receiving_email_address = 'mylesramirez0323@example.com';

// Only process POST requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Simple validation
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['message'])) {
        http_response_code(400);
        echo "Please complete all required fields.";
        exit;
    }

    // Sanitize input
    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $subject = isset($_POST['subject']) ? filter_var(trim($_POST['subject']), FILTER_SANITIZE_STRING) : "New Contact Form Message";
    $message = filter_var(trim($_POST['message']), FILTER_SANITIZE_STRING);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Invalid email address.";
        exit;
    }

    // Build email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    // Build email headers
    $email_headers = "From: $name <$email>";

    // Send the email
    if (mail($receiving_email_address, $subject, $email_content, $email_headers)) {
        echo "OK"; // This will trigger the success message in your JS
    } else {
        http_response_code(500);
        echo "Oops! Something went wrong, and we couldn't send your message.";
    }

} else {
    // Reject non-POST requests
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
?>
