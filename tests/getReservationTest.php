<?php

use PHPUnit\Framework\TestCase;

require_once 'vendor/autoload.php';

class getReservationTest extends TestCase
{
    public function testGetReservationReturnsCorrectData()
    {
        // Simulate the $_GET parameter
        $_GET['service_id'] = 1;

        // Include the script containing the function to be tested
        $output = $this->executeScript('C:\Program Files\Ampps\www\get_reservations.php');

        // Assert that the output is correct
        $expectedOutput = '["2024-05-16","2024-05-30"]'; // Example expected output
        $this->assertSame($expectedOutput, $output);
    }

    // Helper method to execute a script and capture its output
    private function executeScript($scriptPath)
    {
        ob_start();
        require $scriptPath;
        return ob_get_clean();
    }
}

?>
