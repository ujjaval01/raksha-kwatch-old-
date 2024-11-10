<?php
session_start();
require '../config.php';

$error_message = '';
$success_message = '';

// Ensure that the user is logged in and the email session variable is set
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_SESSION['email'];  // Accessing session email after ensuring it's set

    // Check if the new password and confirm password match
    if ($new_password !== $confirm_password) {
        $error_message = "Passwords do not match. Please try again.";
    } else {
        // Hash the new password before updating
        $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);

        // Update password in the database
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $new_password_hashed, $email);

        if ($stmt->execute()) {
            $success_message = "Password updated successfully! You can now log in.";
            session_unset();
            session_destroy();
        } else {
            $error_message = "Error updating password. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6D5B8B, #B3A0D2);
            font-family: 'Arial', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            width: 400px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            background: white;
            padding: 30px;
        }

        .card h2 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
            color: #4A3F6B;
        }

        .alert {
            margin-bottom: 20px;
        }

        .btn {
            background-color: #6D5B8B;
            color: white;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #4A3F6B;
        }

        .form-control {
            border-radius: 8px;
        }

        .container {
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
        }
    </style>
</head>
<body>

    <div class="container shadow-lg p-5 rounded">
        <div class="card">
            <h2>Reset Password</h2>

            <!-- Error and Success Messages -->
            <?php if ($error_message): ?>
                <div class="alert alert-danger"><?= $error_message ?></div>
            <?php endif; ?>
            <?php if ($success_message): ?>
                <div class="alert alert-success"><?= $success_message ?></div>
            <?php endif; ?>

            <!-- Form for password reset -->
            <form method="POST" action="reset_password.php">
                <div class="mb-3">
                    <label for="new_password" class="form-label">New Password</label>
                    <input type="password" name="new_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Reset Password</button>
                <button type="button" class="btn btn-secondary w-100 mt-2" onclick="window.location.href='login.php'">Confirm</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
