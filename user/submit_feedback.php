<?php
// Database connection
include '../config.php';

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $rating = $conn->real_escape_string($_POST['rating']);
    $comments = $conn->real_escape_string($_POST['comments']);

    // Insert data into the feedback table
    $sql = "INSERT INTO feedback (name, email, rating, comments) VALUES ('$name', '$email', '$rating', '$comments')";

    if ($conn->query($sql) === TRUE) {
        // If data is saved, send email via Web3Forms
        $url = 'https://api.web3forms.com/submit';
        $data = [
            "access_key" => "8e1bbb34-9630-4129-a7f8-344b4b438c6f",
            "name" => $name,
            "email" => $email,
            "subject" => "New Feedback Received",
            "message" => "Rating: $rating\n\nComments:\n$comments"
        ];

        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ],
        ];
        
        $context  = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        if ($response) {
            echo "Feedback submitted and email sent successfully!";
        } else {
            echo "Feedback saved, but email notification failed.";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
