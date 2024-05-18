<?php
include 'connection.php';

$guestId = $_GET['guest_id'];

$sql = "SELECT * FROM guest WHERE ID='$guestId'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Display guest details and attendance form
    $row = $result->fetch_assoc();
    echo "<div class='row r-update'>";
    echo "<div id='guest-name'>" . $row['F_Name'] . " " . $row['M_Name'] . " " . $row['L_Name'] . "</div>";
    echo "<div id='attendance-options'>";
    echo "<input type='hidden' id='guest_id' value='" . $row['ID'] . "'>";
    echo "<input type='radio' id='attend' name='attendance' value='حضور'><label for='attendance' style='margin-left: 25px;'>حضور</label>";
    echo "<input type='radio' id='decline' name='attendance' value='معتذر' style='margin-right: 25px;'><label for='attendance'>اعتذار</label>";
    echo "</div>";
    echo "</div>";
    echo "<button class='buttons' onclick='updateAttendance()'>تحديث الحضور</button>";
    
} else {
    echo "لا يوجد مدعو بهذا الاسم، ربما اكت حضورك مسبقا او فضلا تأكد من كتابة اسم بشكل صحيح";
}

$conn->close();
?>
