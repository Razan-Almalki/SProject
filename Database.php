<?php
// Database connection parameters
$servername = "localhost";
$username = "Ruba";
$password = "Ruba20";
$database = "HiThere1";

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Create a new database
    $sql = "CREATE DATABASE IF NOT EXISTS $database";

    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully<br>";

        // Select the newly created database
        $conn->select_db($database);
        echo "Selected database: $database";
    } else {
        throw new Exception("Error creating database: " . $conn->error);
    }

    // SQL to create Venue table
    $sql_venue = "CREATE TABLE Venue (
        id INT AUTO_INCREMENT PRIMARY KEY,
        pic VARCHAR(255),
        name VARCHAR(255),
        price DECIMAL(10, 2),
        location VARCHAR(255),
        description TEXT,
        type VARCHAR(255),
        rate DECIMAL(3, 1),
        num_rates INT,
        num_guests INT,
        num_views INT,
        vendor_info TEXT,
        vendor_rating DECIMAL(3, 1)
    )";

    // SQL to create Music table
    $sql_music = "CREATE TABLE Music (
        id INT AUTO_INCREMENT PRIMARY KEY,
        pic VARCHAR(255),
        name VARCHAR(255),
        price DECIMAL(10, 2),
        description TEXT,
        type VARCHAR(255),
        rate DECIMAL(3, 1),
        num_rates INT,
        musician_rating DECIMAL(3, 1),
        num_members INT,
        instruments VARCHAR(255)
    )";

    // SQL to create Catering table
    $sql_catering = "CREATE TABLE Catering (
        id INT AUTO_INCREMENT PRIMARY KEY,
        pic VARCHAR(255),
        name VARCHAR(255),
        price DECIMAL(10, 2),
        description TEXT,
        type VARCHAR(255),
        rate DECIMAL(3, 1),
        num_rates INT
    )";

    // Execute SQL queries
    if ($conn->query($sql_venue) === TRUE) {
        echo "Venue table created successfully<br>";
    } else {
        echo "Error creating Venue table: " . $conn->error . "<br>";
    }

    if ($conn->query($sql_music) === TRUE) {
        echo "Music table created successfully<br>";
    } else {
        echo "Error creating Music table: " . $conn->error . "<br>";
    }

    if ($conn->query($sql_catering) === TRUE) {
        echo "Catering table created successfully<br>";
    } else {
        echo "Error creating Catering table: " . $conn->error . "<br>";
    }

    // Close connection
    $conn->close();
} catch (Exception $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
