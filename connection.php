<?php
$servername = "localhost";
$username = "root";
$password = "Qazwsx12!";
$dbname = "sour"; // This should match the existing database or the one you want to create

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    // Select the database
    mysqli_select_db($conn, $dbname);

    // SQL to create table user
    $sql_user = "CREATE TABLE IF NOT EXISTS user (
        User_ID INT AUTO_INCREMENT PRIMARY KEY,
        First_name VARCHAR(50) NOT NULL,
        Last_name VARCHAR(50) NOT NULL,
        Email VARCHAR(100) NOT NULL UNIQUE,
        Pass_word VARCHAR(255) NOT NULL,
        Phone VARCHAR(10) NOT NULL
    )";

    if ($conn->query($sql_user) === TRUE) {
        // Table user created successfully
    } else {
        echo "Error creating table user: " . $conn->error . "\n";
    }

    // SQL to create table vendor
    $sql_vendor = "CREATE TABLE IF NOT EXISTS vendor (
        Vendor_ID INT AUTO_INCREMENT PRIMARY KEY,
        First_name VARCHAR(50) NOT NULL,
        Last_name VARCHAR(50) NOT NULL,
        Email VARCHAR(255) UNIQUE,
        Phone VARCHAR(255) UNIQUE,
        IBN VARCHAR(255) UNIQUE,
        Pass_word VARCHAR(255) NOT NULL
    )";

    if ($conn->query($sql_vendor) === TRUE) {
        // Table vendor created successfully
    } else {
        echo "Error creating table vendor: " . $conn->error . "\n";
    }

    // SQL to create table services
    $sql_services = "CREATE TABLE IF NOT EXISTS services (
        Service_ID INT AUTO_INCREMENT PRIMARY KEY,
        vendor_id INT,
        Service_type VARCHAR(255) NOT NULL,
        Service_name VARCHAR(255) NOT NULL,
        Social_media VARCHAR(255),
        Discription VARCHAR(255),
        Price DECIMAL(10, 2) NOT NULL,
        Deposit DECIMAL(10, 2) NOT NULL,
        Theme VARCHAR(255) NOT NULL,
        Location VARCHAR(255) NOT NULL,
        Map LONGTEXT,
        pic longblob,
        FOREIGN KEY (vendor_id) REFERENCES vendor(Vendor_ID)
    )"; // Specify storage engine

    if ($conn->query($sql_services) === TRUE) {
        // Table services created successfully
    } else {
        echo "Error creating table services: " . $conn->error . "\n";
    }

    // SQL to create table guest
    $sql_guest = "CREATE TABLE IF NOT EXISTS guest (
        ID INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        FOREIGN KEY (user_id) REFERENCES user(User_ID),
        F_Name VARCHAR(30) NOT NULL,
        M_Name VARCHAR(30) NOT NULL,
        L_Name VARCHAR(30) NOT NULL,
        Phone VARCHAR(20) NOT NULL,
        Attendance VARCHAR(30) NOT NULL,
        Relationship VARCHAR(30) NOT NULL
    )"; // Specify storage engine

    if ($conn->query($sql_guest) === TRUE) {
        // Table guest created successfully
    } else {
        echo "Error creating table guest: " . $conn->error . "\n";
    }

    // SQL to create table guest_tables
    $sql_guest_tables = "CREATE TABLE IF NOT EXISTS guest_tables (
        ID INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        FOREIGN KEY (user_id) REFERENCES user(User_ID),
        Table_name VARCHAR(30) NOT NULL
    )"; // Specify storage engine

    // Execute the query
    if(isset($_SESSION['user_id'])) {
        // SQL to create table guest_tables
        $sql_guest_tables = "CREATE TABLE IF NOT EXISTS guest_tables (
            ID INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            FOREIGN KEY (user_id) REFERENCES user(User_ID),
            Table_name VARCHAR(30) NOT NULL
        )";
    
        // Execute the query
        if ($conn->query($sql_guest_tables) === TRUE) {
            // Check if the user has no groups yet
            $sql_check_groups = "SELECT COUNT(*) AS count FROM guest_tables WHERE user_id = " . $_SESSION['user_id'];
            $result_check_groups = $conn->query($sql_check_groups);
    
            if ($result_check_groups) {
                $row = $result_check_groups->fetch_assoc();
                $group_count = $row['count'];
    
                // If the user has no groups, insert default groups
                if ($group_count == 0) {
                    $default_group_1 = "اقارب العروس";
                    $default_group_2 = "اقارب العريس";
    
                    $sql_insert_group_1 = "INSERT INTO guest_tables (user_id, Table_name) VALUES (" . $_SESSION['user_id'] . ", '$default_group_1')";
                    $sql_insert_group_2 = "INSERT INTO guest_tables (user_id, Table_name) VALUES (" . $_SESSION['user_id'] . ", '$default_group_2')";
    
                    $conn->query($sql_insert_group_1);
                    $conn->query($sql_insert_group_2);
                }
            } else {
                echo "Error checking groups: " . $conn->error;
            }
        } else {
            echo "Error creating table: " . $conn->error;
        }
    }

} else {
    echo "Error creating database: " . $conn->error . "\n";
}
?>