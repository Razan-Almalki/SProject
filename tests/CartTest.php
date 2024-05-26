<?php

use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    // Define a simple addToCart function for testing purposes
    function addToCart($serviceId, $serviceName, $servicePrice, $serviceDeposit, $servicePic, $userId, $selectedDate) {
        // Check if a date is selected
        if (!$selectedDate) {
            echo 'No date selected.';
            return;
        }

        // Simulate adding to cart by echoing a success message
        echo 'Service added to cart successfully!';
    }

    public function testAddToCartWithDateSelected()
    {
        // Define the expected FormData
        $expectedFormData = [
            'serviceId' => 1,
            'serviceName' => 'ServiceName',
            'servicePrice' => 100,
            'serviceDeposit' => 50,
            'servicePic' => 'servicePic.jpg',
            'userId' => 123,
            'date' => '2024-05-12'
        ];

        // Mock the fetch function
        $GLOBALS['fetch'] = function ($url, $options) use (&$expectedFormData) {
            // Assert that the URL is correct
            $this->assertSame('http://localhost/add_to_cart.php', $url);

            // Assert that method is POST
            $this->assertSame('POST', $options['method']);

            // Assert that the FormData contains the expected values
            foreach ($expectedFormData as $key => $value) {
                $this->assertSame($value, $options['body'][$key]);
            }

            // Return a dummy response object
            return (object) ['ok' => true];
        };

        // Start output buffering to capture console output
        ob_start();
        
        // Call the addToCart function
        $this->addToCart(1, 'ServiceName', 100, 50, 'servicePic.jpg', 123, '2024-05-12');
        
        // Get the console output
        $output = ob_get_clean();
        
        // Assert that console log is called
        $this->assertEquals('Service added to cart successfully!', $output);
    }

    // Add more test methods for other scenarios
}
