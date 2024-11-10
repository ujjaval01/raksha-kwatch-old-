<?php
session_start();
include '../config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$error_message = '';
$success_message = '';

// Handle profile updates
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];

    // File upload
    $profile_photo = $_FILES['profile_photo'];
    $photo_path = null;

    if ($profile_photo['size'] > 0) {
        $photo_path = '../uploads/' . uniqid() . '_' . $profile_photo['name'];
        move_uploaded_file($profile_photo['tmp_name'], $photo_path);
    }

    // Update database
    $sql = "UPDATE users SET name=?, email=?, phone_number=?";
    $params = [$name, $email, $phone_number];

    // Only update photo if a new one was uploaded
    if ($photo_path) {
        $sql .= ", profile_photo=?";
        $params[] = $photo_path;
    }
    $sql .= " WHERE id=?";
    $params[] = $user_id;

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(str_repeat("s", count($params)), ...$params);

    if ($stmt->execute()) {
        $success_message = "Profile updated successfully!";
    } else {
        $error_message = "Error updating profile: " . $stmt->error;
    }
}

// Fetch current user data
$stmt = $conn->prepare("SELECT name, email, phone_number, profile_photo FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($name, $email, $phone_number, $profile_photo);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .profile-photo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2>Manage Profile</h2>

    <!-- Success and Error Messages -->
    <?php if ($success_message): ?>
        <div class="alert alert-success"><?= $success_message ?></div>
    <?php endif; ?>
    <?php if ($error_message): ?>
        <div class="alert alert-danger"><?= $error_message ?></div>
    <?php endif; ?>

    <form method="POST" action="manage_profile.php" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" value="<?= $name ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="<?= $email ?>" required>
        </div>
        <div class="mb-3">
            <label for="phone_number" class="form-label">Phone Number</label>
            <input type="text" class="form-control" name="phone_number" value="<?= $phone_number ?>" required>
        </div>
        <div class="mb-3">
            <label for="profile_photo" class="form-label">Profile Photo</label><br>
            <?php if ($profile_photo): ?>
                <img src="<?= $profile_photo ?>" alt="Profile Photo" class="profile-photo mb-3"><br>
            <?php endif; ?>
            <input type="file" class="form-control" name="profile_photo">
        </div>
        <button type="submit" class="btn btn-primary">Update Profile</button>
        <a href="index.php" class="btn btn-light">Back</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
