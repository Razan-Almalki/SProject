<?php
include 'connection.php';

$guestId = $_GET['guest_id'];
$attendance = $_GET['attendance'];

$sql = "UPDATE guest SET Attendance='$attendance' WHERE ID='$guestId'";

if ($conn->query($sql) === TRUE) {
    // Check the selected attendance option and display appropriate message
    if ($attendance === 'حضور') {
        echo "<p>تم تأكيد الحضور</p>";
    } elseif ($attendance === 'معتذر') {
        echo "<p>تم تغيير حالة حضورك الى معتذر</p>";
    } else {
        echo "<p>حدث خطأ غير متوقع</p>";
    }
} else {
    echo "Error updating attendance: " . $conn->error;
}

$conn->close();
?>
