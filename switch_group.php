<?php

session_start();

include "connection.php";

// Ensure the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if guests_names and group_name are set and not empty
    if (isset($_POST['guests_names']) && isset($_POST['group_name']) && !empty($_POST['guests_names']) && !empty($_POST['group_name']) && isset($_SESSION['user_id'])) {
        // Sanitize the input data
        $group_name = $_POST['group_name'];
        $guests_names = explode(', ', $_POST['guests_names']); // Explode the comma-separated string into an array
        $user_id = $_SESSION['user_id'];

        // Update the relationship for each selected guest
        foreach ($guests_names as $guest_name) {
            // You might want to sanitize the guest_name here as well
            list($f_name, $m_name, $l_name) = explode(' ', $guest_name);
            // Construct the query
            $sql_update_relationship = "UPDATE guest SET Relationship = '$group_name' WHERE F_Name = '$f_name' AND M_Name = '$m_name' AND L_Name = '$l_name' AND user_id = $user_id";

            // Execute the update query
            if ($conn->query($sql_update_relationship) === TRUE) {
                header("Location: guest.php");
            } else {
                echo "Error updating relationship for guest: " . $guest_name . "<br>" . $conn->error;
            }
        }
    } else {
        echo "Guests names, group name, or user session not provided.";
    }
} else {
    echo "Form not submitted.";
}
?>
