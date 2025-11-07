<?php 
// script to send an e-mail

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect data from form
    $name = htmlspecialchars($_POST['name']);
	$phone = htmlspecialchars($_POST['phone']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars($_POST['message']);

    // validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit;
    }

    // email details
    $to = "cla.radu@crgames.elementfx.com"; // destination
	$subject = "From " . $email . " ( phone: " . $phone . " ) ";
    $headers = "From: $email" . "\r\n" .
               "Reply-To: $email" . "\r\n" .
               "X-Mailer: PHP/" . phpversion();

    // send email
    if (mail($to, $subject, $message, $headers)) {
        echo "Email sent successfully!";
    } else {
        echo "Failed to send email.";
    }
} else {
    echo "Invalid request method.";
}

echo "<br><a href='../db_main.php'>Go Back</a>";
?>
