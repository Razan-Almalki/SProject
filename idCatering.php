<?php
// Database connection parameters
$servername = "localhost";
$username = "Ruba";
$password = "Ruba20";
$dbname = "hithere1"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the catering ID is provided in the URL
if(isset($_GET['id'])) {
    $cateringId = $_GET['id'];

    // SQL query to fetch data for the specified catering ID
    $sql = "SELECT * FROM Catering WHERE id = $cateringId";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Catering details found
        $row = $result->fetch_assoc();
        // Output the data as JSON
        header('Content-Type: application/json');
        echo json_encode($row);
    } else {
        // Catering not found
        echo json_encode(array('message' => 'Catering not found'));
    }
} else {
    // No catering ID provided
    echo json_encode(array('message' => 'No catering ID provided'));
}

// Close the database connection
$conn->close();
?>
