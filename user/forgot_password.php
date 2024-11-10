<?php
session_start();
require '../config.php'; // Database configuration
require 'C:\xampp\htdocs\women_safety_system\vendor\phpmailer\phpmailer\src\PHPMailer.php';
require 'C:\xampp\htdocs\women_safety_system\vendor\phpmailer\phpmailer\src\SMTP.php';
require 'C:\xampp\htdocs\women_safety_system\vendor\phpmailer\phpmailer\src\Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $otp = rand(100000, 999999); // Generate a random OTP

    // Check if the email exists in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Send OTP email using PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'sainiujvl@gmail.com'; // Your email
            $mail->Password = 'dkuq puzg hxuj uawm'; // Your app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('sainiujvl@gmail.com', 'Raksha Kawatch');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code for Password Reset';
            $mail->Body = "Hello $name,<br> welcome to <b>Rasha Kawatch</b>, A Women Safety & Security System. Your One-Time Password (OTP) for password reset is:  <strong>$otp</strong>. This code is valid for 10 minutes. Please do not share this code with anyone. Stay safe.<br>Thank You!";

            $mail->send();

            // Store the OTP in the session
            $_SESSION['otp'] = $otp;
            $_SESSION['email'] = $email;

            // Redirect to verify OTP page
            header("Location: verify_forgot_otp.php");
            exit;
        } catch (Exception $e) {
            $error_message = "Error sending OTP. Please try again.";
        }
    } else {
        $error_message = "Email not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg p-4" style="width: 400px;">
            <h2 class="text-center mb-4">Forgot Password</h2>
            <?php if ($error_message): ?>
                <div class="alert alert-danger"><?= $error_message ?></div>
            <?php endif; ?>
            <form method="POST" action="forgot_password.php">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Send OTP</button>
            </form>
        </div>
    </div>
</body>
</html>
