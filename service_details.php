<?php

// Start session
session_start();

$loggedInV = isset($_SESSION["vendor_id"]);

if (!$loggedInV) {
    header("Location: Login_vendor.html");
    exit;
}

include 'connection.php';

// Check if Service_ID is provided in the URL
if (isset($_GET['Service_ID'])) {
    // Fetch the Service ID from the URL
    $service_id = $_GET['Service_ID'];

    // Prepare and execute query to retrieve service details
    $query = "SELECT * FROM services WHERE Service_ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $service_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if service exists
    if ($result->num_rows > 0) {
        $service = $result->fetch_assoc();
?>
        <!DOCTYPE html>
        <html lang="ar">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>تفاصيل الخدمة</title>
            <link rel="stylesheet" href="waad_style.css">
            <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,1,0" />
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
                        <!-- display the item based on the user's authentication status -->
                        <?php if ($loggedInV) { ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                <!-- Service details section -->
                <div id="service-container">
                    <!-- Service images -->
                    <div id="image-container">
                        <div class="images">
                            <!-- Image content -->
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($service['pic']); ?>" width="100%" height="500px" alt="">
                        </div>
                    </div>

                    <div id="images-actions">
                        <form id="picForm" enctype="multipart/form-data" action="update_service.php" method="post">
                            <div class="form__group field">
                                <input type="file" name="image" class="form__field" id="picInput" accept="image/*">
                                <label for="pic" class="form__label">صورة للخدمة</label>
                            </div>

                            <input type="hidden" id="service-id" name="service-id" value="<?php echo $service_id ?>">

                            <button type="submit" class="submit-btn-picForm main-button-style" name="update-image">تحديث
                                الصورة</button>
                        </form>
                    </div>

                    <div id="service-contents">
                        <!-- Content divs -->
                        <div class="content" onclick="display('info')">معلومات</div>
                        <div class="content" onclick="display('about')">حول</div>
                        <div class="content" onclick="display('location')">الموقع</div>
                    </div>

                    <?php
                    include 'connection.php';

                    // Fetch service details
                    $service_id = $_GET['Service_ID'];
                    $sql = "SELECT * FROM services WHERE Service_ID = $service_id";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $service = $result->fetch_assoc();

                        // Extract social media links
                        $socialMediaLinks = explode("\n", $service['Social_media']);

                        // Set the labels for the form fields
                        $serviceTypeLabel = $service['Service_type'];
                        $serviceNameLabel = $service['Service_name'];
                        $priceLabel = $service['Price'];
                        $depositLabel = $service['Deposit'];
                        $themeLabel = $service['Theme'];

                        $discriptionLabel = $service['Discription'];

                        $locationLabel = $service['Location'];
                        $mapLabel = $service['Map'];

                        // Assuming you have exactly three social media links
                        $tiktokLabel = $socialMediaLinks[0];
                        $instgramLabel = $socialMediaLinks[1];
                        $snapchatLabel = $socialMediaLinks[2];
                    ?>

                        <div class="service-info" id="info" style="display:none">
                            <form id="infoForm" action="update_service.php" method="post" enctype="multipart/form-data">
                                <div class="form__group field" style="width: 25%">
                                    <label for="serviceType" class="form__label">نوع الخدمة</label>
                                    <select id="serviceType" name="serviceType" class="form__field">
                                        <option selected disabled value="<?php echo $serviceTypeLabel; ?>">اختر نوع المكان</option>
                                        <option value="Venue">قاعة</option>
                                        <option value="Catering">تقديم الطعام</option>
                                        <option value="Music">موسيقى</option>
                                    </select>
                                </div>

                                <div class="form__group field" style="width: 25%">
                                    <input type="input" class="form__field" placeholder="<?php echo $serviceNameLabel; ?>" id="serviceName" name="serviceName" value="<?php echo $service['Service_name']; ?>" required>
                                    <label for="serviceName" class="form__label">اسم الخدمة</label>
                                </div>

                                <div id="socialMedia-input">
                                    <div class="form__group field" style="width: 118%">
                                        <input type="input" class="form__field" placeholder="<?php echo $tiktokLabel; ?>" id="tiktok" name="tiktok" oninput="validateSocialMediaFormat('tiktok')" value="<?php echo $socialMediaLinks[0]; ?>">
                                        <label for="tiktok" class="form__label">رابط صفحتك في التيكتوك</label>
                                    </div>
                                    <div class="form__group field" style="width: 118%">
                                        <input type="input" class="form__field" placeholder="<?php echo $instgramLabel; ?>" id="instgram" name="instgram" oninput="validateSocialMediaFormat('instgram')" value="<?php echo $socialMediaLinks[1]; ?>">
                                        <label for="instgram" class="form__label">رابط صفحتك في انستجرام</label>
                                    </div>
                                    <div class="form__group field" style="width: 118%">
                                        <input type="input" class="form__field" placeholder="<?php echo $snapchatLabel; ?>" id="snapchat" name="snapchat" oninput="validateSocialMediaFormat('snapchat')" value="<?php echo $socialMediaLinks[2]; ?>">
                                        <label for="snapchat" class="form__label">رابط صفحتك في السناب تشات</label>
                                    </div>
                                </div>

                                <input type="hidden" id="socialMedia" name="socialMedia" value="">

                                <div class="form__group field" style="width: 25%">
                                    <input type="input" class="form__field" placeholder="<?php echo $priceLabel; ?>" id="price" name="price" value="<?php echo $service['Price']; ?>" pattern="[0-9]*" required>
                                    <label for="price" class="form__label">السعر</label>
                                </div>

                                <div class="form__group field" style="width: 25%">
                                    <input type="input" class="form__field" placeholder="<?php echo $depositLabel; ?>" id="deposit" name="deposit" value="<?php echo $service['Deposit']; ?>" pattern="[0-9]*" required>
                                    <label for="deposit" class="form__label">العربون</label>
                                </div>

                                <?php if ($service['Service_type'] == 'Venue') : ?>
                                    <div id="venueFields" class="form__group field">
                                        <label for="theme" class="form__label">نوع المكان</label>
                                        <select id="theme" name="theme" class="form__field">
                                            <option selected disabled value="<?php echo $themeLabel; ?>"></option>
                                            <!-- Assuming you have predefined options for theme -->
                                            <option value="Hotel">فندق</option>
                                            <option value="Chalet">استراحه</option>
                                            <option value="Venue">قاعة</option>
                                        </select>
                                    </div>
                                <?php endif; ?>

                                <input type="hidden" id="service-id" name="service-id" value="<?php echo $service_id; ?>">

                                <button type="submit" id="submit-btn-infoForm" class="submit-btn-infoForm main-button-style" style="margin-top: 20px" name="update-info">تحديث
                                    المعلومات العامة</button>


                                <div id="socialMediaHint" style="color: black; display: none; margin-top: 20px;">يرجى إدخال الروابط
                                    بالصيغة الصحيحة
                                </div>
                            </form>
                        </div>

                    <?php
                    } else {
                        echo "No service found with ID: $service_id";
                        exit;
                    }
                    ?>

                    <div class="service-about" id="about" style="display:none">
                        <form id="aboutForm" action="update_service.php" method="post" enctype="multipart/form-data">
                            <div class="form__group field">
                                <input type="input" class="form__field" placeholder="<?php echo $discriptionLabel; ?>" id="description" name="description" value="<?php echo $service['Discription']; ?>">
                                <label for="description" class="form__label">وصف شامل للخدمة</label>
                            </div>

                            <input type="hidden" id="service-id" name="service-id" value="<?php echo $service_id; ?>">

                            <button type="submit" class="submit-btn-aboutForm main-button-style" style="margin-top: 20px" name="update-about">تحديث معلومات الوصف</button>
                        </form>
                    </div>

                    <div class="service-location" id="location" style="display:none">
                        <form id="locationForm" action="update_service.php" method="post" enctype="multipart/form-data">
                            <div class="form__group field" style="width: 100%">
                                <input type="input" class="form__field" placeholder="<?php echo $locationLabel; ?>" id="locationInput" name="location" value="<?php echo $service['Location']; ?>" required>
                                <label for="locationInput" class="form__label">المدينة</label>
                            </div>

                            <div class="form__group field" style="width: 100%">
                                <input type="input" class="form__field" placeholder="<?php echo htmlspecialchars($mapLabel); ?>" id="mapInput" name="map" oninput="validateMapFormat()" value="<?php echo htmlspecialchars($service['Map']); ?>" required>
                                <label for="mapInput" class="form__label">الموقع</label>
                            </div>

                            <input type="hidden" id="service-id" name="service-id" value="<?php echo $service_id; ?>">

                            <button type="submit" id="submit-btn-locationForm" class="submit-btn-locationtForm main-button-style" style="margin-top: 20px" name="update-location">تحديث
                                معلومات الموقع</button>

                            <div id="mapHint" style="display: none; color: black; margin-top: 20px;">فضلا اتبع الخطوات التالية
                                لادخال رابط الموقع بشكل صحيح: <br> 1. البحث في قوقل ماب عن الموقع المراد اضافة رابطة. <br> 2.
                                الضغط على ايقونة مشاركة. <br> 3. الضغط على خيار تضمين خريطة (اختر الحجم المتوسط). <br> 4. قم
                                بنسخ
                                الرابط والصاقه في الحقل.</div>
                        </form>

                        <?php echo $service['Map']; ?>
                    </div>
                </div>
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
                </div>
            </footer>

            <script>
                // Get references to the TikTok, Instagram, and Snapchat inputs
                var tiktokInput = document.getElementById("tiktok");
                var instgramInput = document.getElementById("instgram");
                var snapchatInput = document.getElementById("snapchat");

                // Get reference to the socialMedia input
                var socialMediaInput = document.getElementById("socialMedia");

                // Listen for form submission
                document.getElementById("infoForm").addEventListener("submit", function(event) {
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
                // Function to validate input format
                function validateMapFormat() {
                    var mapFormat = document.getElementById('mapInput').value;
                    var regex = /^<iframe src="https:\/\/www\.google\.com\/maps\/embed\?pb=.+" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"><\/iframe>$/;
                    var submitButton = document.getElementById('submit-btn-locationForm');
                    var hint = document.getElementById('mapHint');

                    if (mapFormat === '' || regex.test(mapFormat)) {
                        submitButton.disabled = false; // Enable submit button
                        hint.style.display = 'none'; // Hide the hint
                    } else {
                        submitButton.disabled = true; // Disable submit button
                        hint.style.display = 'block'; // Show the hint
                    }
                }

                // Attach event listener to input field
                document.getElementById('mapInput').addEventListener('input', validateMapFormat);
            </script>

            <script>
                function validateSocialMediaFormat(socialMedia) {
                    var input = document.getElementById(socialMedia).value;
                    var submitButton = document.getElementById('submit-btn-infoForm');
                    var regex;

                    // Set regex based on social media type
                    if (socialMedia === 'tiktok') {
                        regex = /^https:\/\/www\.tiktok\.com\/.+$/;
                    } else if (socialMedia === 'instgram') {
                        regex = /^https:\/\/www\.instagram\.com\/.+$/;
                    } else if (socialMedia === 'snapchat') {
                        regex = /^https:\/\/snapchat\.com\/.+$/;
                    }

                    if (input === '' || regex.test(input)) {
                        submitButton.disabled = false; // Enable submit button
                        document.getElementById('socialMediaHint').style.display = 'none'; // Hide the hint
                    } else {
                        submitButton.disabled = true; // Disable submit button
                        document.getElementById('socialMediaHint').style.display = 'block'; // Show the hint
                    }
                }
            </script>

            <script>
                // JavaScript function to toggle display of sections
                function display(sectionId) {
                    // Hide all sections
                    var sections = document.querySelectorAll('.service-info, .service-about, .service-location');
                    sections.forEach(function(section) {
                        section.style.display = 'none';
                    });

                    // Display the selected section
                    var selectedSection = document.getElementById(sectionId);
                    if (selectedSection) {
                        if (sectionId === 'location') {
                            selectedSection.style.display = 'flex';
                            selectedSection.style.margin = '20px';
                            selectedSection.style.justifyContent = 'space-between';
                        } else {
                            selectedSection.style.display = 'block';
                            selectedSection.style.margin = '20px';
                        }
                    }
                }
            </script>
        </body>

        </html>
<?php
    } else {
        // If no service found with the provided Service_ID
        echo "Service not found.";
    }

    // Close prepared statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // If Service_ID is not provided in the URL
    echo "Service ID not provided.";
}
?>