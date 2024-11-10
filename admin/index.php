<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php'); // Redirect to login if not logged in
    exit();
}

// Sample content for admin dashboard
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
            background-color: #e9ecef;
        }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            padding: 20px;
            position: fixed;
            width: 60px;
            transition: width 0.3s;
            overflow: hidden;
        }
        .sidebar:hover {
            width: 250px;
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
        .sidebar a:hover {
            background-color:#007bff;
            color: black;
            transform: scale(1.17); 
            transition: transform 0.4s ease; 


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
            margin-bottom: 20px;
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
        /* img hover */
        .feature-card img {
        max-width: 100%;
        height: auto;
        border-radius: 15px;
        transition: transform 0.4s ease; 
    }

    .feature-card img:hover {
        transform: scale(1.02); 
    }
    .row :hover{
        transform: scale(1.03);
        transition: transform 0.4s ease;
    }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Dashboard</h2>
        <a href="view_complaint.php"><span class="sidebar-icon">📄</span> View Complaints</a>
        <a href="manage_police.php"><span class="sidebar-icon">👮</span> Manage Police</a>
        <a href="manage_user.php"><span class="sidebar-icon">👥</span> Manage Users</a>
        <a href="manage_guardians.php"><span class="sidebar-icon">🙎‍♂️</span>Manage Guardian</a>
        <a href="logout.php"><span class="sidebar-icon">↩️</span> Logout</a>
    </div>
    <div class="content">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Admin Panel</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
        <h1>Welcome to the Admin Dashboard</h1>
        <p>Use the sidebar to navigate through the admin functionalities.</p>

        <div class="row">
                <div class="col-md-4">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <h5 class="card-title">Total Complaints</h5>
                            <p class="card-text">Manage and view all complaints submitted.</p>
                            <a href="view_complaint.php" class="btn btn-light">View Complaints</a>
                        </div>
                    </div>
                </div>
             <div class="col-md-4">
                   <div class="card text-white bg-success">
                        <div class="card-body">
                            <h5 class="card-title">Manage Police</h5>
                            <p class="card-text">Oversee police officers and their assignments.</p>
                            <a href="manage_police.php" class="btn btn-light">Manage Police</a>
                     </div>
                  </div>
                </div>
                <div class="col-md-4">
                 <div class="card text-white bg-warning">
                        <div class="card-body">
                            <h5 class="card-title">Manage Users</h5>
                            <p class="card-text">Control user access and manage profiles.</p>
                             <a href="manage_user.php" class="btn btn-light">Manage Users</a>
                        </div>
                    </div>
                </div>
            </div>

        

        <div class="feature-section">
            <h2>Application Features</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <img src="../images/GettyImages.jpg" alt="Feature 1">
                        <h5>Emergency Contact Alerts: </h5>
                        <p>Users can set up automatic notifications to inform friends, family, or security personnel in case of an emergency, facilitating a prompt response from their support network.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <img src="../images/tracking.png" alt="Feature 2">
                        <h5>Real-Time Location Tracking: </h5>
                        <p>Many systems include GPS capabilities that enable users’ locations to be shared with chosen contacts or emergency services, ensuring immediate support.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <img src="../images/sos2.jpg" alt="Feature 3">
                        <h5>Panic Button (SOS)</h5>
                        <p>This feature allows users to quickly alert authorities or trusted contacts in emergencies with a simple press, often coupled with GPS tracking to provide precise location information.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
