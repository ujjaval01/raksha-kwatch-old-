<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: index.php");
        } else {
            $error_message = "Invalid password!";
        }
    } else {
        $error_message = "No user found with that email!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        .login-container {
            display: flex;
            height: 100vh;
            width: 100vw;
        }
        .login-form {
            flex: 2; /* 25% width */
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background-color: #ffffff;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            background-color: hsl(200, 15%, 90%);
        }
        .login-form-content {
            width: 100%;
            max-width: 300px;
        }
        .login-form h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .login-image {
            background-image: url('../images/user_login.jpg'); /* Replace with your image path */
            background-size: cover;
            background-position: center;
            flex: 4; /* 75% width */
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
        .no-underline {
            text-decoration: none;
        }
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }
            .login-image {
                height: 50vh;
                width: 100%;
                flex: unset;
            }
            .login-form {
                height: 50vh;
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <!-- Left side: Login form (25% of the page) -->
    <div class="login-form">
        <div class="login-form-content">
            <h2 class="text-center">User Login</h2>

            <?php if (isset($error_message)) echo "<div class='alert alert-danger'>$error_message</div>"; ?>

            <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                <div class="alert alert-success text-center">
                    Registration successful! You can now log in.
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <a href="forgot_password.php" class="no-underline">Forgot password?</a>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Login</button>
            </form>
            <p class="text-center mt-3">
                Don't have an account? <a href="register.php">Register here</a>.
            </p>
        </div>
    </div>

    <!-- Right side: Image (75% of the page) -->
    <div class="login-image"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
