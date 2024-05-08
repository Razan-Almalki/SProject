<?php
// database connection
include "connection.php";

// Check the connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['reset_password'])) {
// Retrieve the user's email and new password from the submitted form
$email = $_POST['reset-email'];
$newPassword = $_POST['new-password'];
$confirmedPassword = $_POST['confirm-password'];

// Perform a database query to check if the email exists
$query = "SELECT * FROM vendor WHERE Email = '$email'";
$result = mysqli_query($conn, $query);

// Check if a row is returned(Email exists)
if (mysqli_num_rows($result) > 0) {
  if (isValidPassword($newPassword)) {// New password meet the requirements
    // 
    if ($newPassword === $confirmedPassword) {
      // Hash the new password
      $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
      // Update the user's password in the database
      $sql = "UPDATE vendor SET Pass_word = ? WHERE Email = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param('ss', $hashedNewPassword, $email);
      if ($stmt->execute()) {
        // Password reset successful
        echo "<script>alert('تم تغيير كلمة المرور بنجاح!')</script>";
        header("Location: Login.html");
          exit(); // Terminate the current script
    }
  }
    // New password does not meet the requirements
    else {
      $errorMessage = 'كلمة المرور الجديدة غير متطابقة!';
    }
  }else {
    $errorMessage = "كلمة المرور يجب أن تحتوي على حرف كبير على الأقل وأن تتكون من 6 أحرف على الأقل";
  }
  
} else {
  // Email does not exist, display an error message or redirect back to the form
  $errorMessage = "الايميل المدخل غير موجود!." ;
}
}

function isValidPassword($password){
  $passwordRegex = '/^(?=.*[A-Z]).{6,}$/';
  return preg_match($passwordRegex, $password);
}

?>

<!DOCTYPE html>
<!-- Created By CodingLab - www.codinglabweb.com -->
<html dir="rtl" lang="ar">

<head>
  <meta charset="UTF-8">
  <title>انشاء حساب</title>
  <link rel="icon" href="images/SorourIcon.png" type="image/x-icon">
  <link rel="stylesheet" href="style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="icon" href="images/SorourIcon.png" type="image/x-icon">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
  <!-- Boxicons CSS -->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script language="javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.0.1.min.js"></script>
</head>

<body>
  <header>
    <nav class="navbar">
      <span class="hamburger-btn material-symbols-rounded">menu</span>
      <a href="index.html" class="logo">
        <img src="images/SorourIcon.png" alt="logo">
        <h2>سُرور</h2>
      </a>
      <ul class="links">
        <span class="close-btn material-symbols-rounded">close</span>
        <li>
          <a class="nav-link" href="about.php">عن سُرور</a>
        </li>
        <li>
          <a class="nav-link" href="service.html">الخدمات</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            أدوات التخطيط
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="budgetP.html">تخطيط الميزانية</a>
            <a class="dropdown-item" href="gm.html">إدارة قائمة الضوف</a>
            <a class="dropdown-item" href="checklist.html">إدارة المهام</a>
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
       <li>
          <a class="nav-link" href="SignUp.html">هل انت بائع؟</a>
        </li>
      </ul>
    </nav>
  </header>

  <!-- end header inner -->
  <div class="container">
    <div class="title">استعادة كلمة المرور</div>
    <div class="content">
      <form method="post" id="reset-password-form">
        <div class="input-box">
          <br><span class="details">البريد الإلكتروني:</span>
          <input type="email" id="reset-email" name="reset-email" placeholder=" ادخل البريد الالكتروني" required>
          <span class="new-password">كلمة المرور الجديدة: </span>
          <input type="password" id="new-password" name="new-password" placeholder="ادخل كلمة المرور الجديدة " required>
          <span class="details">تاكيد كلمة المرور الجديدة:</span>
          <input type="password" id="confirm-password" name="confirm-password" placeholder="ادخل تاكيد كلمة المرور الجديدة" required>
          <span id="password-error" class="error-message"></span>
        </div>
        <div class="button">
          <input type="submit" name="reset_password" value="تغيير"></input>
        </div>
      </form>
    </div>
  </div>
  </div>

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
            <a href="#">صاحب عمل؟</a>
          </div>
        </div>
      </div>
      <section class="social__media">
        <div class="social__media--wrap">
          <div class="footer__logo">
            <a href="index.html" id="footer__logo">
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
  <script src="restorePassword.js"></script>
  <script>
        <?php if (isset($errorMessage)) : ?>
            // Display the error message in the 'mess' div
            var messDiv = document.getElementById('password-error');
            messDiv.innerHTML = '<?php echo $errorMessage; ?>';
        <?php endif; ?>
        </script>
</body>
</html>