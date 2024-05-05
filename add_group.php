<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    include_once "connection.php";

    // Validate input
    $group_name = trim($_POST['group_name']);
    $user_id = $_POST['user_id'];

    // Check if group name already exists
    $check_query = "SELECT * FROM guest_tables WHERE Table_name = '$group_name' AND user_id = $user_id";
    $result = mysqli_query($conn, $check_query);
    if (mysqli_num_rows($result) > 0) {
        $_SESSION['alert'] = "الاسم المدخل موجود بالفعل. يرجى اختيار اسم آخر.";
    } else {
        // Insert group name into the database
        $insert_query = "INSERT INTO guest_tables (user_id, Table_name) VALUES ($user_id, '$group_name')";
        if (mysqli_query($conn, $insert_query)) {
            
        } else {
            $_SESSION['alert'] = "حدث خطأ أثناء إضافة المجموعة. يرجى المحاولة مرة أخرى.";
        }
    }
}

// Close the database connection
mysqli_close($conn);

// Redirect back to the guest.php page
header("Location: guest.php");
exit;
?>