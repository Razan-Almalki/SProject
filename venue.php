<?php 
session_start(); 
include 'connection.php';
$user_id = $_SESSION['user_id'];

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
    <title>🏰 القاعات</title>
    <link rel="stylesheet" href="Rstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
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
    <section class="showItem-panels"  id="venueSection">
    </section>
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

        fetch('http://localhost/get_venue_data.php')
            .then(response => response.json())
            .then(data => {
                const venueSection = document.getElementById('venueSection');

                data.forEach(venue => {
                    // Check if the service type is 'Venue'
                    if (venue.type === 'Venue') {
                        const article = document.createElement('article');
                        article.classList.add('venue');

                        // Create an image element
                        const img = document.createElement('img');
                        img.src = venue.pic ? 'data:image/' + venue.pic_type + ';base64,' + venue.pic : 'placeholder.jpeg'; // Placeholder image if pic is undefined
                        img.alt = venue.name;

                        const h2 = document.createElement('h2');
                        h2.textContent = venue.name;

                        const p2 = document.createElement('p');
                        p2.textContent = 'السعر: ' + venue.price + ' ريال';

                        const p3 = document.createElement('p');
                        p3.textContent = 'العربون: ' + venue.deposit + ' ريال';

                        // Append image, heading, and paragraphs to the article
                        article.appendChild(img);
                        article.appendChild(h2);
                        article.appendChild(p2);
                        article.appendChild(p3);

                        // Fetch and append rate and number of rates
                        fetchReview(venue.id, venue, article);

                        // Append article to the venue section
                        venueSection.appendChild(article);
                    }
                });
            })
            .catch(error => console.error('Error fetching venue data:', error));

        function fetchReview(venueId, venueDetails, article) {
            fetch(`http://localhost/get_review.php?id=${venueId}`)
                .then(response => response.json())
                .then(reviewData => {
                    // Check if any reviews are returned
                    if (reviewData.length > 0) {
                        let totalRates = 0;
                        let validRatingsCount = 0; // Track the count of valid ratings within the range
                        reviewData.forEach(review => {
                            // Ensure each rating is within the range of 1 to 5
                            const rating = Math.min(Math.max(parseInt(review.Rate), 1), 5);
                            totalRates += rating;
                            validRatingsCount++; // Increment the count of valid ratings
                        });
                        const averageRate = totalRates / validRatingsCount; // Calculate average based on valid ratings

                        // Create a container for the star icons
                        const starsContainer = document.createElement('div');
                        starsContainer.style.direction = 'ltr'; // Set the direction of the container
                        starsContainer.classList.add('stars');

                        // Calculate the number of filled stars
                        const filledStars = Math.round(averageRate);

                        // Create star icons
                        for (let i = 0; i < 5; i++) {
                            const starIcon = document.createElement('i');
                            starIcon.classList.add('fa-solid', 'fa-star');
                            starIcon.style.fontSize = '20px';

                            // Check if the current star should be filled
                            if (i < filledStars) {
                                starIcon.classList.add('active');
                            }

                            // Append star icon to the stars container
                            starsContainer.appendChild(starIcon);
                        }

                        // Append the stars container to the article
                        article.appendChild(starsContainer);


                        const container = document.createElement('div');
                        container.style.display = 'flex'; // Use flexbox for layout
                        container.style.alignItems = 'center'; // Center items vertically
                        container.style.direction = 'ltr'; // Set the direction of the container

                        // Create the rating image
                        const ratingImage = createRatingImage(validRatingsCount);
                        if (ratingImage) {
                            ratingImage.style.direction = 'ltr'; // Set the direction of the container

                            // Append the rating image to the container
                            container.appendChild(ratingImage);
                        } else {
                            console.error('Error: Rating image creation failed.');
                        }

                        const ratesText = document.createTextNode(` (${validRatingsCount})`);
                        // Append the ratesText to the container
                        container.appendChild(ratesText);

                        // Append the container to the article
                        article.appendChild(container);


                        // Append the line break after the rates text
                        article.appendChild(document.createElement('br'));

                        // Create and append read more button after stars and rates
                        const readMoreButton = createReadMoreButton(venueId);
                        article.appendChild(readMoreButton);
                    } else {
                        const p4 = document.createElement('p');
                        p4.textContent = 'لا توجد تقييمات';
                        p4.style.direction = 'ltr';

                        // Append average rate paragraph to the article
                        article.appendChild(p4);

                        const container = document.createElement('div'); // Create a container for the text and image
                        container.style.direction = 'ltr'; // Set the direction of the container

                        // Create and append rating image
                        const ratingImage = createRatingImage(0); // Pass 0 as there are no ratings
                        container.appendChild(ratingImage);

                        const p5 = document.createElement('p');
                        p5.textContent = ' (0) ';
                        p5.style.display = 'inline'; // Display the paragraph as inline

                        // Append number of rates paragraph to the container
                        container.appendChild(p5);

                        // Append the container to the article
                        article.appendChild(container);

                        // Create and append read more button when there are no reviews
                        const readMoreButton = createReadMoreButton(venueId);
                        article.appendChild(readMoreButton);
                    }
                })
                .catch(error => console.error('Error fetching review data:', error));
        }

        // Function to create the read more button
        function createReadMoreButton(venueId) {

            const readMoreButton = document.createElement('button');
            readMoreButton.textContent = 'إقرأ المزيد';
            readMoreButton.addEventListener('click', () => {
                window.location.href = `http://localhost/venue_details.php?id=${venueId}`;
            });
            return readMoreButton;
        }

        // Function to create the rating image
        function createRatingImage(validRatingsCount) {
            const img = document.createElement('img');
            img.src = 'images/Number_of_rate.png';
            img.alt = 'Number of Ratings';
            img.style.width = '10px'; // Set the width of the image
            img.style.height = 'auto'; // Maintain aspect ratio by setting height to auto
            img.style.verticalAlign = 'middle'; // Align the image vertically with text

            return img;
        }


    </script>

</body>

</html>