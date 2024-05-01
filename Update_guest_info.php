<?php
session_start(); // Start the session if not already started

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    include 'connection.php';

    // Get the form data
    $update_guest_id = $_POST['update_guest_id'];
    $update_first_name = $_POST['update_first_name'];
    $update_middle_name = $_POST['update_middle_name'];
    $update_last_name = $_POST['update_last_name'];
    $update_phone = $_POST['update_phone'];
    $update_group = $_POST['update_group'];
    $user_id = $_POST['user_id']; // Retrieve session user ID

    

    echo "Guest ID: " . $update_guest_id;
    
    // Construct the SQL query
    $sql_update_guest = "UPDATE guest SET F_Name='$update_first_name', M_Name='$update_middle_name', L_Name='$update_last_name', Phone='$update_phone', Relationship='$update_group' WHERE ID=$update_guest_id AND user_id=$user_id";

    echo $sql_update_guest;

    // Execute the SQL query
    if ($conn->query($sql_update_guest) === TRUE) {
        // Redirect back to the previous page or any other desired page
        header("Location: guest.php");
        exit();
    } else {
        // Handle update failure
        echo "Error updating guest information: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // If the form is not submitted, redirect to an error page or display an error message
    echo "Invalid request";
}
?>