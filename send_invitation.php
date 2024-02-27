<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'C:\Program Files\Ampps\www\Exception.php';
require 'C:\Program Files\Ampps\www\PHPMailer.php';
require 'C:\Program Files\Ampps\www\SMTP.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve guest name and email from the POST request
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Validate the email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Invalid email address";
        exit();
    }

    // Send invitation email using Gmail SMTP
    $mail = new PHPMailer(true); // Passing `true` enables exceptions

    try {
        //Server settings
        $mail->isSMTP(); // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'RSALEMALMALKI0001@stu.kau.edu.sa'; // SMTP username
        $mail->Password = 'Aa117836674'; // SMTP password
        $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587; // TCP port to connect to

        //Recipients
        $mail->setFrom('notamanar@gmail.com', 'RAZAN'); // Replace with your email address and name
        $mail->addAddress($email, $name); // Add a recipient

        //Content
        $mail->isHTML(false); // Set email format to HTML
        $mail->Subject = 'Invitation to our wedding';
        $mail->Body = "Dear $name,\n\nYou are invited to our wedding. Please RSVP to confirm your attendance.\n\nBest regards,\n[Your Name]";

         $mail->send();
        echo "Invitation email sent successfully";
    } catch (Exception $e) {
    if (!empty($e)) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    } else {
        echo "An unexpected error occurred.";
    }
    http_response_code(500);
}
} else {
    // Not a POST request, return an error
    http_response_code(405);
    echo "Method Not Allowed";
}
?>