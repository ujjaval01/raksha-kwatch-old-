<?php 
session_start();

// Define admin credentials
define('ADMIN_USERNAME', 'ujjaval');
define('ADMIN_PASSWORD', 'saini');

// Handle login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === ADMIN_USERNAME && $password === ADMIN_PASSWORD) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: index.php'); // Redirect to admin dashboard
        exit();
    } else {
        $error_message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Full-screen gradient background */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            font-family: Arial, sans-serif;
        }
        /* Container holding both the image and form */
        .login-container {
            display: flex;
            height: 80vh;
            width: 80vw;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            background-color: #f8f9fa;
        }
        /* Left-side image styling */
        .login-image {
            background-image: url('../images/admin.png'); /* Replace with your image path */
            background-size: cover;
            background-position: center;
            flex: 3;
        }
        /* Right-side form styling */
        .login-form {
            flex: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background-color: #ffffff;
        }
        /* Form styling */
        .login-form-content {
            width: 100%;
            max-width: 350px;
            text-align: center;
        }
        .login-form h2 {
            margin-bottom: 30px;
            color: #343a40;
            font-weight: 700;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #ced4da;
        }
        .btn-primary {
            background-color: #6a11cb;
            border: none;
            transition: background 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #2575fc;
        }
        .btn-secondary {
            border: none;
            background-color: #adb5bd;
            transition: background 0.3s ease;
        }
        .btn-secondary:hover {
            background-color: #6c757d;
        }
        /* Error message styling */
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
        }
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                width: 90vw;
                height: auto;
            }
            .login-image {
                height: 200px;
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
            <h2>Admin Login</h2>
            <?php if (isset($error_message)) { ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php } ?>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-primary px-4">Login</button>
                    <a href="../index.php" class="btn btn-secondary px-4">Dashboard</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
