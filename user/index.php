<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Check if user_name is set in the session
$userName = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : "Guest";
$profilePhoto = isset($_SESSION['profile_photo']) && file_exists("../uploads/" . $_SESSION['profile_photo'])
    ? $_SESSION['profile_photo']
    : 'default-avatar.png'; // Default if file not found
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            /* background-color: #e9ecef; */
            background: url('../images/abstract.avif') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }
        .sidebar {
            height: 100vh;
            width: 50px;
            background-color: #343a40;
            padding: 20px;
            position: fixed;
            transition: width 0.3s;
            overflow: hidden;
        }
        .sidebar a {
            color: white;
            padding: 15px;
            text-decoration: none;
            display: block;
            margin: 10px 0;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .sidebar a:hover {
            background-color: #495057;
            transform: translateX(5px);
        }
        .sidebar:hover {
            width: 250px;
        }
        .header {
            background-color: rgba(0, 123, 255, 0.8);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .sidebar h2 {
            color: white;
            margin-bottom: 30px;
            display: none; /* Hide title initially */
        }
        .sidebar:hover h2 {
            display: block; /* Show title on hover */
        }
        .sidebar a {
            color: #adb5bd;
            padding: 10px;
            text-decoration: none;
            display: flex;
            align-items: center;
            border-radius: 5px;
            margin-bottom: 10px;
            transition: background-color 0.3s, color 0.3s;
        }
        .sidebar-icon {
            font-size: 24px;
            margin-right: 10px;
        }
        .content {
            margin-left: 60px;
            padding: 20px;
            transition: margin-left 0.3s;
        }
        .sidebar:hover + .content {
            margin-left: 250px;
        }
        .card {
            margin: 20px;
            border: none;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover{
            transform: translate(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }
        .card-body {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
        }
        .btn-custom {
            background-color: #28a745;
            color: white;
            transition: background-color 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #218838;
        }
        .navbar {
            background-color: #007bff;
        }
        .navbar-brand, .nav-link {
            color: white !important;
        }
        .navbar-brand:hover, .nav-link:hover {
            color: #f8f9fa !important;
        }
        h1 {
            color: #343a40;
        }
        .feature-section {
            margin-top: 40px;
        }
        .feature-card {
            text-align: center;
        }
        .feature-card img {
            max-width: 100%;
            height: auto;
            border-radius: 15px;
        }
        .profile-photo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Dashboard</h2>
        <a href="submit_complaint.php"><span class="sidebar-icon">📓</span> Complaint</a>
        <a href="manage_guardians.php"><span class="sidebar-icon">🙎‍♂️</span>Manage Guardian</a>
        <a href="view_complaint_status.php"><span class="sidebar-icon">📜</span>View Complaint</a>
        <a href="manage_profile.php"><span class="sidebar-icon">🙎‍♂️</span>Manage Profile</a>
        <a href="sos_button.php"><span class="sidebar-icon">🚨</span>Emergency SOS</a>
        <a href="feedback.html"><span class="sidebar-icon">🧾</span>Feedback</a>
        <a href="logout.php"><span class="sidebar-icon">↩️</span>Logout</a>
 
    </div>
    <div class="content">
        <div class="header">
            <img src="../uploads/672507271bd91_IMG_14389.jpg" alt="Profile Photo" class="profile-photo">
            <h1>Welcome, <?php echo htmlspecialchars($userName); ?>!</h1>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Submit a Complaint</h5>
                        <p class="card-text">Submit and track your complaints easily.</p>
                        <a href="submit_complaint.php" class="btn btn-custom">Go to Complaints</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Add Guardian</h5>
                        <p class="card-text">Manage your emergency contacts effectively.</p>
                        <a href="add_guardian.php" class="btn btn-custom">Add Guardian</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">View Status</h5>
                        <p class="card-text">Track the status of your complaints.</p>
                        <a href="view_complaint_status.php" class="btn btn-custom">View Status</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Manage Profile</h5>
                        <p class="card-text">Manage your profile, you can change easily your information.</p>
                        <a href="manage_profile.php" class="btn btn-custom">Manage Profile</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Panic Button</h5>
                        <p class="card-text">Click on panic button, if you are not feel secured ot unsafe.</p>
                        <a href="sos_button.php" class="btn btn-custom">Panic Button</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Feedback</h5>
                        <p class="card-text">Submit your feedback. We will respond to it soon. Take care.</p>
                        <a href="feedback.html" class="btn btn-custom">Feedback</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script> <!-- Include Bootstrap JS -->
</body>
</html>