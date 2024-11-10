<?php
session_start();
include('../config.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $complaint_type = $_POST['complaint_type'];
    $complaint_details = $_POST['complaint_details'];
    $user_id = $_SESSION['user_id']; // Get logged-in user's ID

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("INSERT INTO complaints (user_id, complaint_type, complaint_details) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $complaint_type, $complaint_details);

    if ($stmt->execute()) {
        $success_message = "Complaint submitted successfully.";
    } else {
        $error_message = "Failed to submit the complaint. Please try again.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Complaint</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('../images/background.jpg'); /* Add your background image */
            background-size: cover;
            background-position: center;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9); /* Add white background with transparency */
            padding: 30px;
            margin-top: 50px;
            border-radius: 10px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1); /* Box shadow */
        }
        .form-control {
            margin-bottom: 20px;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
            margin-top: 10px;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .btn-back {
            margin-top: 20px;
            background-color: #6c757d;
            color: white;
        }
        .btn-back:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Submit a New Complaint</h2>

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

    <form action="submit_complaint.php" method="POST">
        <!-- Complaint Type -->
        <div class="mb-3">
            <label for="complaint_type" class="form-label">Complaint Type</label>
            <select name="complaint_type" id="complaint_type" class="form-select form-control" required>
                <option value="Harassment">Harassment</option>
                <option value="Assault">Assault</option>
                <option value="Robbery">Robbery</option>
                <option value="Others">Others</option>
            </select>
        </div>

        <!-- Complaint Details -->
        <div class="mb-3">
            <label for="complaint_details" class="form-label">Complaint Details</label>
            <textarea name="complaint_details" id="complaint_details" class="form-control" rows="5" required></textarea>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-custom w-100">Submit Complaint</button>
    </form>

    <!-- Back Button -->
    <a href="index.php" class="btn btn-back w-100 mt-3">Back to Dashboard</a>
</div>

<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>