<?php
// Start session
session_start();

$loggedIn = isset($_SESSION["user_id"]);
$loggedInV = isset($_SESSION["vendor_id"]);

?>

<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
  <link rel="icon" href="images/SorourIcon.png" type="image/x-icon">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>سُرور</title>
  <link rel="stylesheet" href="style_index.css" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous" />
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
        <a class="nav-link" href="service.html">الخدمات</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          أدوات التخطيط
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="budgetP.html">تخطيط الميزانية</a>
          <a class="dropdown-item" href="guest.php">إدارة قائمة الضوف</a>
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
      <h1 class="hero__heading">خطط لحفل زفافك مع <span>سُرور</span></h1>
      <p class="hero__description">مرحبًا بك في موقع سُرور، الموقع الذي يقدم خدمات تنظيم حفلات الزفاف.
        <br>نحن هنا لمساعدتك في جعل حفل زفافك لحظة لا تُنسى!.
      </p>
      <button class="main__btn"><a href="budgetP.html">خطط الان</a></button>
    </div>
  </div>

  <!-- About Section -->
  <div class="main" id="about">
    <div class="main__container">
      <div class="main__img--container">
        <div class="main__img--card"><img src="images/blog_img2.jpg" alt="Description of the image"></div>
      </div>
      <div class="main__content">
        <h2>رسالتنا</h2>
        <p>تبسيط وتعزيز تجربة تخطيط الأعراس للأزواج في المملكة العربية السعودية. نحن نسعى لتوفير منصة سهلة
          الاستخدام تجمع بين جميع الخدمات الأساسية للأعراس،
          بما في ذلك قاعات الزفاف، خدمات الموسيقى، تقديم الطعام، إدارة الميزانية وإدارة قائمة الضيوف بكفاءة. من
          خلال تقديم حل شامل وفعال، نهدف إلى تخفيف التحديات والضغوط التي يواجهها الأزواج أثناء التحضير لحفل
          الزفاف.</p>
      </div>
    </div>
  </div>

  <!-- Services Section -->
  <div class="services" id="services">
    <h1>خدماتنا</h1>
    <div class="services__wrapper">
      <div class="services__card">
        <h2>تخطيط ميزانية حفل الزفاف</h2>
        <p>أدخل المعلومات المتعلقة بالخدمات المطلوبة لحفل الزفاف لضبط الميزانية بما يتناسب مع احتياجاتك.
          سنقوم بإنشاء النسب المئوية لكل خدمة وتقديم قائمة مخصصة من البائعين الموصى بهم مع خدماتهم.</p>
        <div class="services__btn"><a href="budgetP.html"><button>المزيد</button></a></div>
      </div>
      <div class="services__card">
        <h2>حجز الخدمات</h2>
        <p>يوفر سرور قاعات الزفاف المختلفة، وخدمات الموسيقى، وخيارات تقديم الطعام.
          نهدف الى تزويد الأزواج بقاعدة بيانات شاملة للموردين، مما يمكنهم من استكشاف خدماتهم المفضلة
          ومقارنتها وحجزها بسرعة داخل الموقع.</p>
        <div class="services__btn"><a href="service.html"><button>المزيد</button></a></div>
      </div>
      <div class="services__card">
        <h2>إدارة قائمة الضيوف</h2>
        <p>يمكن للأزواج إنشاء قائمة الضيوف، إرسال الدعوات، والرد عليها لتنظيم الحدث وإدارته بشكل أفضل عن طريق
          إرسال رسائل واتس اب وتلقي حالتهم.</p>
        <div class="services__btn"><a href="gm.html"><button>المزيد</button></a></div>
      </div>
    </div>
  </div>

  <!-- Features Section -->
  <div class="main" id="sign-up">
    <div class="main__container">
      <div class="main__content">
        <h2>رؤيتنا</h2>
        <p>أن نصبح الوجهة الرئيسية عبر الإنترنت للأزواج في المملكة العربية السعودية الذين يبحثون عن تجربة سلسة
          وممتعة في تخطيط حفل الزفاف.
          سُرور تمكن الأزواج من تخطيط حفل زفاف الأحلام بسهولة، مع الوصول إلى مجموعة واسعة من البائعين والخدمات
          الموثوقة، وأدوات إدارة الميزانية الشخصية،
          وإدارة الضيوف. من خلال تكنولوجيتنا المبتكرة والتزامنا الثابت برضا العملاء، نطمح إلى إعادة تعريف مشهد
          تخطيط حفل الزفاف، وجعله تجربة لا تُنسى وممتعة لكل زوجين.</p>
        <button class="main__btn"><a href="about.html">المزيد عنا</a></button>
      </div>
      <div class="main__img--container">
        <div class="main__img--card">
          <img src="images/blog_img2.jpg" alt="Description of the image">
        </div>
      </div>
    </div>
  </div>

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
</body>

</html>