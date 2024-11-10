<?php
session_start();
include '../config.php';

// Check if the user is logged in
if (!isset($_SESSION['police_id'])) {
    header('Location: police_login.php'); // Redirect to login if not logged in
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $complaint_id = $_POST['complaint_id'];
    $status = $_POST['status'];

    // Update complaint status
    $stmt = $conn->prepare("UPDATE complaints SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $complaint_id);

    if ($stmt->execute()) {
        $success_message = "Complaint status updated successfully.";
    } else {
        $error_message = "Failed to update status. Please try again.";
    }

    $stmt->close();
}

// Retrieve complaints for selection
$stmt = $conn->prepare("SELECT * FROM complaints");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Complaint Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Update Complaint Status</h2>
        <?php if (isset($success_message)) echo "<div class='alert alert-success'>$success_message</div>"; ?>
        <?php if (isset($error_message)) echo "<div class='alert alert-danger'>$error_message</div>"; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="complaint_id" class="form-label">Select Complaint</label>
                <select name="complaint_id" id="complaint_id" class="form-select" required>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['complaint_type']); ?> - <?php echo htmlspecialchars($row['complaint_details']); ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Update Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="Pending">Pending</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Resolved">Resolved</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Status</button>
        </form>
        <a href="index.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
