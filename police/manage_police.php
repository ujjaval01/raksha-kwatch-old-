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
</head>
<body>
<div class="container">
    <h2>Manage Police</h2>

    <?php if (isset($success_message)) echo "<div class='alert alert-success'>$success_message</div>"; ?>
    <?php if (isset($error_message)) echo "<div class='alert alert-danger'>$error_message</div>"; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="officer_name" class="form-label">Officer Name</label>
            <input type="text" class="form-control" name="officer_name" required>
        </div>
        <div class="mb-3">
            <label for="station_name" class="form-label">Station Name</label>
            <input type="text" class="form-control" name="station_name" required>
        </div>
        <div class="mb-3">
            <label for="officer_email" class="form-label">Officer Email</label>
            <input type="email" class="form-control" name="officer_email" required>
        </div>
        <div class="mb-3">
            <label for="officer_phone" class="form-label">Officer Phone Number</label>
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
