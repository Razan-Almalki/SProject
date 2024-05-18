<?php
session_start();

$loggedIn = isset($_SESSION["user_id"]);
$loggedInV = isset($_SESSION["vendor_id"]);

?>

<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
  <meta charset="UTF-8">
  <title>الدفع</title>
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
      <a href="index.php" class="logo">
        <img src="images/SorourIcon.png" alt="logo">
        <h2>سُرور</h2>
      </a>
      <ul class="links">
        <span class="close-btn material-symbols-rounded">close</span>
        <li>
          <a class="nav-link" href="about.html">عن سُرور</a>
        </li>
        <li>
          <a class="nav-link" href="service.php">الخدمات</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            أدوات التخطيط
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="busplitFINAL.php">تخطيط الميزانية</a>
            <a class="dropdown-item" href="guest.php">إدارة قائمة الضوف</a>
            <a class="dropdown-item" href="checklist.php">إدارة المهام</a>
            <a class="dropdown-item" href="Vendor.php">مقدم الخدمة</a>
          </div>
        </li>
        <li>
          <a class="nav-link" href="cart.php">السلة</a>
        </li>
        <li>
          <a class="nav-link" href="Login.html">تسجيل الدخول</a>
        </li>
        <li>
          <a class="nav-link" href="SignUp.html">إنشاء حساب</a>
        </li>
        <!-- display the item based on the user's authentication status -->
        <?php if ($loggedIn) { ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
              حسابي
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="userProfile.php">الاعدادات</a>
              <a class="dropdown-item" href="LogOut.php">تسجيل الخروج</a>
            </div>
          </li>
        <?php } else if ($loggedInV) { ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                حسابي
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="vendorProfile.php">الاعدادات</a>
                <a class="dropdown-item" href="LogOut.php">تسجيل الخروج</a>
              </div>
            </li>
        <?php } ?>
        <li>
          <a class="nav-link" href="SignUp.html">هل انت بائع؟</a>
        </li>
      </ul>
    </nav>
  </header>
  <div class="container">
    <div class="title">الدفع الالكتروني</div><br>
    <form id="paymentForm" onsubmit="return validatePaymentForm()">
      <!-- Payment form fields -->
      <div class="input-box">
        <input type="text" name="name" placeholder="اسم حامل البطاقة" required><br>
        <input type="number" name="cardNumber" placeholder="رقم البطاقة" required><br>
        <input type="text" name="expiryDate" placeholder="تاريخ الانتهاء (MM/YY)" required><br>
        <input type="number" name="cvv" placeholder="CVV" required><br>
      </div>
      <div class="payment-methods">
        <input type="checkbox" name="paymentMethod" value="paypal" id="paypalCheckbox" checked>
        <label for="paypalCheckbox">
          <img src="images/paypal.png" alt="PayPal">
        </label>
      </div>
      <span id="errorText"></span>
      <div class="button">
        <input type="submit" value="ادفع"></input>
      </div>
    </form>
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
            <a href="/">المزيد</a>
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
  <script src="payment.js"></script>
</body>

</html>