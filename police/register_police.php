<?php
session_start();
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $station = $_POST['station'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password

    // Insert into the database
    $stmt = $conn->prepare("INSERT INTO police (name, station, email, phone_number, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $station, $email, $phone_number, $password);

    if ($stmt->execute()) {
        $success_message = "Police personnel registered successfully.";
    } else {
        $error_message = "Failed to register. Please try again.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Police</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .register-image {
            background-image: url('../images/police_reg.jpg'); /* Replace with your image path */
            background-size: cover;
            background-position: center;
            flex: 3; /* 75% width */
        }
        .register-form {
            flex: 1; /* 25% width */
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background-color: #ffffff;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
            background-color: hsl(200, 15%, 90%);
        }
        .register-form-content {
            width: 100%;
            max-width: 300px;
        }
        .register-form h2 {
            margin-bottom: 20px;
            text-align: center;
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
        .btn-secondary {
            width: 100%;
            background-color: #6c757d;
            border: none;
            transition: background 0.3s ease;
            border-radius: 8px;
            padding: 10px;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
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
    <!-- Left side: Image (75% of the page) -->
    <div class="register-image"></div>

    <!-- Right side: Registration form (25% of the page) -->
    <div class="register-form">
        <div class="register-form-content">
            <h2>Register Police</h2>
            <?php if (isset($success_message)) echo "<div class='alert alert-success'>$success_message</div>"; ?>
            <?php if (isset($error_message)) echo "<div class='alert alert-danger'>$error_message</div>"; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" id="name" required>
                </div>
                <div class="mb-3">
                    <label for="station" class="form-label">Station</label>
                    <input type="text" class="form-control" name="station" id="station" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" name="phone_number" id="phone_number" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Register</button>
            </form>
            <a href="login_police.php" class="btn btn-secondary mt-3">Already have an account? Login</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
