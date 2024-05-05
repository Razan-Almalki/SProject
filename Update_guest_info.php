<?php

session_start();
// Include connection.php to establish a database connection
include 'connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $update_guest_id = mysqli_real_escape_string($conn, $_POST['update_guest_id']); // Guest ID to be updated
    $f_Name = mysqli_real_escape_string($conn, $_POST['update_first_name']); // Update first name
    $m_Name = mysqli_real_escape_string($conn, $_POST['update_middle_name']); // Update middle name
    $l_Name = mysqli_real_escape_string($conn, $_POST['update_last_name']); // Update last name
    $phone = mysqli_real_escape_string($conn, $_POST['update_phone']); // Update phone
    $relationship = mysqli_real_escape_string($conn, $_POST['update_group']); // Update relationship

    // Check if a guest with the same first name, middle name, and last name already exists for the current user
    $sql_check_guest = "SELECT * FROM guest WHERE user_id = '$user_id' AND F_Name = '$f_Name' AND M_Name = '$m_Name' AND L_Name = '$l_Name' AND ID != '$update_guest_id'";
    $result_check_guest = $conn->query($sql_check_guest);

    if ($result_check_guest->num_rows > 0) {
        // If a guest with the same name exists, set an alert session variable
        $_SESSION['alert'] = "الضيف المدخل مضاف بالفعل.";
    } else {
        // Update data in the guest table
        $sql_update_guest = "UPDATE guest SET F_Name = '$f_Name', M_Name = '$m_Name', L_Name = '$l_Name', Phone = '$phone', Relationship = '$relationship' WHERE ID = '$update_guest_id'";

        if (mysqli_query($conn, $sql_update_guest)) {
            header("Location: guest.php");
            exit;
        } else {
            echo "Error: " . $sql_update_guest . "<br>" . $conn->error;
        }
    }
}

// Close the database connection
mysqli_close($conn);

header("Location: guest.php");
exit;
?>
