<?php
// Start session
session_start();

include "connection.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate email and password
    if (empty($email)) {
        $response = array("success" => false, "message" => "خطأ: البريد الإلكتروني مطلوب.");
        echo json_encode($response);
        exit;
    }

    if (empty($password)) {
        $response = array("success" => false, "message" => "خطأ: كلمة المرور مطلوبة.");
        echo json_encode($response);
        exit;
    }

    // Prepare SQL statement
    $sql = "SELECT * FROM vendor WHERE Email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        $response = array("success" => false, "message" => "خطأ: لم يتمكن من تحضير الاستعلام.");
        echo json_encode($response);
        exit;
    }

    // Bind parameters
    $stmt->bind_param("s", $email);

    // Execute query
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows === 0) {
        $response = array("success" => false, "message" => " خطأ: البريد الإلكتروني '$email' غير مسجل.");
        echo json_encode($response);
        exit;
    }

    // Fetch user data
    $vendor = $result->fetch_assoc();

    // Verify password
    if (!password_verify($password, $vendor["Pass_word"])) {
        $response = array("success" => false, "message" => "خطأ: كلمة المرور غير صحيحة.");
        echo json_encode($response);
        exit;
    } else {
        // Set session variables after successful login
        $_SESSION["Vendor_ID"] = $vendor["Vendor_ID"];
        $_SESSION["user_name"] = $vendor["First_name"] . " " . $vendor["Last_name"];

        $response = array("success" => true, "message" => "Login successful", "user_name" => $_SESSION["user_name"], "Vendor_ID" => $_SESSION["Vendor_ID"]);
        echo json_encode($response);
        exit;
    }
}

// Close the database connection
$conn->close();
?>
