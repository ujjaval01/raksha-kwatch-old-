<?php
session_start();
include '../config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php'); // Redirect to login if not logged in
    exit();
}

// Handle adding a new user
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $user_password = password_hash($_POST['user_password'], PASSWORD_DEFAULT); // Hash the password

    // Insert into users table
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user_name, $user_email, $user_password);
    
    if ($stmt->execute()) {
        $success_message = "User added successfully!";
    } else {
        $error_message = "Error: " . $stmt->error;
    }
}

// Handle deleting a user
if (isset($_GET['delete'])) {
    $user_id = $_GET['delete'];
    $delete_stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $delete_stmt->bind_param("i", $user_id);
    $delete_stmt->execute();
}

$users = $conn->query("SELECT * FROM users")->fetch_all(MYSQLI_ASSOC); // Fetch existing users
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #d2b48c; /* Light brown color */
        }
        h2 {
            color: #007bff;
        }
        .container {
            margin-top: 20px;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            padding: 10px;
            background-color: #343a40;
            color: white;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <h2>Manage Users</h2>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <?php if (isset($success_message)) echo "<div class='alert alert-success'>$success_message</div>"; ?>
    <?php if (isset($error_message)) echo "<div class='alert alert-danger'>$error_message</div>"; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="user_name" class="form-label">User Name</label>
            <input type="text" class="form-control" name="user_name" required>
        </div>
        <div class="mb-3">
            <label for="user_email" class="form-label">User Email</label>
            <input type="email" class="form-control" name="user_email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">User Password</label>
            <input type="password" class="form-control" name="user_password" required>
        </div>
        <button type="submit" class="btn btn-primary">Add User</button>
    </form>

    <h3 class="mt-4">Existing Users</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Password (hashed)</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) { ?>
            <tr>
                <td><?php echo htmlspecialchars($user['name']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['password']); ?></td> <!-- Display hashed password -->
                <td><a href="?delete=<?php echo $user['id']; ?>" class="btn btn-danger">Delete</a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- <footer class="footer">
    <div class="container">
        <span>&copy; 2024 Women Safety System | All Rights Reserved</span>
    </div>
</footer> -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
