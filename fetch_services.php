<?php
session_start();
include 'connection.php';

$loggedIn = isset($_SESSION["user_id"]);
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
<title>الحزم المخصصة</title>
<style>
    header {
    width: 100%;
    top: 0;
    left: 0;
    z-index: 10;
    padding: 0 10px;
}

.navbar .hamburger-btn {
    display: none;
    color: #000000;
    cursor: pointer;
    font-size: 1.5rem;
}

.navbar .logo {
    display: flex;
    align-items: center;
    text-decoration: none;
    margin-left: auto;
}

.navbar .logo img {
    width: 70px;
    /* Adjust the width as needed */
    height: auto;
    margin-right: 10px;
}

.navbar .logo h2 {
    font-family: 'Arial', sans-serif;
    color: #000000;
    font-weight: 600;
    font-size: 2rem;
}

.navbar .links {
    display: flex;
    gap: 35px;
    list-style: none;
    align-items: center;
}

.navbar .close-btn {
    position: absolute;
    right: 20px;
    top: 20px;
    display: none;
    color: #000;
    cursor: pointer;
}

.navbar .links a {
    color: #000000;
    font-size: 1.1rem;
    font-weight: 500;
    text-decoration: none;
    transition: 0.1s ease;
}

.navbar .links a:hover {
    color: #000000;
}

.dropdown-menu {
    display: none;
    position: absolute;
    background-color: #5755555f;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
}

.dropdown-menu a {
    color: #333333;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-menu a:hover {
    background-color: #9b59b6;
}

.nav-item.dropdown:hover .dropdown-menu {
    display: block;
}

body {
     
background-image: url("images/bg.jpg");
      background-size: cover;
    }
