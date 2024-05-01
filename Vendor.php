<!DOCTYPE html>

<head lang="ar">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Profile</title>
    <link rel="stylesheet" href="Vendor_style.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,1,0" />
</head>

<?php
session_start();
// Check if user is authenticated
$loggedInV = isset($_SESSION["vendor_id"]);
?>

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
    <main>
        <form>
            <div class="main-contianer">
                <h2 id="main-header">اعدادات الحساب</h2>
                <div class="contianer">
                    <div class="info">
                        <label>البريد الالكتروني</br></br>
                            <input type="text" name="email" value="weeedo01421@hotmail.com"
                                data-msgerror="you have to right your name">
                        </label>

                        <p class="se-div">تغيير البريد</p>
                    </div>
                </div>
                <div class="contianer">
                    <div class="info">
                        <label>رقم الجوال</br></br>
                            <input type="text" name="phone" value="0545424054" data-msgerror="">
                        </label>

                        <p class="se-div">تغيير رقم الجوال</p>
                    </div>
                </div>
                <div class="contianer">
                    <div class="info">
                        <label>كلمة المرور</br></br>
                            <input type="text" name="email" value="" data-msgerror="you have to right your name">
                        </label>

                        <label>اعادة كلمة المرور</br></br>
                            <input type="text" name="email" value="" data-msgerror="you have to right your name">
                        </label>

                        <p>تغيير كلمة المرور</p>
                    </div>
                </div>

                <div class="contianer">
                    <div class="info">
                        <label>الحساب البنكي</br></br>
                            <input type="text" name="email" value="" data-msgerror="you have to right your name">
                        </label>

                        <p>تغيير الحساب البنكي</p>
                    </div>
                </div>

                <div class="contianer">
                    <div class="info">
                        <p>حذف الحساب</p>
                    </div>
                </div>
            </div>

            </br>

            <div id="service-setting">
                <div class="main-contianer">
                    <h2 id="main-header">الخدمات</h2>
                    <div id="service-action">
                        <button type="button" onclick="openPopup()">
                            <span class="material-symbols-outlined">خدمة</span>
                            <span class="material-symbols-outlined">add_circle</span>
                        </button>
                        <button type="button">
                            <span class="material-symbols-outlined">خدمة</span>
                            <span class="material-symbols-outlined">delete</span>
                        </button>
                    </div>

                    <div class="services-contianer">
                        <h2> // type of service </h2>
                        <div class="services">
                            <div class="product-image">
                                // pic of service
                            </div>
                            <div class="product-info">
                                <h5> // name of service </h5>
                                <h6> // price of service </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div id="add-popup" class="popup" style="display: none;">
            <div class="popup__header">
                <h2 class="popup__title">اضافة خدمة</h2>
                <button class="popup__close" onclick="closePopup()">&#10006;</button>
            </div>
            <br>
            <div id="add-service-div">
                <div id="service-form">
                    <span id="venue-service" class="service-option" onclick="showForm('venue')">قاعة</span>
                    <span id="catering-service" class="service-option" onclick="showForm('catering')">خدمات
                        الطعام</span>
                    <span id="music-service" class="service-option" onclick="showForm('music')">موسيقى</span>
                </div>

                <form id="serviceForm" action="insert_service.php" method="POST" enctype="multipart/form-data">
                    <div id="restFields" style="display: none;">
                        <!-- Common fields -->
                        <div class="form__group field">
                            <input type="input" class="form__field" placeholder="اسم الخدمة" id="serviceName"
                                name="serviceName" required>
                            <label for="serviceName" class="form__label">اسم الخدمة</label>
                        </div>
                        <div class="form__group field">
                            <input type="input" class="form__field" placeholder="روابط وسائل التواصل الاجتماعي"
                                id="socialMedia" name="socialMedia">
                            <label for="socialMedia" class="form__label">روابط وسائل التواصل الاجتماعي</label>
                        </div>
                        <div class="form__group field">
                            <input type="input" class="form__field" placeholder="وصف الخدمة" id="description"
                                name="description">
                            <label for="description" class="form__label">وصف شامل للخدمة</label>
                        </div>
                        <div class="form__group field">
                            <input type="input" class="form__field" placeholder="السعر" id="price" name="price"
                                required>
                            <label for="price" class="form__label">السعر</label>
                        </div>
                        <div class="form__group field">
                            <input type="input" class="form__field" placeholder="الوديعة" id="deposit" name="deposit"
                                required>
                            <label for="deposit" class="form__label">العربون</label>
                        </div>
                        <div class="form__group field">
                            <input type="input" class="form__field" placeholder="الموقع" id="location" name="location"
                                required>
                            <label for="location" class="form__label">الموقع</label>
                        </div>
                        <div class="form__group field">
                            <input type="file" name="image" class="form__field" accept="image/*" />
                            <label for="pic" class="form__label">صورة للخدمة</label>
                        </div>

                        <div id="venueFields" class="form__group field">
                            <input type="input" class="form__field" placeholder="طابع الخدمة" id="theme" name="theme">
                            <label for="theme" class="form__label">نوع المكان</label>
                        </div>
                    </div>

                    <input type="hidden" id="service-type" name="service-type" value="">

                    <input type="hidden" id="vendorId" name="vendorId" value="<?php echo $_SESSION['vendor_id']; ?>">

                    <button type="submit">إضافة</button>
                </form>
            </div>
        </div>

        <div id="overlay"></div>

    </main>

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
        function showForm(serviceType) {

            var tInput = document.getElementById("service-type").value = serviceType;

            var form = document.getElementById("add-popup");
            var venueFields = document.getElementById("venueFields");
            var restFields = document.getElementById("restFields");

            // Display or hide venue-specific fields based on service type
            if (serviceType === 'venue') {
                restFields.style.display = "flex";
                venueFields.style.display = "block";
            } else {
                restFields.style.display = "flex";
                venueFields.style.display = "none";
            }

            // Change the background color of the clicked span
            var serviceSpans = document.querySelectorAll("#service-form span");
            serviceSpans.forEach(function (span) {
                if (span.id === serviceType + "-service") {
                    span.style.fontWeight = "bolder";
                    span.style.fontSize = "20px";
                    span.style.borderBottom = ".5px solid black";
                    span.style.paddingBottom = "15px";
                } else {
                    span.style.fontWeight = "normail";
                    span.style.fontSize = "12px";
                    span.style.borderBottom = "none";
                    span.style.paddingBottom = "0";
                }
            });
        }
    </script>

    <script>
        function openPopup() {
            document.getElementById("add-popup").style.display = "block";
            document.getElementById("overlay").style.display = "block";
        }

        function closePopup() {
            document.getElementById("add-popup").style.display = "none";
            document.getElementById("overlay").style.display = "none";
        }
    </script>
</body>