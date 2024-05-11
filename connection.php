<?php
$servername = "localhost";
$username = "root";
$password = "suma";
$dbname = "soso"; // This should match the existing database or the one you want to create

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
        Pass_word VARCHAR(255) NOT NULL
    )";

    if ($conn->query($sql_vendor) === TRUE) {
        // Table vendor created successfully
    } else {
        echo "Error creating table vendor: " . $conn->error . "\n";
    }

    // SQL to create table tasks
    $sql_tasks = "CREATE TABLE IF NOT EXISTS tasks ( 
        id INT AUTO_INCREMENT PRIMARY KEY, 
        user_id INT , 
        name VARCHAR(255) NOT NULL, 
        due_date DATE, 
        completed BOOLEAN, 
        FOREIGN KEY (user_id) REFERENCES user(User_ID) ON DELETE CASCADE
    )"; 
     
    if ($conn->query($sql_tasks) === TRUE) { 
        // Table tasks created successfully
    } else { 
        echo "Error creating table tasks: " . $conn->error . "\n"; 
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
        FOREIGN KEY (vendor_id) REFERENCES vendor(Vendor_ID) ON DELETE CASCADE
    )"; // Specify storage engine

    if ($conn->query($sql_services) === TRUE) {
        // Table services created successfully
    } else {
        echo "Error creating table services: " . $conn->error . "\n";
    }

    $sql_review = "CREATE TABLE IF NOT EXISTS review (
        Review_ID INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        service_id INT,
        Rate VARCHAR(255) NOT NULL,
        Comment VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES user(User_ID) ON DELETE CASCADE,
        FOREIGN KEY (service_id) REFERENCES services(Service_ID) ON DELETE CASCADE
    )";

    if ($conn->query($sql_review) === TRUE) {
        // Table review created successfully
    } else {
        echo "Error Review table: " . $conn->error . "\n";
    }

    $sql_reservation = "CREATE TABLE IF NOT EXISTS reservation (
    Reservation_ID INT AUTO_INCREMENT PRIMARY KEY,
    Service_ID INT,
    User_ID INT,
    Reservation_date DATE NOT NULL,
    State VARCHAR(255),
    FOREIGN KEY (Service_ID) REFERENCES services(Service_ID),
    FOREIGN KEY (User_ID) REFERENCES user(User_ID)
)";

if ($conn->query($sql_reservation) === TRUE) {
    // echo "Table Reservation created successfully\n";
} else {
    echo "Error Reservation table: " . $conn->error . "\n";
}

$sql_cart = "CREATE TABLE IF NOT EXISTS Cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_id INT,
    item_name VARCHAR(255),
    item_price DECIMAL(10, 2),
    deposit DECIMAL(10, 2),
    item_pic LONGBLOB,
    date DATE, -- Add the date attribute here
    user_id INT,
    FOREIGN KEY (item_id) REFERENCES services(Service_ID),
    FOREIGN KEY (user_id) REFERENCES user(User_ID)
)";


if ($conn->query($sql_cart) === TRUE) {
    // Table cart created successfully
} else {
    echo "Error Cart table: " . $conn->error . "\n";
}

    // SQL to create table guest
    $sql_guest = "CREATE TABLE IF NOT EXISTS guest (
        ID INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        FOREIGN KEY (user_id) REFERENCES user(User_ID) ON DELETE CASCADE,
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
        FOREIGN KEY (user_id) REFERENCES user(User_ID) ON DELETE CASCADE,
        Table_name VARCHAR(30) NOT NULL
    )"; // Specify storage engine
    

    // Execute the query
    if(isset($_SESSION['user_id'])) {
        // SQL to create table guest_tables
        $sql_guest_tables = "CREATE TABLE IF NOT EXISTS guest_tables (
            ID INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            FOREIGN KEY (user_id) REFERENCES user(User_ID) ON DELETE CASCADE,
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