<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php'); // Redirect to login if not logged in
    exit();
}

include '../config.php'; // Include your database connection

// Retrieve complaints
$complaints = $conn->query("SELECT * FROM complaints")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Complaints</title>
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
        <h2>View Complaints</h2>
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
    <table class="table table-striped table-bordered">
        <thead class="table-light">
            <tr>
                <th>Complaint Type</th>
                <th>Details</th>
                <th>Status</th>
                <th>Date Submitted</th>
                <th>User ID</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($complaints as $complaint) { ?>
            <tr>
                <td><?php echo htmlspecialchars($complaint['complaint_type']); ?></td>
                <td><?php echo htmlspecialchars($complaint['complaint_details']); ?></td>
                <td><?php echo htmlspecialchars($complaint['status']); ?></td>
                <td><?php echo htmlspecialchars($complaint['date_created']); ?></td>
                <td><?php echo htmlspecialchars($complaint['user_id']); ?></td>
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
