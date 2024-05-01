<?php
include 'connection.php';

$guestId = $_GET['guest_id'];

$sql = "SELECT * FROM guest WHERE ID='$guestId'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Display guest details and attendance form
    $row = $result->fetch_assoc();
    echo "<div class='row r-update'>";
    echo "<input type='hidden' id='guest_id' value='" . $row['ID'] . "'>";
    echo "حضور <input type='radio' name='attendance' value='حضور'>";
    echo "اعتذار <input type='radio' name='attendance' value='معتذر'> ";
    echo $row['F_Name'] . " " . $row['M_Name'] . " " . $row['L_Name'];
    echo "</div>";
    echo "<div";
    echo "<button class='buttons' onclick='updateAttendance()'>تحديث الحضور</button>";
    echo "</div>";
} else {
    echo "لا يوجد مدعو بهذا الاسم، ربما اكت حضورك مسبقا او فضلا تأكد من كتابة اسم بشكل صحيح";
}

$conn->close();
?>
