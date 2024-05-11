<?php

session_start(); 
include 'connection.php';
// Database connection parameters
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the catering ID is provided in the URL
if (isset($_GET['id'])) {
    $cateringId = $_GET['id'];

    // SQL query to fetch data for the specified catering ID
    $sql = "SELECT * FROM services WHERE Service_ID = $cateringId";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            // Array to store the fetched data
            $data = array();

            // Fetch data row by row
            while ($row = $result->fetch_assoc()) {

                // Add each row to the data array
                $data = array(
                    'id' => $row['Service_ID'],
                    'pic' => base64_encode($row['pic']),
                    'pic_type' => 'jpeg', 
                    'name' => $row['Service_name'],
                    'price' => $row['Price'],
                    'deposit' => $row['Deposit'],
                    'description' => $row['Discription'],
                    'type' => $row['Service_type'],
                    'social_media' => $row['Social_media'],
                    'theme' => $row['Theme'],
                    'map' => $row['Map'],
                    'location' => $row['Location']
                );
            }

            // Output the data as JSON
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            // Catering not found
            echo json_encode(array('message' => 'Catering not found'));
        }

    } else {
        // SQL query error
        echo json_encode(array('message' => 'Error executing query: ' . $conn->error));
    }

} else {
    // No catering ID provided
    echo json_encode(array('message' => 'No catering ID provided'));
}

// Close the database connection
$conn->close();
?>