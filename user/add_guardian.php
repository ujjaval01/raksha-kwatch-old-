<?php
session_start();
include '../config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $guardian_name = $_POST['guardian_name'];
    $guardian_phone = $_POST['guardian_phone'];

    // Insert into guardians table
    $stmt = $conn->prepare("INSERT INTO guardians (user_id, guardian_name, guardian_phone) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $guardian_name, $guardian_phone);
    
    if ($stmt->execute()) {
        $success_message = "Guardian added successfully!";
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
    <title>Add Guardian</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
        }
        .form-control {
            margin-bottom: 20px;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .alert {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Add Guardian</h2>

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
    <form method="POST" action="add_guardian.php">
        <div class="mb-3">
            <label for="guardian_name" class="form-label">Guardian Name</label>
            <input type="text" class="form-control" id="guardian_name" name="guardian_name" placeholder="Guardian Name" required>
        </div>

        <div class="mb-3">
            <label for="guardian_phone" class="form-label">Guardian Phone Number</label>
            <input type="text" class="form-control" id="guardian_phone" name="guardian_phone" placeholder="Guardian Phone Number" required>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-custom w-100">Add Guardian</button>

        <!-- Back Button -->
        <a href="index.php" class="btn btn-secondary w-100 mt-3">Back to Dashboard</a>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
