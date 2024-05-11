<?php

include "connection.php";

// Start session
session_start();

$loggedIn = isset($_SESSION["vendor_id"]);
if (!$loggedIn) {
    header("Location: Login_vendor.html");
    exit;
}


// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION["vendor_id"];

// Fetch user data from the database based on the user ID
$sql = "SELECT * FROM vendor WHERE Vendor_ID = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $firstName = $user['First_name'];
    $lastName = $user['Last_name'];
    $userEmail = $user['Email'];
    $userPhone = $user['Phone'];

    // to delet the account 
    if (isset($_POST['delete_account'])) {
        // Retrieve the entered email
        $enteredEmail = $_POST['entered_email'];

        // Check if the entered email matches the user's email
        if ($enteredEmail === $userEmail) {
            // Delete the user's account
            $deleteSql = "DELETE FROM vendor WHERE Vendor_ID = '$user_id'";
            if ($conn->query($deleteSql) === TRUE) {
                // Account deleted successfully. You can perform any additional actions here.
                echo "<script>alert('تم حذف الحساب بنجاح!')</script>";
                header("Location: LogOut.php"); // Redirect to the logout page or any other appropriate page
                exit;
            } else {
                // Store the error message in a variable
                $errorMessage = "خطأ في حذف الحساب: " . $conn->error;
            }
        } else {
            // Store the error message in a variable
            $errorMessage = "الايميل المدخل خطأ، حاول مرة اخرى";
        }
    }
} else {
    $firstName = "User Not Found";
    $lastName = "";
    $userEmail = "";
    $userPhone = "";
}

// Check if edining form submitted
if (isset($_POST['edit-button'])) {
    $firstName = $_POST['new-firstname'];
    $lastName = $_POST['new-lastname'];
    $phone = $_POST['new-phone'];

    // Validate data (optional)
    if (!preg_match("/^05\d{8}$/", $phone)) {
        $errorMessage1 = "الرقم المدخل غير صحيح!";
    } else {

        // Update vendor information in database
        $sql = "UPDATE vendor SET First_name = ?, Last_name = ?, Phone = ? WHERE Vendor_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssss', $firstName, $lastName, $phone, $_SESSION["vendor_id"]);
        $stmt->execute();

        if ($stmt->affected_rows === 1) {
            // Store the error message in a variable
            echo "<script>alert('تم تحديث بيانتك بنجاح!.')</script>";
            $errorMessage1 = "تم تحديث بيانتك بنجاح!." . $conn->error;
        } else {
            $errorMessage1 = "فشل تحديث البيانات." . $conn->error;
        }
        $stmt->close();
    }
}
// reset the password 
if (isset($_POST['change_password'])) {
    $currentPassword = $_POST['current-password'];
    $newPassword = $_POST['new-password'];
    $confirmPassword = $_POST['confirm-password'];

    // Fetch user data based on user ID (assuming you have a way to get it)
    $sql = "SELECT Pass_word FROM vendor WHERE Vendor_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $_SESSION["vendor_id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify current password
    if (password_verify($currentPassword, $user['Pass_word'])) {
        // Check if new password and confirm password match
        if ($newPassword === $confirmPassword) {
            // Hash the new password
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update the user's password in the database
            $sql = "UPDATE vendor SET Pass_word = ? WHERE Vendor_ID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('si', $hashedNewPassword, $_SESSION["vendor_id"]);
            if ($stmt->execute()) {
                // Password reset successful
                echo "<script>alert('تم تغيير كلمة المرور بنجاح!')</script>";
                $errorMessage2 = ' ' . $conn->error;
            } else {
                $errorMessage2 = 'فشل تغيير كلمة المرور!' . $conn->error;
            }
            $stmt->close();
        } else {
            $errorMessage2 = 'كلمة المرور الجديدة غير متطابقة!' . $conn->error;
        }
    } else {
        $errorMessage2 = 'كلمة المرور الحالية غير صحيحة!' . $conn->error;
    }
}

$conn->close();
?>


<!DOCTYPE html>
<!-- Created By CodingLab - www.codinglabweb.com -->
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8">
    <title>حسابي في سُرور</title>
    <link rel="stylesheet" href="style_vendorProfile.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/SorourIcon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_vendorProofile.css" />
</head>

