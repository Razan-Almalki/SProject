<?php
session_start();

// Include database connection
include 'connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the group name to delete from the form
    $group_name_to_delete = $_POST['delete-group-name'];
    $user_id = $_SESSION['user_id'];

    // Check if there are any guests with the relationship equal to the group name selected for deletion
    $sql_check_relationship = "SELECT * FROM guest WHERE user_id=$user_id AND Relationship='$group_name_to_delete'";
    $result_check_relationship = $conn->query($sql_check_relationship);

    if ($result_check_relationship->num_rows > 0) {
        // If guests are found with the selected group name as the relationship,
        // create a new group named 'غير مصنف' (Uncategorized) if it doesn't exist
        $sql_check_undefined = "SELECT * FROM guest_tables WHERE user_id=$user_id AND Table_name='غير مصنف'";
        $result_check_undefined = $conn->query($sql_check_undefined);

        if ($result_check_undefined->num_rows == 0) {
            // 'غير مصنف' (Uncategorized) group doesn't exist, so create it
            $sql_create_undefined = "INSERT INTO guest_tables (user_id, Table_name) VALUES ($user_id, 'غير مصنف')";
            if ($conn->query($sql_create_undefined) === FALSE) {
                echo "Error creating 'غير مصنف' (Uncategorized) group: " . $conn->error;
                exit();
            }
        }

        // Update the relationship of guests with the selected group name to 'غير مصنف' (Uncategorized)
        $sql_update_relationship = "UPDATE guest SET Relationship='غير مصنف' WHERE user_id=$user_id AND Relationship='$group_name_to_delete'";
        if ($conn->query($sql_update_relationship) === FALSE) {
            echo "Error updating guest relationships: " . $conn->error;
            exit();
        }
    }

    // Delete the selected group
    $sql_delete_group = "DELETE FROM guest_tables WHERE user_id=$user_id AND Table_name='$group_name_to_delete'";
    if ($conn->query($sql_delete_group) === TRUE) {
        // Redirect back to the previous page or any other desired page
        header("Location: guest.php");
        exit();
    } else {
        // Handle delete failure
        echo "Error deleting group: " . $conn->error;
    }
} else {
    // If the form is not submitted, redirect to an error page or display an error message
    echo "Invalid request";
}
?>
