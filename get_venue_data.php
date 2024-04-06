<?php
// Database connection parameters
$servername = "localhost";
$username = "Ruba";
$password = "Ruba20";
$dbname = "hithere1"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch data from the "Venue" table
$sql = "SELECT * FROM venue";
$result = $conn->query($sql);

// Check if there are any rows returned
if ($result->num_rows > 0) {
    // Array to store the fetched data
    $data = array();

    // Fetch data row by row
    while($row = $result->fetch_assoc()) {
        // Add each row to the data array
        $data[] = array(
            'pic' => $row['pic'],
            'name' => $row['name'],
            'price' => $row['price'],
            'location' => $row['location'],
            'description' => $row['description'],
            'type' => $row['type'],
            'rate' => $row['rate'],
            'num_rates' => $row['num_rates'],
            'num_guests' => $row['num_guests'],
            'num_views' => $row['num_views'],
            'vendor_info' => $row['vendor_info'],
            'vendor_rating' => $row['vendor_rating']
        );
    }

    // Output the data as JSON
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    // No rows found
    echo json_encode(array('message' => 'No venue found'));
}

// Close the database connection
$conn->close();
?>
