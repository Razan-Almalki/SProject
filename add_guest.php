<?php
// Include connection.php to establish a database connection
include 'connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $f_Name = mysqli_real_escape_string($conn, $_POST['f_Name']);
    $m_Name = mysqli_real_escape_string($conn, $_POST['m_Name']);
    $l_Name = mysqli_real_escape_string($conn, $_POST['l_Name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $relationship = mysqli_real_escape_string($conn, $_POST['img_category']); // Assuming 'img_category' corresponds to relationship
    $attendance = 'معلق';

    // Validate phone number format (starts with 05 and has 10 digits)
    if (preg_match('/^05[0-9]{8}$/', $phone)) {
        // Insert data into the guest table
        $sql_insert_guest = "INSERT INTO guest (user_id, F_Name, M_Name, L_Name, Phone, Attendance, Relationship) 
                    VALUES ('$user_id', '$f_Name', '$m_Name', '$l_Name', '$phone', '$attendance', '$relationship')";

        if ($conn->query($sql_insert_guest) === TRUE) {
            header("Location: guest.php");
        } else {
            echo "Error: " . $sql_insert_guest . "<br>" . $conn->error;
        }
    } else {
        echo "Invalid phone number format!";
    }
}
?>
