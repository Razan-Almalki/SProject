<?php
include 'connection.php';

$searchTerms = array();

// Get search terms from the request
if(isset($_GET['first_name']) && !empty($_GET['first_name'])) {
    $searchTerms[] = "F_Name LIKE '%" . $_GET['first_name'] . "%'";
}

if(isset($_GET['middle_name']) && !empty($_GET['middle_name'])) {
    $searchTerms[] = "M_Name LIKE '%" . $_GET['middle_name'] . "%'";
}

if(isset($_GET['last_name']) && !empty($_GET['last_name'])) {
    $searchTerms[] = "L_Name LIKE '%" . $_GET['last_name'] . "%'";
}

// Construct the WHERE clause of the SQL query
$whereClause = implode(" OR ", $searchTerms);

if(!empty($whereClause)) {
    $sql = "SELECT * FROM guest WHERE $whereClause";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row as radio inputs
        echo "<p>فضلا ادخل اسمك</p>";
        echo "<hr>";
        while($row = $result->fetch_assoc()) {
            echo "<div class='row'>";
            echo $row['F_Name'] . " " . $row['M_Name'] . " " . $row['L_Name'] . "<input type='radio' name='guest' value='" . $row['ID'] . "'>" . "<br>";
            echo "</div>";
        }
        echo "<button class='buttons' onclick='selectGuest()'>اختر</button>";
    } else {
        echo "لا يوجد مدعو بهذا الاسم، ربما اكت حضورك مسبقا او فضلا تأكد من كتابة اسم بشكل صحيح";
    }
} 

$conn->close();
?>