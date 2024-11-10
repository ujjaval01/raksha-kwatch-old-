<?php
session_start();
include '../config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Retrieve complaints for the logged-in user
$stmt = $conn->prepare("SELECT complaint_type, complaint_details, status, date_created FROM complaints WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Complaints</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #007bff;
            margin-bottom: 20px;
            text-align: center;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f3f5;
        }
        .status-pending {
            color: #ffc107;
            font-weight: bold;
        }
        .status-resolved {
            color: #28a745;
            font-weight: bold;
        }
        .status-inprogress {
            color: #17a2b8;
            font-weight: bold;
        }
        .btn-back {
            background-color: #6c757d;
            color: white;
            margin-top: 20px;
        }
        .btn-back:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Your Complaints</h2>

    <!-- Complaints Table -->
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th scope="col">Complaint Type</th>
                <th scope="col">Details</th>
                <th scope="col">Status</th>
                <th scope="col">Date Submitted</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['complaint_type']); ?></td>
                <td><?php echo htmlspecialchars($row['complaint_details']); ?></td>
                <td>
                    <?php 
                    if ($row['status'] == 'Pending') {
                        echo "<span class='status-pending'>Pending</span>";
                    } elseif ($row['status'] == 'Resolved') {
                        echo "<span class='status-resolved'>Resolved</span>";
                    } else {
                        echo "<span class='status-inprogress'>In Progress</span>";
                    }
                    ?>
                </td>
                <td><?php echo isset($row['date_created']) ? htmlspecialchars($row['date_created']) : 'N/A'; ?></td> <!-- Fallback for date_created -->
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Back Button -->
    <a href="index.php" class="btn btn-back">Back to Dashboard</a>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
