<?php

use PHPUnit\Framework\TestCase;

class FetchServicesTest extends TestCase
{
    public function testFetchServices()
    {
        // Simulate POST request data
        $_POST["venue_budget"] = 25000.00; // Sample venue budget
        $_POST["catering_budget"] = 25000.00; // Sample catering budget
        $_POST["musician_budget"] = 2000.00; // Sample musician budget
        $_POST["theme"] = "Hotel"; // Sample theme
        // Set $_SERVER['REQUEST_METHOD'] to "POST"
        $_SERVER['REQUEST_METHOD'] = "POST";

        // Start output buffering to capture echoed output
        ob_start();

        // Include the file to be tested
        include 'fetch_services.php';

        // Capture the output buffer
        $output = ob_get_clean();

        // Assertions
        $this->assertStringContainsString("Venue Service", $output);
        $this->assertStringContainsString("Catering Service", $output);
        $this->assertStringContainsString("Music Service", $output);
    }
}

?>
