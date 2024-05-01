<?php

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
        $response = array("success" => false, "message" => "خطأ: كلمة المرور مطلوب.");
        echo json_encode($response);
        exit;
    }

    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $dbpassword = "suma";
    $dbname = "sorour";

    $conn = new mysqli($servername, $username, $dbpassword, $dbname);

    if ($conn->connect_error) {
        $response = array("success" => false, "message" => "Error: Could not connect to the database.");
        echo json_encode($response);
        exit;
    }

    // Prepare SQL statement
    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        $response = array("success" => false, "message" => "Error: Could not prepare the statement.");
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
        $response = array("success" => false, "message" => " خطأ: الايميل '$email' غير مسجل.");
        echo json_encode($response);
        exit;
    }

    // Fetch user data
    $user = $result->fetch_assoc();

    // Verify password
    if (!password_verify($password, $user["Pass_word"])) {
        $response = array("success" => false, "message" => "خطأ: كلمة المرور غير صحيحة.");
        echo json_encode($response);
        exit;
    } else {
        // Start session
        session_start();

        // Set session variables after successful login
        $_SESSION["user_id"] = $user["user_ID"];
        $_SESSION["user_name"] = $user["first_name"] . " " . $user["last_name"];

        $response = array("success" => true, "message" => "Login successful", "user_name" => $_SESSION["user_name"], "user_id" => $_SESSION["user_id"]);
        echo json_encode($response);
        exit;
    }
    // Close the database connection
    $conn->close();
}
