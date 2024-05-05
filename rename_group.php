<?php
session_start();

// Include database connection
include 'connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the new group name from the form
    $new_group_name = $_POST['new-group-name'];
    $group_id = $_POST['update_group_id'];
    $user_id = $_SESSION['user_id'];
    $old_group_name = $_POST['old_group_name'];

    // Check if the new group name is different from the old group name
    if ($new_group_name != $old_group_name) {
        // Check if the new group name already exists
        $sql_check_existing = "SELECT * FROM guest_tables WHERE Table_name='$new_group_name' AND user_id=$user_id";
        $result_existing = $conn->query($sql_check_existing);

        if ($result_existing->num_rows == 0) {
            // Construct the SQL query to update the group table name
            $sql_update_group = "UPDATE guest_tables SET Table_name='$new_group_name' WHERE ID=$group_id AND user_id=$user_id";

            // Execute the SQL query to update group name
            if ($conn->query($sql_update_group) === TRUE) {
                // Construct the SQL query to update Relationship in the guest table
                $sql_update_relationship = "UPDATE guest SET Relationship='$new_group_name' WHERE user_id=$user_id AND Relationship='$old_group_name'";

                // Execute the SQL query to update Relationship
                if ($conn->query($sql_update_relationship) === TRUE) {
                    // Redirect back to the previous page or any other desired page
                    header("Location: guest.php");
                    exit();
                } else {
                    // Handle update failure for Relationship
                    echo "Error updating Relationship: " . $conn->error;
                }
            } else {
                // Handle update failure for group name
                echo "Error updating group name: " . $conn->error;
            }
        } else {
            // Display an error message if the new group name already exists
            header("Location: guest.php");
        }
    } else {
        // Display an error message if the new group name is the same as the old group name
        header("Location: guest.php");
    }
} else {
    // If the form is not submitted, redirect to an error page or display an error message
    echo "Invalid request";
}
?>
