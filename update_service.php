<?php
include "connection.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['insert-service'])) {
        // Set parameters
        $serviceType = $_POST['service-type']; // Service type should be set in the hidden input field
        $imgContent = null; // Initialize $imgContent

        // Check if image is uploaded
        if (!empty($_FILES["image"]["name"])) {
            // Get file info 
            $fileName = basename($_FILES["image"]["name"]);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

            // Allow certain file formats 
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'webp');
            if (in_array($fileType, $allowTypes)) {
                $image = $_FILES['image']['tmp_name'];
                $imgContent = addslashes(file_get_contents($image));
            }
        }
        $vendorId = $_POST['vendorId']; // Vendor ID should be set in the hidden input field
        $serviceName = $_POST['serviceName'];
        $socialMedia = $_POST['socialMedia'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $deposit = $_POST['deposit'];
        $theme = $_POST['theme'];
        $location = $_POST['location'];
        $map = $_POST['map'];

        // Construct the SQL query
        $sql = "INSERT INTO services (Service_type, vendor_id, Service_name, Social_media, Discription, Price, Deposit, Theme, Location, Map, pic) 
            VALUES ('$serviceType', '$vendorId', '$serviceName', '$socialMedia', '$description', '$price', '$deposit', '$theme', '$location', '$map', '$imgContent')";

        // Execute the query
        if ($conn->query($sql) === TRUE) {
            // Redirect to a success page or do further processing
            header("Location: Vendor.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    if (isset($_POST['delete-service'])) {
        // Check if service IDs and vendor ID are set and not empty
        if (isset($_POST['service-ids']) && !empty($_POST['service-ids']) && isset($_POST['vendorId']) && !empty($_POST['vendorId'])) {
            // Sanitize the input data
            $service_ids = explode(', ', $_POST['service-ids']); // Explode the comma-separated string into an array
            $vendor_id = $_POST['vendorId'];

            foreach ($service_ids as $service_id) {
                // Construct the delete query
                $sql_delete_service = "DELETE FROM services WHERE Service_ID = '$service_id' AND vendor_id = $vendor_id";

                // Execute the delete query
                if ($conn->query($sql_delete_service) === TRUE) {
                    // Deletion successful
                    // You can redirect to a different page or perform any other action here
                } else {
                    // Error occurred while deleting service
                    echo "Error deleting service.";
                }
            }
            // Redirect to a page after deletion, if needed
            header("Location: Vendor.php");
            exit(); // Ensure script execution stops after redirection
        } else {
            // Service ID or vendor session not provided
            echo "Service ID or vendor session not provided.";
        }
    }
    // Check if service ID is set
    if (isset($_POST['service-id'])) {
        $service_id = $_POST['service-id'];

        // Check if form submitted is for updating service information
        if (isset($_POST['update-info'])) {
            // Extract service information from the form
            $serviceType = $_POST['serviceType'];
            $serviceName = $_POST['serviceName'];
            $tiktok = $_POST['tiktok'];
            $instgram = $_POST['instgram'];
            $snapchat = $_POST['snapchat'];
            $price = $_POST['price'];
            $deposit = $_POST['deposit'];
            $theme = $_POST['theme'];

            // Update service information in the database
            $sql = "UPDATE services SET Service_type = '$serviceType', Service_name = '$serviceName', Social_media = '$tiktok\n$instgram\n$snapchat', Price = '$price', Deposit = '$deposit', Theme = '$theme' WHERE Service_ID = $service_id";

            // Execute query
            if ($conn->query($sql) === TRUE) {
                // Redirect to the service details page
                header("Location: service_details.php?Service_ID=" . $service_id);
                exit;
            } else {
                echo "Error updating service information: " . $conn->error;
            }
        }

        // Check if form submitted is for updating service image
        if (isset($_POST['update-image'])) {
            // Check if image is uploaded
            if (!empty($_FILES["image"]["name"])) {
                // Get file info
                $fileName = basename($_FILES["image"]["name"]);
                $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

                // Allow certain file formats
                $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'webp');
                if (in_array($fileType, $allowTypes)) {
                    $image = $_FILES['image']['tmp_name'];
                    $imgContent = addslashes(file_get_contents($image));

                    // Update the service image in the database
                    $sql = "UPDATE services SET pic = '$imgContent' WHERE Service_ID = $service_id";

                    // Execute query
                    if ($conn->query($sql) === TRUE) {
                        // Redirect to the service details page
                        header("Location: service_details.php?Service_ID=" . $service_id);
                        exit;
                    } else {
                        echo "Error updating service image: " . $conn->error;
                    }
                } else {
                    echo "Error: Invalid file format. Only JPG, JPEG, PNG, and GIF files are allowed.";
                }
            } else {
                header("Location: service_details.php?Service_ID=" . $service_id);
            }
        }

        // Check if form submitted is for updating service about
        if (isset($_POST['update-about'])) {
            // Extract description from the form
            $description = $_POST['description'];

            // Update service about in the database
            $sql = "UPDATE services SET Discription = '$description' WHERE Service_ID = $service_id";

            // Execute query
            if ($conn->query($sql) === TRUE) {
                // Redirect to the service details page
                header("Location: service_details.php?Service_ID=" . $service_id);
                exit;
            } else {
                echo "Error updating service about: " . $conn->error;
            }
        }

        // Check if form submitted is for updating service location
        if (isset($_POST['update-location'])) {
            // Extract location information from the form
            $location = $_POST['location'];
            $map = $_POST['map'];

            // Update service location in the database
            $sql = "UPDATE services SET Location = '$location', Map = '$map' WHERE Service_ID = $service_id";

            // Execute query
            if ($conn->query($sql) === TRUE) {
                // Redirect to the service details page
                header("Location: service_details.php?Service_ID=" . $service_id);
                exit;
            } else {
                echo "Error updating service location: " . $conn->error;
            }
        }
    } else {
        echo "Error: Service ID not provided.";
    }
} else {
    echo "Error: Invalid request.";
}

// Close the database connection
$conn->close();
?>