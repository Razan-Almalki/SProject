<?php
session_start();
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
    <link rel="icon" href="images/SorourIcon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
  <!-- Boxicons CSS -->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>منظم الميزانية</title>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<style>
    *{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins',sans-serif;
  scroll-behavior: smooth;
}
    header {
  position: fixed;
  width: 100%;
  top: 0;
  left: 0;
  z-index: 10;
  padding: 0 10px;
}
.navbar {
  display: flex;
  padding: 22px 0;
  align-items: center;
  max-width: 1200px;
  margin: 0 auto;
  justify-content: space-between;
}
.navbar .hamburger-btn {
  display: none;
  color: #fff;
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
  color: black;
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
  color: black;
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
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
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
         
    background-image: url("bg.jpg");
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
            margin: 200px auto;
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

        label {
        display: block;
        margin-bottom: 5px;
        direction: rtl;
        text-align: right;
    }
    input[type="number"] {
        width: 100%;
        padding: 5px;
        box-sizing: border-box;
        direction: rtl;
        text-align: right;
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
    <div class="container">
        <h1>منظم ميزانية حفلات الزفاف</h1>
        <form action="fetch_services.php" method="post">
            <label for="budget">الميزانية الكلية التقديرية:</label>
            <input type="number" min="5000" value="5000" id="budget" name="budget" placeholder="ادخل الميزانية الكلية" required><br>

            <label for="theme">اختر نوع حفل الزفاف:</label>
            <br>
            <label><input type="radio" name="theme" value="hotel"> فندق</label><br>
            <label><input type="radio" name="theme" value="venue"> قاعة</label><br>
            <label><input type="radio" name="theme" value="Chalet"> استراحه</label><br>


            <label>اختر خدمات حفل الزفاف:</label>
            <br>
            <label><input type="checkbox" name="services" value="venue"> قاعة</label><br>
            <label><input type="checkbox" name="services" value="catering"> تقديم الطعام</label><br>
            <label><input type="checkbox" name="services" value="musician"> موسيقى</label><br>
            <label><input type="checkbox" name="services" value="decor"> ديكور</label><br>
            <label><input type="checkbox" name="services" value="photography"> التصوير الفوتوغرافي</label><br>
            <input type="hidden" id="venue_budget" name="venue_budget">
            <input type="hidden" id="catering_budget" name="catering_budget">
            <input type="hidden" id="musician_budget" name="musician_budget">        
            <button id="button" type="button">الحصول على النسب المئوية</button>
            <br><br>
            <div id="Response"></div>
        <div id="chart_div" style="width: 100%; height: 300px;"></div>
        <div id="budgets"></div>
            <button id="submit" type="submit">الحصول على الخدمات</button>
        </form>
        
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.7/axios.min.js"></script>
    <script> 
    document.getElementById("button").addEventListener("click", function() {
        let prompt = "As a wedding planner, distribute the percentages of the budget based on these services:";
        sendToChatGPT(prompt);
    });

    function sendToChatGPT(prompt){
        let selectedServices = [];
        document.querySelectorAll('input[name="services"]:checked').forEach(function(checkbox) {
            selectedServices.push(checkbox.value);
        });
        let value = selectedServices.join(', ');
        let body ={
            "model":"gpt-3.5-turbo",
            "messages":[{"role": "system", "content": prompt}, {"role": "user", "content": value}],
        };
        let headers ={Authorization:"Bearer key",};
        axios.post("https://api.openai.com/v1/chat/completions", body, {headers:headers})
        .then((Response)=>{
            let reply = Response.data.choices[0].message.content;
            document.getElementById("Response").innerHTML=reply;
            splitResponse(reply, selectedServices);
        });
    }
    
    function splitResponse(response, selectedServices) {
    let matches = response.match(/([a-zA-Z]+): (\d+(?:\.\d+)?)%/g);

    if (matches) {
        let budget = parseFloat(document.getElementById("budget").value);
        let data = [['Service', 'Percentage', 'Budget']];
        matches.forEach(match => {
            let parts = match.split(': ');
            let serviceName = parts[0].trim();
            let percentage = parseFloat(parts[1]);
            let serviceBudget = (budget * percentage) / 100;
            if (selectedServices.includes(serviceName.toLowerCase())) {
                data.push([serviceName, percentage, serviceBudget]);
            }
        });

        // Load Google Charts API
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(function() {
            drawChart(data);
            displayBudgets(data);
        });

        // Now, we'll set the hidden input fields with the calculated budgets
        document.getElementById("venue_budget").value = getServiceBudget(data, "venue");
        document.getElementById("catering_budget").value = getServiceBudget(data, "catering");
        document.getElementById("musician_budget").value = getServiceBudget(data, "musician");
    }
}

function getServiceBudget(data, serviceType) {
    for (let i = 1; i < data.length; i++) {
        if (data[i][0].toLowerCase() === serviceType.toLowerCase()) {
            return data[i][2];
        }
    }
    return 0;
}

function drawChart(data) {
    var chartData = google.visualization.arrayToDataTable(data);

    var options = {
        title: 'Percentage of Each Service and Corresponding Budget',
        is3D: false,
colors: ['#c79ede', '#a4de9e', '#f7adc6', '#b0d4eb', '#1eeb24']
    };

    var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
    chart.draw(chartData, options);
}

function displayBudgets(data) {
    let budgetsHtml = "<h2>Budgets for Selected Services:</h2>";
    for (let i = 1; i < data.length; i++) {
        budgetsHtml += "<p>" + data[i][0] + ": $" + data[i][2].toFixed(2) + "</p>";
    }
    document.getElementById("budgets").innerHTML = budgetsHtml;
}
    </script>
</body>
</html>