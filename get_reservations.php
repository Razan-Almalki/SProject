<?php

session_start(); 
include 'connection.php';

// Check if service_id is provided in the URL
if (!isset($_GET['service_id'])) {
    http_response_code(400);
    exit("Error: service_id parameter is missing.");
}

// Get the service ID from the URL parameter
$serviceId = $_GET['service_id'];


// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    exit("Connection failed: " . $conn->connect_error);
}

// Fetch reservation dates for the specific service ID
$sql = "SELECT Reservation_date FROM Reservation WHERE Service_ID = $serviceId";
$result = $conn->query($sql);

$reservationDates = array();

if ($result && $result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        // Add reservation date to the array
        $reservationDates[] = $row['Reservation_date'];
    }
}

$conn->close();

// Output the reservation dates as JSON
header('Content-Type: application/json');
echo json_encode($reservationDates);
?>
