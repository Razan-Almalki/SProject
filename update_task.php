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

// Get data from POST request
$user_id = $_SESSION['user_id'];
$newTaskName = $_POST["taskName"];
$newDueDate = $_POST["dueDate"];
$newStatus = isset($_POST["completed"]) ? 1 : 0; // Convert checkbox value to 1 or 0
$taskId = $_POST["taskId"];

// Update task in database
$sql = "UPDATE tasks SET name=?, due_date=?, completed=? WHERE id=? AND user_id='$user_id'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssii", $newTaskName, $newDueDate, $newStatus, $taskId);

$response = array();

if ($stmt->execute()) {
    // If execution is successful, set success flag to true
    $response["success"] = true;
 header('Location: checklist.php');
    exit(); // Make sure no further PHP code is executed
} else {
    // If execution fails, set success flag to false
    $response["success"] = false;
}

// Set the response content type to JSON
header('Content-Type: application/json');


$conn->close();
?>
