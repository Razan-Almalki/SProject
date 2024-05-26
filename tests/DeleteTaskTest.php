<?php

use PHPUnit\Framework\TestCase;

class DeleteTaskTest extends TestCase
{
    public function testDeleteTask()
    {
        // Database configuration
        $servername = "localhost";
        $username = "Razan";
        $password = "0559945643";
        $database = "myDB";

        // Connect to the database
        $conn = new mysqli($servername, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            $this->fail("Connection failed: " . $conn->connect_error);
        }

        // Prepare the task ID to be deleted (replace with an existing task ID)
        $taskId = 2;

        // Execute the delete query
        $sql = "DELETE FROM tasks WHERE id='$taskId'";
        $result = $conn->query($sql);

        // Check if the deletion was successful
        if ($result === TRUE) {
            $this->assertTrue(true, "Task deleted successfully");
        } else {
            $this->fail("Error deleting task: " . $conn->error);
        }

        // Close the database connection
        $conn->close();
    }
}
