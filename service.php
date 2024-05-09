<?php 
session_start(); 
// Check if user is authenticated 
if (isset($_SESSION['User_ID'])) { 
  // User is logged in, display authenticated content 
  // ... 
} else { 
  // User is not logged in, redirect to the login page 
  header("Location: login.php"); 
  exit(); 
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الخدمات</title>
    <link rel="stylesheet" href="Rubastyles.css">
</head>
<body>
<a href="logout.php">logout</a>
    <header>
        <h1>خدماتنا</h1>
    </header>
    <nav>
        <ul>
            <li><a href="#">الرئيسية</a></li>
            <li><a href="service.html">الخدمات</a></li>
            <li><a href="#">معلومات عنا</a></li>
            <li><a href="#">التواصل</a></li>
        </ul>
    </nav>
    <body>
        <div class="introductionImge">
            <img src="images/weddingS2.jpg" alt="services intro">
            <span>
                <h1> !ترحيبًا بك في موقع الزفاف الخاص بنا</h1>
                <h1>نحن نقدم لك خدماتنا الثلاث الأساسية المتميزة لجعل يوم زفافك لحظة لا تُنسى</h1>
            </span>
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
            <p>© 2019 All Rights Reserved.</p>
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
