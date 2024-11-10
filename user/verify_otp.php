<?php
session_start();
require '../config.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $entered_otp = $_POST['otp'];

    // Check if the entered OTP matches the session OTP
    if ($entered_otp == $_SESSION['otp']) {
        $name = $_SESSION['name'];
        $email = $_SESSION['email'];
        $password = $_SESSION['password'];
        $phone_number = $_SESSION['phone_number'];

        // Save the user to the database
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, phone_number) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $password, $phone_number);

        if ($stmt->execute()) {
            // Unset the session variables
            session_unset();
            session_destroy();

            // Redirect to the login page
            header("Location: login.php?success=1");
            exit;
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Invalid OTP. Please try again.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg p-4" style="width: 400px;">
            <h2 class="text-center mb-4">OTP Verification</h2>
            <form method="POST" action="verify_otp.php">
                <div class="form-group mb-3">
                    <label>Enter OTP</label>
                    <input type="text" name="otp" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-2">Verify OTP</button>
                <a href="register.php" class="btn btn-secondary w-100">Go to Register Page</a>
            </form>
        </div>
    </div>
</body>
</html>