button {
      cursor: pointer;
        border-radius: 5em;
        color: #fff;
        background: linear-gradient(to right, #c79ede, #f7adc6);
        border: 0;
        padding-left: 40px;
        padding-right: 40px;
        padding-bottom: 10px;
        padding-top: 10px;
        font-family: 'Ubuntu', sans-serif;
        margin-left: 30%;
        font-size: 13px;
        box-shadow: 0 0 20px 1px rgba(0, 0, 0, 0.04);
    }

    .container {
        max-width: 600px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h1 {
        text-align: center;
    }
    form {
        text-align: left;
    }
    label {
        display: block;
        margin-bottom: 5px;
    }
    input[type="text"],
    input[type="number"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 3px;
        box-sizing: border-box;
    }
    input[type="checkbox"] {
        margin-bottom: 10px;
    }
    button {
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }
    button:hover {
        background-color: #45a049;
    }
    .service-container {
    display: flex;
    justify-content: space-around;
    align-items: center;
    flex-wrap: wrap;

    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

.service-info {
    flex: 0 0 30%; /* Adjust the width as needed */
    padding: 20px;
    margin: 10px;
    background-color: #ffffff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}
 /* Footer CSS */
 footer {
  background-color: #33333344;
  color: #fff;
  text-align: center;
  padding: 10px;
  position: relative;
  bottom: 0;
  width: 100%;
  margin-top: 500px;
}

.footer__container {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.footer__links {
  width: 100%;
  max-width: 1000px;
  display: flex;
  justify-content: center;
}

.footer__link--wrapper {
  display: flex;
}

.footer__link--items {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  margin: 16px;
  text-align: left;
  width: 160px;
  box-sizing: border-box;
}

.footer__link--items h2 {
  margin-bottom: 16px;
  color: #000000;
}

.footer__link--items a {
  color: #000000;
  text-decoration: none;
  margin-bottom: 0.5rem;
  transition: 0.3 ease-out;
}

.footer__link--items a:hover {
  color: #000000;
  transition: 0.3 ease-out;
}

#footer__logo {
  color: #000000;
  display: flex;
  align-items: center;
  cursor: pointer;
  text-decoration: none;
  font-size: 2rem;
}
#footer__logo {
  margin-bottom: 2rem;
}
.footer__logo img {
  width: 50px; /* Adjust the width to your desired size */
  height: auto; /* Maintain aspect ratio */
  vertical-align: middle; /* Align with the text vertically */
}

.footer__text {
  display: inline-block; /* Allow the text to be inline with the logo */
  vertical-align: middle; /* Align with the logo vertically */
  margin-left: 10px; /* Adjust the margin as needed */
  font-size: 20px; /* Adjust the font size to your desired size */
  font-weight: bold; /* Apply desired font weight */
}
.social__media {
  max-width: 1000px;
  width: 100%;
  margin-top: -60px;
}
.social__media--wrap {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 90%;
  max-width: 1000px;
  margin: 40px auto 0 auto;
}
.social__icons {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 240px;
}

.fab {
  font-family: "Font Awesome 5 Brands";
  color: black;
}

</style>
</head>
<body>
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
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the budgets for venue, catering, and musician
    $venueBudget = $_POST["venue_budget"];
    $cateringBudget = $_POST["catering_budget"];
    $musicianBudget = $_POST["musician_budget"];
    $theme = $_POST["theme"]; // Retrieve the selected theme

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

   // Fetch one service for each type based on the provided budgets and theme
$sql = "(SELECT * FROM services 
WHERE Service_type = 'Venue' AND Theme = ? AND Price <= ?
LIMIT 1)
UNION ALL
(SELECT * FROM services 
WHERE Service_type = 'Catering' AND Price <= ?
LIMIT 1)
UNION ALL
(SELECT * FROM services 
WHERE Service_type = 'Music' AND Price <= ?
LIMIT 1)";


    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sddd", $theme, $venueBudget, $cateringBudget, $musicianBudget);

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // JavaScript code for referencing buttons by class
    var venueButtons = document.getElementsByClassName('VenueButton');
    var cateringButtons = document.getElementsByClassName('CateringButton');
    var musicianButtons = document.getElementsByClassName('MusicButton');

    // Add event listener to each venue button
    Array.from(venueButtons).forEach(function(button) {
        button.addEventListener('click', function() {
            var serviceId = button.closest('[Service_ID]').getAttribute('Service_ID');
            redirectToDetailsPage('get_venue_data.php', serviceId);
        });
    });

    // Add event listener to each catering button
    Array.from(cateringButtons).forEach(function(button) {
        button.addEventListener('click', function() {
            var serviceId = button.closest('[Service_ID]').getAttribute('Service_ID');
            redirectToDetailsPage('get_catering_data.php', serviceId);
        });
    });

    // Add event listener to each musician button
    Array.from(musicianButtons).forEach(function(button) {
        button.addEventListener('click', function() {
            var serviceId = button.closest('[Service_ID]').getAttribute('Service_ID');
            redirectToDetailsPage('get_music_data.php', serviceId);
        });
    });

    // Function to fetch data and redirect to details page
    function redirectToDetailsPage(endpoint, serviceId) {
        fetch('http://localhost/' + endpoint + '?id=' + serviceId)
            .then(response => response.json())
            .then(data => {
                // Redirect to details page with service ID
                window.location.href = 'http://localhost/' + endpoint.replace('get_', '').replace('_data.php', '') + '_details.html?id=' + serviceId;
            })
            .catch(error => console.error('Error fetching data:', error));
    }
});

</script>
<br>
<br>
<br>
<h1 style="color:#896ba6;">هذا هو المكان الذي ستكتشف فيه الحزم المخصصة لميزانيتك</h1>

<div class="service-container">
    <!-- Your PHP-generated service HTML here -->
    <?php
    while ($row = $result->fetch_assoc()) {
        echo "<div class='service-info'>";
        echo "<h2>" . ucfirst($row['Service_type']) . " Service</h2>";
        echo "<p>" . $row['Service_name'] . " - $" . $row['Price'] . "</p>";
        echo "<button class='" . $row['Service_type'] . "Button' Service_ID='" . $row['Service_ID'] . "'>إقرأ المزيد</button>";
        echo "</div>";
    }
    ?>
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
        <a href="/" class="social__icon--link" target="_blank"
          ><i class="fab fa-facebook"></i
        ></a>
        <a href="/" class="social__icon--link"
          ><i class="fab fa-instagram"></i
        ></a>
        <a href="/" class="social__icon--link"
          ><i class="fab fa-youtube"></i
        ></a>
        <a href="/" class="social__icon--link"
          ><i class="fab fa-linkedin"></i
        ></a>
        <a href="/" class="social__icon--link"
          ><i class="fab fa-twitter"></i
        ></a>
      </div>
      </div>
      </section>
  </footer>
</body>
</html>