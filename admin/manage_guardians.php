<?php
session_start();
include '../config.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

// Fetch all guardians without filtering by user_id
$guardians = [];
$stmt = $conn->prepare("SELECT * FROM guardians");
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $guardians[] = $row;
}

// Handle adding a guardian
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_guardian'])) {
    $guardian_name = $_POST['guardian_name'];
    $guardian_phone = $_POST['guardian_phone'];
    $user_id = $_POST['user_id']; // Include user_id for adding a guardian

    // Insert into guardians table
    $stmt = $conn->prepare("INSERT INTO guardians (user_id, guardian_name, guardian_phone) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $guardian_name, $guardian_phone);
    
    if ($stmt->execute()) {
        $success_message = "Guardian added successfully!";
        header("Location: manage_guardians.php"); // Refresh to avoid resubmission
        exit();
    } else {
        $error_message = "Error: " . $stmt->error;
    }
}

// Handle deleting a guardian
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $stmt = $conn->prepare("DELETE FROM guardians WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    
    if ($stmt->execute()) {
        $success_message = "Guardian deleted successfully!";
        header("Location: manage_guardians.php"); // Refresh to avoid resubmission
        exit();
    } else {
        $error_message = "Error: " . $stmt->error;
    }
}

// Handle updating a guardian
if (isset($_POST['edit_guardian'])) {
    $guardian_id = $_POST['guardian_id'];
    $guardian_name = $_POST['guardian_name'];
    $guardian_phone = $_POST['guardian_phone'];
    $user_id = $_POST['user_id']; // Include user_id for updating a guardian

    $stmt = $conn->prepare("UPDATE guardians SET user_id = ?, guardian_name = ?, guardian_phone = ? WHERE id = ?");
    $stmt->bind_param("issi", $user_id, $guardian_name, $guardian_phone, $guardian_id);
    
    if ($stmt->execute()) {
        $success_message = "Guardian updated successfully!";
        header("Location: manage_guardians.php"); // Refresh to avoid resubmission
        exit();
    } else {
        $error_message = "Error: " . $stmt->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Guardians</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            padding: 40px;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Manage Guardians</h2>

    <!-- Display success or error message -->
    <?php if (isset($success_message)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $success_message; ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <!-- Add Guardian Form -->
    <form method="POST" action="manage_guardians.php" class="mb-4">
        <div class="mb-3">
            <label for="guardian_name" class="form-label">Guardian Name</label>
            <input type="text" class="form-control" id="guardian_name" name="guardian_name" placeholder="Guardian Name" required>
        </div>

        <div class="mb-3">
            <label for="guardian_phone" class="form-label">Guardian Phone Number</label>
            <input type="text" class="form-control" id="guardian_phone" name="guardian_phone" placeholder="Guardian Phone Number" required>
        </div>

        <button type="submit" name="add_guardian" class="btn btn-primary">Add Guardian</button>
    </form>

    <!-- Guardians Table -->
    <h4>Existing Guardians</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($guardians as $guardian): ?>
                <tr>
                    <td><?php echo htmlspecialchars($guardian['guardian_name']); ?></td>
                    <td><?php echo htmlspecialchars($guardian['guardian_phone']); ?></td>
                    <td>
                        <!-- Edit Guardian -->
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $guardian['id']; ?>">Edit</button>
                        <!-- Delete Guardian -->
                        <a href="?delete_id=<?php echo $guardian['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this guardian?')">Delete</a>
                    </td>
                </tr>

                <!-- Edit Guardian Modal -->
                <div class="modal fade" id="editModal<?php echo $guardian['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Guardian</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="manage_guardians.php">
                                    <input type="hidden" name="guardian_id" value="<?php echo $guardian['id']; ?>">
                                    <div class="mb-3">
                                        <label for="guardian_name" class="form-label">Guardian Name</label>
                                        <input type="text" class="form-control" name="guardian_name" value="<?php echo htmlspecialchars($guardian['guardian_name']); ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="guardian_phone" class="form-label">Guardian Phone Number</label>
                                        <input type="text" class="form-control" name="guardian_phone" value="<?php echo htmlspecialchars($guardian['guardian_phone']); ?>" required>
                                    </div>

                                    <button type="submit" name="edit_guardian" class="btn btn-primary">Update Guardian</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="index.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
