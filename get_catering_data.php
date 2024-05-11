<?php
 
session_start(); 
include 'connection.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch catering data with service_type = 'Catering'
$sql = "SELECT * FROM services WHERE Service_type = 'Catering'";
$result = $conn->query($sql);

// Check if there are any rows returned
if ($result->num_rows > 0) {
    // Array to store the fetched data
    $data = array();

    // Fetch data row by row
    while ($row = $result->fetch_assoc()) {

        // Add each row to the data array
        $data[] = array(
            'id' => $row['Service_ID'],
            'pic' => base64_encode($row['pic']),
            'pic_type' => 'jpeg', // Set the pic_type to the extracted file <extension></extension>
            /*'pic' => 'data:image/jpeg;base64,' + $row['pic'],*/
            'name' => $row['Service_name'],
            'price' => $row['Price'],
            'deposit' => $row['Deposit'],
            'description' => $row['Discription'],
            'type' => $row['Service_type']
        );
    }

    // Output the data as JSON
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    // No rows found
    echo json_encode(array('message' => 'No catering found'));
}

// Close the database connection
$conn->close();
?>