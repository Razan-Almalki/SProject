<?php

session_start(); 

// Database connection parameters
$servername = "localhost";
$username = "Ruba";
$password = "Ruba20";
$dbname = "wedding_planning";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Check if the music ID is provided in the URL
if (isset($_GET['id'])) {
    $musicId = $_GET['id'];

    // SQL query to fetch data for the specified music ID
    $sql = "SELECT * FROM services WHERE Service_ID = $musicId";
    $result = $conn->query($sql);


    if ($result) {
        if ($result->num_rows > 0) {
            // Array to store the fetched data
            $data = array();

            // Fetch data row by row
            while ($row = $result->fetch_assoc()) {

                // Extract the file extension from the filename
                $pic_extension = pathinfo($row['pic'], PATHINFO_EXTENSION);

                // Add each row to the data array
                $data = array(
                    'id' => $row['Service_ID'],
                    'pic' => base64_encode($row['pic']),
                    'pic_type' => $pic_extension, // Set the pic_type to the extracted file extension
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
            // Music not found
            echo json_encode(array('message' => 'Music not found'));
        }

    } else {
        // SQL query error
        echo json_encode(array('message' => 'Error executing query: ' . $conn->error));
    }

} else {
    // No music ID provided
    echo json_encode(array('message' => 'No music ID provided'));
}

// Close the database connection
$conn->close();
?>