<?php
include 'connection.php';

$guestId = $_GET['guest_id'];
$attendance = $_GET['attendance'];

$sql = "UPDATE guest SET Attendance='$attendance' WHERE ID='$guestId'";

if ($conn->query($sql) === TRUE) {
    echo "<p>تم تأكيد الحضور</p>";
} else {
    echo "Error updating attendance: " . $conn->error;
}

$conn->close();
?>
