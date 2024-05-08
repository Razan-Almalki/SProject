<?php
session_start();

// Database configuration
include 'connection.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$user_id = $_SESSION['user_id'];
// Fetch tasks from database
$sql = "SELECT * FROM tasks WHERE user_id = '$user_id'";
$result = $conn->query($sql);

$tasks = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tasks[] = array(
            "id" => $row["id"],
            "name" => $row["name"],
            "dueDate" => $row["due_date"],
            "completed" => $row["completed"]
        );
    }
}

// Debug: Log retrieved tasks
error_log("Retrieved tasks: " . print_r($tasks, true));

// Output tasks as JSON
echo json_encode($tasks);

$conn->close();
?>