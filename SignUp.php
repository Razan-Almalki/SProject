<?php

include "connection.php";

// data from form 
$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$phone = $_POST['phone'];
$confirmPassword = $_POST['confirm_password'];

if ($conn->connect_error) {
    echo "$conn->connect_error";
    die("Connection Failed: " . $conn->connect_error);
} else {
    $errors = array(); // Initialize an empty array to store validation errors

    if ($password !== $confirmPassword) {
        $errors[] = "خطأ: كلمتا المرور غير متطابقتين.";
    }

    if (empty($firstName)) {
        $errors[] = "خطأ: الرجاء إدخال اسمك الأول.";
    }

    if (empty($lastName)) {
        $errors[] = "خطأ: الرجاء إدخال اسمك الأخير.";
    }

    if (empty($email)) {
        $errors[] = "خطأ: الرجاء إدخال عنوان بريدك الإلكتروني.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "خطأ: من فضلك أدخل عنوان إلكتروني صحيح.";
    } else {
        // Check if the email already exists in the database
        $check_email_query = "SELECT * FROM user WHERE Email = ?";
        $check_email_stmt = $conn->prepare($check_email_query);
        $check_email_stmt->bind_param("s", $email);
        $check_email_stmt->execute();
        $result = $check_email_stmt->get_result();

        if ($result->num_rows > 0) {
            $errors[] = "خطأ: عنوان البريد الإلكتروني '$email'مسجل مسبقا. ";
        }

        $check_email_stmt->close();
    }

    if (empty($phone)) {
        $errors[] = "خطأ: الرجاء إدخال رقم هاتفك. ";
    } elseif (!preg_match("/^05\d{8}$/", $phone)) {
        $errors[] = "خطأ: الرجاء إدخال رقم هاتف صالح. ";
    }

    if (empty($password)) {
        $errors[] = "خطأ: الرجاء إدخال كلمة المرور. ";
    } elseif (!preg_match("/^(?=.*[A-Z]).{6,}$/", $password)) {
        $errors[] = "خطأ: يجب أن تتكون كلمة المرور من 6 أحرف على الأقل وتحتوي على حرف كبير واحد على الأقل.";
    }

    if (empty($confirmPassword)) {
        $errors[] = "خطأ: يرجى تأكيد كلمة المرور الخاصة بك. ";
    } elseif ($password !== $confirmPassword) {
        $errors[] = "خطأ: كلمتا المرور غير متطابقتين. ";
    }

    // Check if there are any validation errors
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // the insert query
    $sql = "INSERT INTO user (First_name, Last_name, Email, Pass_word, Phone) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    
    if ($stmt === false) {
        die("Error: Could not prepare statement. (" . $conn->error . ")");
    } else {
        // Proceed with binding parameters
        $stmt->bind_param("sssss", $firstName, $lastName, $email, $hashedPassword, $phone);
        $stmt->execute();
        // check if the query executed
        if ($stmt->affected_rows === 1) {
            echo "تم انشاء الحساب بنجاح، انتقل الى صفحة تسجيل الدخول";

        } else {
            echo "Error: Registration failed. (" . $stmt->error . ")";
        }

    }

    $stmt->close();
    $conn->close();
}