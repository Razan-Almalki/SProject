<?php
// Include the database connection file
include 'connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Set parameters
    $serviceType = $_POST['service-type']; // Service type should be set in the hidden input field
    $imgContent = null; // Initialize $imgContent
    
    // Check if image is uploaded
    if(!empty($_FILES["image"]["name"])) { 
        // Get file info 
        $fileName = basename($_FILES["image"]["name"]); 
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
         
        // Allow certain file formats 
        $allowTypes = array('jpg','png','jpeg','gif'); 
        if(in_array($fileType, $allowTypes)){ 
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

    // Construct the SQL query
    $sql = "INSERT INTO services (Service_type, vendor_id, Service_name, Social_media, Discription, Price, Deposit, Theme, Location, pic) 
            VALUES ('$serviceType', '$vendorId', '$serviceName', '$socialMedia', '$description', '$price', '$deposit', '$theme', '$location', '$imgContent')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        // Redirect to a success page or do further processing
        header("Location: Vendor.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
