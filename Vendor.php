<!DOCTYPE html>

<head lang="ar">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Profile</title>
    <link rel="stylesheet" href="style_index.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,1,0" />
</head>

<?php
session_start();
// Check if user is authenticated
$loggedInV = isset($_SESSION['Vendor_ID']);
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
                <?php if (isset($_SESSION["Vendor_id"])) { ?>
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

                    <?php
                    include "connection.php";

                    // Query to retrieve services based on vendor ID
                    $sql = "SELECT * FROM services WHERE vendor_id=" . $_SESSION['Vendor_ID'];
                    $result = $conn->query($sql);

                    // Associative array to store services categorized by service type
                    $servicesByType = array();

                    // Check if there are services available
                    if ($result->num_rows > 0) {
                        // Loop through each row of the result set
                        while ($row = $result->fetch_assoc()) {
                            // Store service details in an array
                            $serviceDetails = array(
                                "service_name" => $row["Service_name"],
                                "service_type" => $row["Service_type"],
                                "service_image" => $row["pic"]
                            );

                            // Append the service details to the array corresponding to its service type
                            $servicesByType[$row["Service_type"]][] = $serviceDetails;
                        }
                    }
                    ?>

                    <!-- HTML to display services organized by service type -->
                    <div class="services-container">
                        <?php
                        // Loop through each service type
                        foreach ($servicesByType as $serviceType => $services) {
                            // Display the service type based on the type of service
                            switch ($serviceType) {
                                case 'venue':
                                    $serviceTypeName = "القاعات";
                                    break;
                                case 'catering':
                                    $serviceTypeName = "خدمات تقديم الطعام";
                                    break;
                                case 'music':
                                    $serviceTypeName = "الخدمات الموسيقية";
                                    break;
                                default:
                                    $serviceTypeName = $serviceType; // Use the original service type if not matched
                            }
                            echo "<h2>$serviceTypeName</h2>"; // Display the service type as a heading
                            echo "<div class='service-type-container'>";

                            // Loop through each service of the current service type
                            foreach ($services as $service) {
                                echo '<div class="services">';
                                echo '<div class="product-image">';
                                echo '<img src="data:image/jpeg;base64,' . base64_encode($service["service_image"]) . '" width="160px" height="80px" alt="Service Image">';
                                echo '</div>';
                                echo '<div class="product-info">';
                                echo "<h5>{$service['service_name']}</h5>"; // Display the service name
                                // You can include additional information such as price here
                                echo '</div>';
                                echo '</div>';
                            }

                            echo "</div>"; // Close service-type-container
                        }
                        ?>
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

                        <div id="socialMedia-input">
                            <div class="form__group field" style="width: 118%">
                                <input type="input" class="form__field" placeholder="روابط وسائل التواصل الاجتماعي"
                                    id="tiktok" name="tiktok">
                                <label for="tiktok" class="form__label">رابط صفحتك في التيكتوك</label>
                            </div>
                            <div class="form__group field" style="width: 118%">
                                <input type="input" class="form__field" placeholder="روابط وسائل التواصل الاجتماعي"
                                    id="instgram" name="instgram">
                                <label for="instgram" class="form__label">رابط صفحتك في انستجرام</label>
                            </div>
                            <div class="form__group field" style="width: 118%">
                                <input type="input" class="form__field" placeholder="روابط وسائل التواصل الاجتماعي"
                                    id="snapchat" name="snapchat">
                                <label for="snapchat" class="form__label">رابط صفحتك في السناب تشات</label>
                            </div>
                        </div>
                        <input type="hidden" id="socialMedia" name="socialMedia" value="">

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
                            <input type="input" class="form__field" placeholder="المدينة" id="location" name="location"
                                required>
                            <label for="location" class="form__label">المدينة</label>
                        </div>

                        <div class="form__group field">
                            <input type="input" class="form__field" placeholder="الموقع" id="map" name="map" required>
                            <label for="map" class="form__label">الموقع</label>
                        </div>

                        <div class="form__group field">
                            <input type="file" name="image" class="form__field" accept="image/*" />
                            <label for="pic" class="form__label">صورة للخدمة</label>
                        </div>

                        <div id="venueFields" class="form__group field">
                            <label for="theme" class="form__label">نوع المكان</label>
                            <select id="theme" name="theme" class="form__field">
                                <option selected disabled value="" style="display: none">اختر نوع المكان</option>
                                <option value="Hotel">فندق</option>
                                <option value="Chalet">استراحه</option>
                                <option value="Venue">قاعة</option>
                            </select>
                        </div>
                    </div>

                    <input type="hidden" id="service-type" name="service-type" value="">

                    <input type="hidden" id="vendorId" name="vendorId" value="<?php echo $_SESSION['Vendor_ID']; ?>">

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
        // Get references to the TikTok, Instagram, and Snapchat inputs
        var tiktokInput = document.getElementById("tiktok");
        var instgramInput = document.getElementById("instgram");
        var snapchatInput = document.getElementById("snapchat");

        // Get reference to the socialMedia input
        var socialMediaInput = document.getElementById("socialMedia");

        // Listen for form submission
        document.getElementById("serviceForm").addEventListener("submit", function (event) {
            // Concatenate the values with empty lines if they are not empty
            var socialMediaValue = "";

            if (tiktokInput.value.trim() !== "") {
                socialMediaValue += tiktokInput.value.trim() + "\n";
            }

            if (instgramInput.value.trim() !== "") {
                socialMediaValue += instgramInput.value.trim() + "\n";
            }

            if (snapchatInput.value.trim() !== "") {
                socialMediaValue += snapchatInput.value.trim() + "\n";
            }

            // Remove the last new line character
            socialMediaValue = socialMediaValue.trim();

            // Assign the concatenated value to the socialMedia input
            socialMediaInput.value = socialMediaValue;
        });
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