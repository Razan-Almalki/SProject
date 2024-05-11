<?php

session_start();
// Include connection.php to establish a database connection
include 'connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['add-guest'])) {
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

    if (isset($_POST['add-group'])) {
        // Validate input
        $group_name = trim($_POST['group_name']);
        $user_id = $_POST['user_id'];

        // Check if group name already exists
        $check_query = "SELECT * FROM guest_tables WHERE Table_name = '$group_name' AND user_id = $user_id";
        $result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($result) > 0) {
            $_SESSION['alert'] = "اسم المجموعة موجود بالفعل. يرجى اختيار اسم آخر.";
        } else {
            // Insert group name into the database
            $insert_query = "INSERT INTO guest_tables (user_id, Table_name) VALUES ($user_id, '$group_name')";
            if (mysqli_query($conn, $insert_query)) {
                header("Location: guest.php");
            } else {
                $_SESSION['alert'] = "حدث خطأ أثناء إضافة المجموعة. يرجى المحاولة مرة أخرى.";
            }
        }
    }

    if (isset($_POST['delete-guest'])) {
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
    }

    if (isset($_POST['delete-group'])) {
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
    }

    if (isset($_POST['rename-group'])) {
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
    }

    if (isset($_POST['switch-group'])) {
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
    }

    if (isset($_POST['update-guest-info'])) {
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
}

// Close the database connection
mysqli_close($conn);

header("Location: guest.php");
exit;
?>