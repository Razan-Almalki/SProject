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
    <title>عن سُرور</title>
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
                <!-- display the item based on the user's authentication status -->
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
            <h1 class="hero__heading">حول <span>سُرور</span></h1>
            <p class="hero__description">نسعى في سُرور لتبسيط تجربة تخطيط حفل الزفاف للجميع في المملكة العربية السعودية.
                <br> من خلال توفير منصة سهلة الاستخدام تجمع بين قاعات ومشغلي المطاعم والموسيقيين، نهدف إلى جعل عملية التخطيط انسيابية وإزالة الضغوطات التي يواجهها الأزواج خلال فترة التحضير.
            </p>
        </div>

        <!-- About Section -->
        <div class="main__content1">
            <h2>كيف يعمل سُرور؟.</h2>
            <ul>
                <li class="container">
                    <img src="images/1.png" alt="Image 1" id="image1">
                    <div>
                        <h3>تصفح الخدمات</h3>
                        <p>تصفّحوا بين تشكيلة واسعة من قاعات الأفراح والمطاعم والموسيقيين، قارنوا الأسعار والخدمات المقدمة</p>
                    </div>
                </li>
                <li class="container">
                    <img src="images/2.png" alt="Image 2" id="image2">
                    <div>
                        <h3>استخدم اداة تخطيط الميزانية</h3>
                        <p>استفيدوا من أداة تخطيط الميزانية الذكية التي تساعدكم على تخصيص ميزانية زفافكم وفقًا لرغباتكم وأولوياتكم، لحجز مجموعة من الخدمات اللتي تتناسب مع ميزانيتكم. </p>
                    </div>
                </li>
                <li class="container">
                    <img src="images/3.png" alt="Image 3" id="image3">
                    <div>
                        <h3>اختر مايناسبك وضعه في السلة</h3>
                        <p>بمجرد العثور على الخدمة التي تناسب احتياجاتك، يمكنك وضعها في سلة التسوق الخاصة بك</p>
                    </div>
                </li>
                <li class="container">
                    <img src="images/4.png" alt="Image 3" id="image3">
                    <div>
                        <h3>تحدث مع مورد الخدمة للمزيد من التفاصيل</h3>
                        <p> يمكنك التواصل مع موردي الخدمات للحصول على مزيد من التفاصيل. يمكنك مناقشة متطلباتك الخاصة، والحصول على تفاصيل الأسعار وأي معلومات إضافية</p>
                    </div>
                </li>
                <li class="container">
                    <img src="images/5.png" alt="Image 3" id="image3">
                    <div>
                        <h3>ادفع لتأكيد حجوزاتك!</h3>
                        <p>بمجرد أن تضع الخدمات المناسبة في سلة التسوق الخاصة بك وتكون راضيًا عن اختياراتك، يمكنك المضي قدمًا وإتمام عملية الدفع عن طريق باي بال لتأكيد حجوزاتك</p>
                    </div>
                </li>
            </ul>
        </div>
        <!-- Services Section -->
        <div class="services" id="services">
            <h1>للموردين</h1>
            <div class="services__wrapper">
                <div class="services__card">
                    <h2>العرض على منصة واسعة الانتشار</h2>
                    <p>الوصول إلى قاعدة واسعة من العملاء المحتملين من خلال الانضمام إلى منصة سُرور.</p>
                </div>
                <div class="services__card">
                    <h2>إدارة الحجوزات</h2>
                    <p>تلقى حجوزات العملاء مباشرةً من خلال سُرور، واعرضوا عروضكم الخاصة واجذبوا المزيد من الزبائن.</p>
                </div>
                <div class="services__card">
                    <h2>تعزيز ملفكم الشخصي</h2>
                    <p>استعرضوا خدماتكم وأعمالكم السابقة وشاركونا بآراء العملاء الإيجابية لتعزيز ملفكم الشخصي والمصداقية تجاه الزبائن المحتملين.</p>
                </div>
            </div>
        </div>
        <!-- Footer Section -->
        <div class="footer__container1">
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