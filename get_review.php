<?php
session_start(); 
include 'connection.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the service_id from the URL parameters
$service_id = $_GET['id'];

// Fetch the number of reviews for the specified service
$sql = "SELECT * FROM review WHERE service_id = $service_id";
$result = $conn->query($sql);

if ($result) {
    // Array to store the fetched reviews data
    $reviews_data = array();

    // Check if any rows are returned
    if ($result->num_rows > 0) {
        // Fetch data row by row
        while ($row_reviews = $result->fetch_assoc()) {
            // Add each row to the reviews data array
            $reviews_data[] = array(
                'Review_ID' => $row_reviews['Review_ID'],
                'user_id' => $row_reviews['user_id'],
                'service_id' => $row_reviews['service_id'],
                'Rate' => $row_reviews['Rate'],
                'Comment' => $row_reviews['Comment'],
                'created_at' => $row_reviews['created_at']
            );
        }

        // Output the data as JSON
        header('Content-Type: application/json');
        echo json_encode($reviews_data);
    } else {
        // No rows found
        echo json_encode(array('message' => 'No reviews found'));
    }
} else {
    // Error in executing the query
    echo json_encode(array('error' => $conn->error));
}

// Close the database connection
$conn->close();
?>
