<?php
include "connection.php";

use PHPUnit\Framework\TestCase;

class login1Test extends TestCase
{
    public function testLoginSuccess()
    {
        // Simulate POST request data
        $_POST['email'] = 'suma22@hotmail.com';
        $_POST['password'] = 'Suma12';
        // Set $_SERVER['REQUEST_METHOD'] to "POST"
        $_SERVER['REQUEST_METHOD'] = "POST";

        // Start output buffering to capture echoed output
        ob_start();

        // Include the file to be tested
        include 'Login.php';

        // Capture the output buffer
        $output = ob_get_clean();

        // Assertions
        $this->assertStringContainsString("success", $output["success"]);
        $this->assertStringContainsString("message", $output["message"]);
        $this->assertStringContainsString("user_name", $output["user_name"]);
        $this->assertStringContainsString("user_id", $output["user_id"]);
    }

    public function testLoginFailEmailNotFound()
    {
        $_POST['email'] = 'suma1111@hotmail.com';
        $_POST['password'] = 'Suma12';
        // Set $_SERVER['REQUEST_METHOD'] to "POST"
        $_SERVER['REQUEST_METHOD'] = "POST";

        // Start output buffering to capture echoed output
        ob_start();

        include 'Login.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('success": false', $output);
    }
}
