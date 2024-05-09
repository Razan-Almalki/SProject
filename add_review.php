<?php
session_start();
// Database connection parameters
$servername = "localhost";
$username = "Ruba";
$password = "Ruba20";
$dbname = "wedding_planning"; // Your database name

// Debug: Log received POST data
file_put_contents('php://stderr', print_r($_POST, TRUE));

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the user_id from the session or authentication system
// Replace this with your actual implementation
$user_id = $_SESSION['User_ID'];

// Get the rating, comment, and service_id from the POST data
$service_id = $_POST['service_id']; // Assuming service_id is submitted from the form
$rating = $_POST['rating'];
$comment = $_POST['comment'];

// Insert the review data into the database
$sql = "INSERT INTO review (user_id, service_id, Rate, Comment) VALUES ($user_id, $service_id, $rating, '$comment')";

if ($conn->query($sql) === TRUE) {
    // Review successfully inserted
    header('Content-Type: application/json'); // Set content type header
    echo json_encode(array('message' => 'Review submitted successfully'));
} else {
    // Error inserting review
    header('Content-Type: application/json'); // Set content type header
    echo json_encode(array('error' => 'Failed to submit review: ' . $conn->error));
}

// Close the database connection
$conn->close();
?>
