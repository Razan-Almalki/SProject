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

// Insert task into database
$user_id = $_SESSION['user_id'];
$taskName = $_POST["taskName"];
$dueDate = $_POST["dueDate"];


$sql = "INSERT INTO tasks (user_id, name, due_date, completed) VALUES ('$user_id', '$taskName', '$dueDate', 0)";

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    echo $last_id; // Echo the ID of the inserted task
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>