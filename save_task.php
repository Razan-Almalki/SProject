<?php
// Database configuration
$servername = "localhost"; // Change this if your database is hosted elsewhere
$username = "Razan";
$password = "0559945643";
$database = "myDB"; 

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Select database
$conn->select_db($database);

// Create tasks table
$sql = "CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    due_date DATE,
    priority VARCHAR(20),
    completed BOOLEAN
)";

if ($conn->query($sql) === TRUE) {
    echo "Table tasks created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}


// Insert task into database

    $taskName =$_POST["taskName"];
    $dueDate = $_POST["dueDate"];
    $priority =$_POST["priority"];

    $sql = "INSERT INTO tasks (name, due_date, priority, completed) VALUES ('$taskName', '$dueDate', '$priority', 0)";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
  
}
    $conn->close();

?>