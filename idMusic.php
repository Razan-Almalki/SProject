<?php

session_start(); 

include 'connection.php';

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

                // Add each row to the data array
                $data = array(
                    'id' => $row['Service_ID'],
                    'pic' => base64_encode($row['pic']),
                    'pic_type' => 'jpeg', // Set the pic_type to the extracted file extension
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