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

// Check if the item ID is provided in the URL
if (isset($_GET['itemId'])) {
    $itemId = $_GET['itemId'];

    // Delete cart item
    $sqlDeleteCartItem = "DELETE FROM Cart WHERE id = $itemId";
    if ($conn->query($sqlDeleteCartItem) === TRUE) {
        // Delete reservation associated with the deleted item
        $sqlDeleteReservation = "DELETE FROM reservation WHERE Reservation_ID = $itemId";

        if ($conn->query($sqlDeleteReservation) === TRUE) {
            echo "Cart item, related service information, and reservation deleted successfully";
        } else {
            echo "Error deleting reservation: " . $conn->error;
        }

    } else {
        echo "Error deleting cart item: " . $conn->error;
    }

} else {
    // No item ID provided
    echo "No item ID provided";
}

// Close the database connection
$conn->close();
?>