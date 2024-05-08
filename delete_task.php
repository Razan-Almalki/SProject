<?php
session_start();

// Database configuration
include 'connection.php';

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