<?php
session_start();
// Database configuration
$servername = "localhost"; // Change this if your database is hosted elsewhere
$username = "Razan";
$password = "0559945643";
$database = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get task ID from POST request
$user_id = $_SESSION['user_id'];
$taskId = $_POST["taskId"];

// Delete task from database
$sql = "DELETE FROM tasks WHERE id='$taskId' AND user_id='$user_id'";

if ($conn->query($sql) === TRUE) {
    echo "Task deleted successfully";
} else {
    echo "Error deleting task: " . $conn->error;
}

$conn->close();
?>