<?php
session_start();
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Retrieve the police record by email
    $stmt = $conn->prepare("SELECT * FROM police WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
        // Verify the password
        if (password_verify($password, $row['password'])) {
            $_SESSION['police_id'] = $row['id']; // Store police ID in session
            header('Location: index.php'); // Redirect to police dashboard
            exit();
        } else {
            $error_message = "Invalid email or password.";
        }
    } else {
        $error_message = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Police Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #004e92;
            /* background: linear-gradient(to right, #004e92, #000410); */
            font-family: Arial, sans-serif;
        }
        .login-container {
            display: flex;
            width: 80vw;
            height: 70vh;
            max-width: 1000px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            background-color: #ffffff;
        }
        .login-image {
            background-image: url('../images/police_login.webp'); /* Replace with your image path */
            background-size: cover;
            background-position: center;
            flex: 2;
        }
        .login-form {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background-color: #f8f9fa;
        }
        .login-form-content {
            width: 100%;
            max-width: 350px;
            text-align: center;
        }
        .login-form h2 {
            margin-bottom: 20px;
            color: #343a40;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #ced4da;
        }
        .btn-primary {
            background-color: #004e92;
            border: none;
            transition: background 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0059b3;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
            transition: background 0.3s ease;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
        }
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                width: 90vw;
                height: auto;
            }
            .login-image {
                height: 200px;
                width: 100%;
            }
            .login-form {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <!-- Left side: Image (75% of the page) -->
    <div class="login-image"></div>

    <!-- Right side: Login form (25% of the page) -->
    <div class="login-form">
        <div class="login-form-content">
            <h2>Police Login</h2>
            <?php if (isset($error_message)) { ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php } ?>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-3">Login</button>
                <a href="register_police.php" class="btn btn-secondary w-100 mt-3">Don't have an account? Register</a>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
