<?php

include 'connection.php';

if(isset($_GET['ID'])) {
    $guestID = $_GET['ID'];
    
    // Prepare the SQL statement to search for the guest by ID
    $sql = "SELECT * FROM guest WHERE ID = ?";
    
    // Prepare and bind parameters to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $guestID); // Assuming the ID is an integer
    
    // Execute the query
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Output data of each row as radio inputs
        echo "<p>فضلا ادخل اسمك</p>";
        echo "<hr>";
        while($row = $result->fetch_assoc()) {
            echo "<div class='row'>";
            echo "<input type='radio' name='guest' value='" . $row['ID'] . "'>" . $row['F_Name'] . " " . $row['M_Name'] . " " . $row['L_Name'] . "<br>";
            echo "</div>";
        }
        echo "<button class='buttons' onclick='selectGuest()'>اختر</button>";
    } else {
        echo "لا يوجد مدعو بهذا الرمز.";
    }
} 

$conn->close();
?>
