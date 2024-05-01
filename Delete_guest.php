<?php
session_start();
include "connection.php";

// Ensure the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if guest_id is set and not empty
    if (isset($_POST['delete_guests_names']) && !empty($_POST['delete_guests_names']) && isset($_SESSION['user_id'])) {
        // Sanitize the input data
        $guests_names = explode(', ', $_POST['delete_guests_names']); // Explode the comma-separated string into an array
        $user_id = $_SESSION['user_id'];

        foreach ($guests_names as $guest_name) {
            // You might want to sanitize the guest_name here as well
            list($f_name, $m_name, $l_name) = explode(' ', $guest_name);
            // Construct the delete query
            $sql_delete_guest = "DELETE FROM guest WHERE F_Name = '$f_name' AND M_Name = '$m_name' AND L_Name = '$l_name' AND user_id = $user_id";

            // Execute the delete query
            if ($conn->query($sql_delete_guest) === TRUE) {
                header("Location: guest.php");
            } else {
                echo "Error deleting guest.";
            }
        }
    } else {
        echo "Guest ID or user session not provided.";
    }
} else {
    echo "Form not submitted.";
}

?>