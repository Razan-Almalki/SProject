<?php 
session_start(); 
include 'connection.php';

$loggedIn = isset($_SESSION['user_id']);
if (!$loggedIn) {
    header("Location: Login.html");
    exit;
  }
?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/SorourIcon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
  <!-- Boxicons CSS -->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>الخدمات</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="Rstyle.css">
</head>
<body>
<!-- Navbar Section -->
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
        <a class="nav-link" href="about.php">عن سُرور</a>
      </li>
      <li>
        <a class="nav-link" href="service.php">الخدمات</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          أدوات التخطيط
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="busplitFINAL.php">تخطيط الميزانية</a>
          <a class="dropdown-item" href="guest.php">إدارة قائمة الضوف</a>
          <a class="dropdown-item" href="checklist.php">إدارة المهام</a>
          <a class="dropdown-item" href="Vendor.php">الخدمة مقدم</a>
        </div>
      </li>
      <li>
        <a class="nav-link" href="cart.php">السلة</a>
      </li>
      <li>
        <a class="nav-link" href="Login.html">تسجبل الدخول</a>
      </li>
      <li>
        <a class="nav-link" href="SignUp.html">إنشاء حساب</a>
      </li>

      <?php if ($loggedIn) { ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            حسابي
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="userProfile.php">الاعدادات</a>
            <a class="dropdown-item" href="LogOut.php">تسجيل الخروج</a>
          </div>
        </li>
      <?php } else if ($loggedInV) { ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            حسابي
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="vendorProfile.php">الاعدادات</a>
            <a class="dropdown-item" href="LogOut.php">تسجيل الخروج</a>
          </div>
        </li>
      <?php } ?>

      <li>
        <a class="nav-link" href="SignUp_vendor.html">هل انت بائع؟</a>
      </li>
    </ul>
  </nav>
</header>
  <!-- end header inner -->
  
    <!-- banner Section -->
    <div class="hero" id="home">
    <div class="hero__container">
      <h1 class="hero__heading">مرحبًا بكم في موقع الزفاف الخاص بناَ!.</h1>
      <p class="hero__description">نحن نقدم لك خدماتنا الثلاث الأساسية المتميزة لجعل يوم زفافك لحظة لا تُنسى.</p>
    </div>
  </div>

        <div class="services-panels">
            <div>
                <figure><img src="images/venue.jpg" alt="an image of the inside of a venue"/></figure>
                <h3>القاعات</h3>
                <p>نقدم مجموعة متنوعة من القاعات الفخمة والراقية لاستضافة حفل زفافك بأسلوب يتناسب مع ذوقك واحتياجاتك.</p>
                <button id="venueButton">إقرأ المزيد</button>
            </div>
            <div>
                <figure><img src="images/music.jpg" alt="A pic of a singer"/></figure>
                <h3>الموسيقى</h3>
               <p> سواء كنت تفضل الأجواء الهادئة أو الاحتفالية، فإننا نوفر لك مجموعة متنوعة من الفرق الموسيقية المحترفة لجعل ليلتك لا تُنسى بالأنغام الجميلة.</p>
                <button id="musicButton">إقرأ المزيد</button>
            </div>
            <div>
                <figure><img src="images/catering.jpg" alt="diffrent plates of food"/></figure>
                <h3>تقديم الطعام</h3>
                <p>يمكنك الاعتماد علينا لتقديم تجربة طعام فاخرة وشهية لضيوفك. نقدم قوائم متنوعة ومخصصة لتلبية جميع الأذواق والاحتياجات الغذائية.</p>
                <button id="cateringButton">إقرأ المزيد</button>
            </div>
        </div>

        <footer>
              <!-- Footer Section -->
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
  </div>
        </footer>
	<script>
	     document.getElementById("venueButton").onclick = function() {
             window.location.href = "venue.php"; // Redirect to venue.html
              };

	     document.getElementById("cateringButton").onclick = function() {
             window.location.href = "catering.php"; // Redirect to catering.html
             };

             document.getElementById("musicButton").onclick = function() {
             window.location.href = "music.php"; // Redirect to music.html
             };
	</script>
    </body>
</html>
