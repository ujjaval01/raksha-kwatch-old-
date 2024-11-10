<?php
session_start();
include '../config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php'); // Redirect to login if not logged in
    exit();
}

// Handle adding a new police officer
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $officer_name = $_POST['officer_name'];
    $station_name = $_POST['station_name'];
    $officer_email = $_POST['officer_email'];
    $officer_phone = $_POST['officer_phone'];

    // Insert into police table
    $stmt = $conn->prepare("INSERT INTO police (name, station, email, phone_number) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $officer_name, $station_name, $officer_email, $officer_phone);
    
    if ($stmt->execute()) {
        $success_message = "Police officer added successfully!";
    } else {
        $error_message = "Error: " . $stmt->error;
    }
}

// Handle deleting a police officer
if (isset($_GET['delete'])) {
    $officer_id = $_GET['delete'];
    $delete_stmt = $conn->prepare("DELETE FROM police WHERE id = ?");
    $delete_stmt->bind_param("i", $officer_id);
    $delete_stmt->execute();
}

// Fetch existing police officers
$police_officers = $conn->query("SELECT * FROM police")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Police</title>
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
        <h2>Manage Police</h2>
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
            <label for="name" class="form-label">Officer Name</label>
            <input type="text" class="form-control" name="officer_name" required>
        </div>
        <div class="mb-3">
            <label for="station" class="form-label">Station Name</label>
            <input type="text" class="form-control" name="station_name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Officer Email</label>
            <input type="email" class="form-control" name="officer_email" required>
        </div>
        <div class="mb-3">
            <label for="phone_number" class="form-label">Officer Phone Number</label>
            <input type="text" class="form-control" name="officer_phone" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Police Officer</button>
    </form>

    <h3 class="mt-4">Existing Police Officers</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Station</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($police_officers as $officer) { ?>
            <tr>
                <td><?php echo htmlspecialchars($officer['name']); ?></td>
                <td><?php echo htmlspecialchars($officer['station']); ?></td>
                <td><?php echo htmlspecialchars($officer['email']); ?></td>
                <td><?php echo htmlspecialchars($officer['phone_number']); ?></td>
                <td><a href="?delete=<?php echo $officer['id']; ?>" class="btn btn-danger">Delete</a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
