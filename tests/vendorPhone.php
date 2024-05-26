<?php
use PHPUnit\Framework\TestCase;

class vendorPhone extends TestCase
{
    public function testServiceIdProvided()
    {
        // Mock the global $_GET variable
        $_GET['id'] = 1;

        // Capture the output of the script
        ob_start();
        call_user_func(function() {
            // Database connection parameters
            $servername = "localhost";
            $username = "Ruba";
            $password = "Ruba20";
            $dbname = "wedding_planning"; // Your database name

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Check if the service ID is provided in the URL
            if (isset($_GET['id'])) {
                $cateringId = $_GET['id'];

                // Define the SQL query after retrieving the service ID
                $sql = "SELECT v.Phone 
                FROM vendor v, services s 
                WHERE s.vendor_id = v.Vendor_ID AND s.Service_ID = $cateringId";
                $result = $conn->query($sql);

                if ($result) {
                    if ($result->num_rows > 0) {
                        // Fetch vendor's phone number
                        
                        $row = $result->fetch_assoc();
                        $vendorPhoneNumber = $row['Phone'];

                        // Output the vendor's phone number as JSON
                        echo json_encode(array('vendor_phone_number' => $vendorPhoneNumber));
                    } else {
                        // Service not found
                        echo json_encode(array('error' => 'Service not found'));
                    }
                } else {
                    // SQL query error
                    echo json_encode(array('error' => 'Error executing query: ' . $conn->error));
                }
            } else {
                // No service ID provided
                echo json_encode(array('error' => 'No service ID provided'));
            }

            // Close the database connection
            $conn->close();
        });
        $output = ob_get_clean();

        // Decode the JSON output
        $result = json_decode($output, true);

        // Assert that vendor's phone number is returned
        $this->assertArrayHasKey('vendor_phone_number', $result);
    }

    public function testNoServiceIdProvided()
    {
        // Unset the $_GET['id'] to simulate no service ID provided
        unset($_GET['id']);

        // Capture the output of the script
        ob_start();
        call_user_func(function() {
            // Database connection parameters
            $servername = "localhost";
            $username = "Ruba";
            $password = "Ruba20";
            $dbname = "wedding_planning"; // Your database name

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Check if the service ID is provided in the URL
            if (isset($_GET['id'])) {
                $cateringId = $_GET['id'];

                // Define the SQL query after retrieving the service ID
                $sql = "SELECT v.Phone 
                FROM vendor v, services s 
                WHERE s.vendor_id = v.Vendor_ID AND s.Service_ID = $cateringId";
                $result = $conn->query($sql);

                if ($result) {
                    if ($result->num_rows > 0) {
                        // Fetch vendor's phone number
                        
                        $row = $result->fetch_assoc();
                        $vendorPhoneNumber = $row['Phone'];

                        // Output the vendor's phone number as JSON
                        echo json_encode(array('vendor_phone_number' => $vendorPhoneNumber));
                    } else {
                        // Service not found
                        echo json_encode(array('error' => 'Service not found'));
                    }
                } else {
                    // SQL query error
                    echo json_encode(array('error' => 'Error executing query: ' . $conn->error));
                }
            } else {
                // No service ID provided
                echo json_encode(array('error' => 'No service ID provided'));
            }

            // Close the database connection
            $conn->close();
        });
        $output = ob_get_clean();

        // Decode the JSON output
        $result = json_decode($output, true);

        // Assert that error message is returned
        $this->assertArrayHasKey('error', $result);
        $this->assertEquals('No service ID provided', $result['error']);
    }

    // Add more test cases for other scenarios (e.g., service not found, SQL query error)
}
?>