<body>
    <header>
        <nav class="navbar">
            <a href="index.php" class="logo">
                <img src="images/SorourIcon.png" alt="logo">
                <h2>سُرور</h2>
            </a>
            <ul class="links">
                <li>
                    <a class="nav-link" href="about.php">عن سُرور</a>
                </li>
                <li>
                    <a class="nav-link" href="service.html">الخدمات</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        أدوات التخطيط
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="budgetP.html">تخطيط الميزانية</a>
                        <a class="dropdown-item" href="gm.html">إدارة قائمة الضوف</a>
                        <a class="dropdown-item" href="checklist.html">إدارة المهام</a>
                        <a class="dropdown-item" href="Vendor.php">مقدم الخدمة</a>
                    </div>
                </li>
                <li>
                    <a class="nav-link" href="contact.html">تواصل معنا</a>
                </li>
                <li>
                    <a class="nav-link" href="Login.html">تسجبل الدخول</a>
                </li>
                <li>
                    <a class="nav-link" href="SignUp.html">إنشاء حساب</a>
                </li>
                <!-- display the item based on the user's authentication status -->
                <?php if ($loggedIn) { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            حسابي
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="vendorProfile.php">الاعدادات</a>
                            <a class="dropdown-item" href="LogOut.php">تسجيل الخروج</a>
                        </div>
                    </li>
                <?php } else {
                } ?>
                <li>
                    <a class="nav-link" href="SignUp_vendor.html">هل انت بائع؟</a>
                </li>
            </ul>
        </nav>
    </header>

    <div class="choices-container">
        <div class="title">اعدادات الحساب</div>
        <ul class="choices">
            <li><a href="#" class="choice" data-choice="info">معلوماتي</a></li>
            <li><a href="#" class="choice" data-choice="edit">تعديل الحساب</a></li>
            <li><a href="#" class="choice" data-choice="password">تغيير كلمة المرور</a></li>
            <li><a href="#" class="choice" data-choice="delet">حذف الحساب</a></li>
        </ul>
    </div>
    <h3>مرحباً، <?php echo $firstName; ?></h3>
    <div class="info-container">
        <div id="user-info" class="info">
            <h2>معلومات الحساب</h2>
            <div id="user-info">
                <?php if ($firstName !== "User Not Found"): ?>
                    <p>الاسم: <?php echo $firstName, " ", $lastName; ?></p>
                    <p>الايميل: <?php echo $userEmail; ?></p>
                    <p>رقم الجوال: <?php echo $userPhone; ?></p>
                <?php else: ?>
                    <p>User information not found.</p>
                <?php endif; ?>
            </div>
        </div>
        <div id="edit-user-info" class="info">
            <h2>تعديل البيانات</h2>
            <form id="edit-form" method="POST">
                <label for="new-firstname">الاسم الاول:</label>
                <input type="text" id="new-firstname" name="new-firstname" required>
                <label for="new-lastname">اسم العائلة:</label>
                <input type="text" id="new-lastname" name="new-lastname" required>
                <label for="new-phone">رقم الجوال الجديد:</label>
                <input type="number" id="new-phone" name="new-phone" required>
                <div id="phone-error" class="error-message"></div>
                <div id="mess1"></div>
                <button type="submit" name="edit-button">حفظ</button>
            </form>
        </div>
        <div id="password-info" class="info">
            <h2>تغيير كلمة المرور</h2>
            <form id="change-password-form" method="POST">
                <label for="current-password">كلمة المرور الحالية: </label>
                <input type="password" id="current-password" name="current-password" required>
                <br>
                <label for="new-password">كلمة المرور الجديدة: </label>
                <input type="password" id="new-password" name="new-password" required>
                <br>
                <label for="confirm-password">تاكيد كلمة المرور الجديدة: </label>
                <input type="password" id="confirm-password" name="confirm-password" required>
                <span id="password-error" class="error-message"></span>
                <div id="mess2"></div>
                <button type="submit" name="change_password">تغيير كلمة المرور</button>
            </form>
        </div>
        <div id="delet-info" class="info">
            <h2>حذف الحساب</h2>
            <form id="delete-account-form" method="POST">
                <label for="entered-email">أدخل البريد الإلكتروني لتأكيد الحذف:</label>
                <input type="email" id="entered-email" name="entered_email" required>
                <div id="mess"></div>
                <button type="submit" name="delete_account">حذف الحساب</button>
            </form>
        </div>
    </div>
    <br><br><br><br>
    <!-- Footer Section -->
    <footer>
        <div class="footer__container">
            <div class="footer__links">
                <div class="footer__link--wrapper">
                    <div class="footer__link--items">
                        <h2>عنا</h2>
                        <a href="">الاعدادات</a>
                        <a href="about.php">المزيد</a>
                    </div>
                    <div class="footer__link--items">
                        <h2>تواصل معنا</h2>
                        <a href="/">راسلنا </a>
                        <a href="/">الدعم</a>
                    </div>
                </div>
                <div class="footer__link--wrapper">
                    <div class="footer__link--items">
                        <h2>سجل معنا</h2>
                        <a href="SignUp.html">زائر جديد؟</a>
                        <a href="SignUp_vendor.html">صاحب عمل؟</a>
                    </div>
                </div>
            </div>
            <section class="social__media">
                <div class="social__media--wrap">
                    <div class="footer__logo">
                        <a href="index.php" id="footer__logo">
                            <img src="images/SorourIcon.png" alt="sorour Logo"><span class="footer__text">سُرور</span>
                        </a>
                    </div>
                    <p class="website__rights">© جميع الحقوق محفوظة. فريق سُرور</p>
                    <div class="social__icons">
                        <a href="/" class="social__icon--link" target="_blank"><i class="fab fa-facebook"></i></a>
                        <a href="/" class="social__icon--link"><i class="fab fa-instagram"></i></a>
                        <a href="/" class="social__icon--link"><i class="fab fa-youtube"></i></a>
                        <a href="/" class="social__icon--link"><i class="fab fa-linkedin"></i></a>
                        <a href="/" class="social__icon--link"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </section>
    </footer>
    <script>
        <?php if (isset($errorMessage)): ?>
            // Display the error message in the 'mess' div
            var messDiv = document.getElementById('mess');
            messDiv.innerHTML = '<?php echo $errorMessage; ?>';
        <?php endif; ?>
        <?php if (isset($errorMessage1)): ?>
            // Display the error message in the 'mess' div
            var messDiv1 = document.getElementById('mess1');
            messDiv1.innerHTML = '<?php echo $errorMessage1; ?>';
        <?php endif; ?>
        <?php if (isset($errorMessage2)): ?>
            // Display the error message in the 'mess' div
            var messDiv2 = document.getElementById('mess2');
            messDiv2.innerHTML = '<?php echo $errorMessage2; ?>';
        <?php endif; ?>
    </script>
    <script src="userProfile.js"></script>
</body>

</html>