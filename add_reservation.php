<?php
session_start(); 
include 'connection.php';

$loggedIn = isset($_SESSION["user_id"]);
if (!$loggedIn) {
    header("Location: Login.html");
    exit;
  }

try {

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to insert data into the Reservation table
    $stmt = $conn->prepare("INSERT INTO Reservation (Service_ID, User_ID, Reservation_date, State) VALUES (?, ?, ?, ?)");

    // Check if the prepare() call succeeded
    if (!$stmt) {
        throw new Exception("Error preparing SQL statement: " . $conn->error);
    }

    // Bind parameters
    $serviceId = isset($_POST['serviceId']) ? $_POST['serviceId'] : null;
    $userId = isset($_POST['userId']) ? $_POST['userId'] : null;
    $reservationDate = isset($_POST['reservationDate']) ? $_POST['reservationDate'] : null;
    $state = "reserved"; // Set the state to "reserved"

    // Check if any required parameter is null
    if ($serviceId === null || $userId === null || $reservationDate === null) {
        throw new Exception("One or more required parameters are null.");
    }

    // Bind parameters
    if (!$stmt->bind_param("iiss", $serviceId, $userId, $reservationDate, $state)) {
        throw new Exception("Error binding parameters: " . $stmt->error);
    }

    // Execute the statement
    if ($stmt->execute()) {
        echo "Service reserved successfully!";
    } else {
        throw new Exception("Error reserving service: " . $stmt->error);
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
