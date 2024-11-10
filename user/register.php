<?php
session_start();
require '../config.php';
require 'C:\xampp\htdocs\women_safety_system\vendor\phpmailer\phpmailer\src\PHPMailer.php';
require 'C:\xampp\htdocs\women_safety_system\vendor\phpmailer\phpmailer\src\SMTP.php';
require 'C:\xampp\htdocs\women_safety_system\vendor\phpmailer\phpmailer\src\Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone_number = $_POST['phone_number'];
    $otp = rand(100000, 999999);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error_message = "Email already registered.";
    } else {
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        $_SESSION['phone_number'] = $phone_number;
        $_SESSION['otp'] = $otp;

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'sainiujvl@gmail.com';
            $mail->Password = 'dkuq puzg hxuj uawm';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('sainiujvl@gmail.com', 'Raksha Kawatch');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code';
            $mail->Body = "Hello $name,<br> welcome to <b>Raksha Kawatch</b>. Your OTP for registration is: <strong>$otp</strong>. This code is valid for 10 minutes. Please do not share this code with anyone. Stay safe.<br>Thank you for registering!";
            $mail->send();

            header("Location: verify_otp.php");
            exit;
        } catch (Exception $e) {
            $error_message = "Error sending OTP. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .register-container {
            display: flex;
            height: 100vh;
            width: 100vw;
        }
        .register-form {
            flex: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background-color: hsl(200, 15%, 90%);
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }
        .register-form-content {
            width: 100%;
            max-width: 300px;
        }
        .register-form h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .register-image {
            background-image: url('../images/user_reg.jpg'); /* Replace with your image path */
            background-size: cover;
            background-position: center;
            flex: 4;
        }
        .btn-primary {
            background-color: #004e92;
            border: none;
            width: 100%;
            padding: 10px;
            transition: background 0.3s ease;
            border-radius: 8px;
        }
        .btn-primary:hover {
            background-color: #0059b3;
        }
        .alert {
            margin-bottom: 15px;
            border-radius: 5px;
            padding: 10px;
        }
        @media (max-width: 768px) {
            .register-container {
                flex-direction: column;
            }
            .register-image {
                height: 50vh;
                width: 100%;
                flex: unset;
            }
            .register-form {
                height: 50vh;
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="register-container">
    <!-- Left side: Registration form (25% of the page) -->
    <div class="register-form">
        <div class="register-form-content">
            <h2 class="text-center">User Registration</h2>
            <?php if ($error_message): ?>
                <div class="alert alert-danger"><?= $error_message ?></div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="form-group mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label>Phone Number</label>
                    <input type="text" name="phone_number" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
            <p class="text-center mt-3">Already have an account? <a href="login.php">Login here</a>.</p>
        </div>
    </div>

    <!-- Right side: Image (75% of the page) -->
    <div class="register-image"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
