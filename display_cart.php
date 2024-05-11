<?php
session_start();

include 'connection.php';


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user ID is provided in the URL
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // SQL query to fetch data for the specified user ID from the cart table
    $sql = "SELECT * FROM Cart WHERE user_id = $userId";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            // Array to store the fetched data
            $data = array();

            while ($row = $result->fetch_assoc()) {

                // Extract the file extension from the filename
                $pic_extension = pathinfo($row['item_pic'], PATHINFO_EXTENSION);


                // Add each row to the data array
                $data[] = array(
                    'id'=> $row['id'],
                    'item_id' => $row['item_id'],
                    'item_name' => $row['item_name'],
                    'item_price' => $row['item_price'],
                    'deposit' => $row['deposit'],
                    'user_id' => $row['user_id'],
                    'item_pic' => $row['item_pic'],
                    'date' => $row['date'],
                    'pic_type' => $pic_extension, // Set the pic_type to the extracted file extension
                );
            }

            // Output the data as JSON
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            // Cart is empty
            echo json_encode(array('message' => 'Cart is empty for user ID ' . $userId));
        }
    } else {
        // SQL query error
        echo json_encode(array('message' => 'Error executing query: ' . $conn->error));
    }

} else {
    // No user ID provided
    echo json_encode(array('message' => 'User ID not set in the session'));
}

// Close the database connection
$conn->close();
?>