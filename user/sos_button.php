<?php
session_start();
include('../config.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send SOS Alert</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f4f8; /* Soft background color */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
            animation: fadeIn 0.5s ease-in-out; /* Fade-in animation */
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        h2 {
            color: #dc3545; /* Red color for emphasis */
            margin-bottom: 20px;
            font-size: 2rem; /* Increased font size */
        }
        p {
            font-size: 1.2rem; /* Slightly larger paragraph text */
            color: #555; /* Darker gray for better readability */
            margin-bottom: 30px;
        }
        .btn-sos {
            width: 100px; /* Fixed width for the button */
            height: 100px; /* Fixed height for the button */
            border-radius: 50%; /* Circular button */
            font-size: 1.5rem;
            background-color: #dc3545; /* Red background */
            color: white;
            border: none;
            transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden; /* For ripple effect */
        }
        .btn-sos.clicked {
            background-color: #c82333; /* Darker red when clicked */
        }
        .btn-sos:hover {
            transform: scale(1.1); /* Slightly increase size on hover */
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3); /* Stronger shadow */
        }
        .status-message {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>SOS Emergency Alert</h2>
    
    <p>Press the button below to send an SOS alert to your guardians.</p>
    
    <!-- SOS Button -->
    <button class="btn btn-sos" id="sosButton" onclick="sendSOS()">SOS</button>
    
    <!-- Display status message if SOS sent or failed -->
    <div class="status-message">
        <?php
        if (isset($_GET['status'])) {
            if ($_GET['status'] == 'success') {
                echo "<div class='alert alert-success'>SOS alert sent successfully!</div>";
            } elseif ($_GET['status'] == 'error') {
                echo "<div class='alert alert-danger'>Failed to send SOS alert. Please try again.</div>";
            }
        }
        ?>
    </div>
</div>

<!-- Geolocation Script -->
<script>
function sendSOS() {
    const sosButton = document.getElementById('sosButton');
    sosButton.classList.add('clicked');

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(async function(position) {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;

            try {
                // Fetch location data from LocationIQ
                const response = await fetch(`https://us1.locationiq.com/v1/reverse.php?key=YOUR_LOCATIONIQ_API_KEY&lat=${latitude}&lon=${longitude}&format=json`);
                const locationData = await response.json();

                // Get pincode from response
                const pincode = locationData.address.postcode;

                // Redirect to sos_action.php with lat, lon, and pincode
                window.location.href = `sos_action.php?lat=${latitude}&lon=${longitude}&pincode=${pincode}`;
            } catch (error) {
                window.location.href = `sos_action.php?lat=${latitude}&lon=${longitude}`;
            }
        }, function() {
            window.location.href = "sos_action.php";
        });
    } else {
        alert("Geolocation is not supported by this browser.");
        window.location.href = "sos_action.php";
    }
}

</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
