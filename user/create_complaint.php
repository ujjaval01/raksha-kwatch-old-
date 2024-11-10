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
    $complaint_type = $_POST['complaint_type'];
    $complaint_details = $_POST['complaint_details'];

    // Insert into complaints table
    $stmt = $conn->prepare("INSERT INTO complaints (user_id, complaint_type, complaint_details) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $complaint_type, $complaint_details);
    
    if ($stmt->execute()) {
        echo "Complaint submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<h2>Create a Complaint</h2>
<form method="POST" action="create_complaint.php">
    <input type="text" name="complaint_type" placeholder="Complaint Type" required>
    <textarea name="complaint_details" placeholder="Complaint Details" required></textarea>
    <button type="submit">Submit Complaint</button>
</form>
