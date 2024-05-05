<?php

session_start();
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

    // Check if a guest with the same first name, middle name, and last name already exists for the current user
    $sql_check_guest = "SELECT * FROM guest WHERE user_id = '$user_id' AND F_Name = '$f_Name' AND M_Name = '$m_Name' AND L_Name = '$l_Name'";
    $result_check_guest = $conn->query($sql_check_guest);

    if ($result_check_guest->num_rows > 0) {
        // If a guest with the same name exists, set an alert session variable
        $_SESSION['alert'] = "الضيف المدخل مضاف بالفعل.";
    } else {
        // Insert data into the guest table
        $sql_insert_guest = "INSERT INTO guest (user_id, F_Name, M_Name, L_Name, Phone, Attendance, Relationship) 
                        VALUES ('$user_id', '$f_Name', '$m_Name', '$l_Name', '$phone', '$attendance', '$relationship')";

        if (mysqli_query($conn, $sql_insert_guest)) {
            header("Location: guest.php");
            exit;
        } else {
            echo "Error: " . $sql_insert_guest . "<br>" . $conn->error;
        }
    }
}

// Close the database connection
mysqli_close($conn);

header("Location: guest.php");
exit;
?>