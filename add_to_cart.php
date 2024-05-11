<?php

session_start(); 

$loggedIn = isset($_SESSION["user_id"]);
if (!$loggedIn) {
    header("Location: Login.html");
    exit;
  }
// Database connection parameters
include 'connection.php';

try {

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to insert data into the Cart table
    $stmt = $conn->prepare("INSERT INTO Cart (item_id, item_name, item_price, deposit, item_pic, user_id, date) VALUES (?, ?, ?, ?, ?, ?, ?)");

    // Check if the prepare() call succeeded
    if (!$stmt) {
        throw new Exception("Error preparing SQL statement: " . $conn->error);
    }

    // Bind parameters
    $itemId = isset($_POST['serviceId']) ? $_POST['serviceId'] : null;
    $itemName = isset($_POST['serviceName']) ? $_POST['serviceName'] : null;
    $itemPrice = isset($_POST['servicePrice']) ? $_POST['servicePrice'] : null;
    $deposit = isset($_POST['serviceDeposit']) ? $_POST['serviceDeposit'] : null; // Retrieve serviceDeposit
    $itemPic = isset($_POST['servicePic']) ? $_POST['servicePic'] : null;
    $userId = isset($_POST['userId']) ? $_POST['userId'] : null;
    $reservationDate = isset($_POST['date']) ? $_POST['date'] : null; // Retrieve reservation date


    // Check if any required parameter is null
    if ($itemId === null || $itemName === null || $itemPrice === null || $deposit === null || $itemPic === null || $userId === null || $reservationDate === null) {
        throw new Exception("One or more required parameters are null.");
    }

    // Bind parameters
    if (!$stmt->bind_param("ississs", $itemId, $itemName, $itemPrice, $deposit, $itemPic, $userId, $reservationDate)) {
        throw new Exception("Error binding parameters: " . $stmt->error);
    }

    // Execute the statement
    if ($stmt->execute()) {
        echo "Item added to cart successfully!";
    } else {
        throw new Exception("Error adding item to cart: " . $stmt->error);
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>