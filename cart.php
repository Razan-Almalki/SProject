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
  <title>السلة</title>
  <style>
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
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-image: url("bg.jpg");
      background-size: cover;
      min-height: 100vh;
    }

    .container {
      max-width: 800px;
      margin: 200px auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      direction: rtl;
    }

    h1 {
      text-align: center;
      margin-bottom: 20px;
    }

    .cart-item {
      border-bottom: 1px solid #ddd;
      padding: 10px 0;
      display: flex;
      align-items: center;
    }


    .cart-item img {
      max-width: 120px;
      max-height: 90px;
      margin-left: 20px;
      border-radius: 5px;
    }

    .cart-item p {
      margin: 0;
      text-align: right;
      margin-top: 4px;
      margin-bottom: 4px;
      display: block;
    }


    .cart-item button {
      background-color: #F3D0D7;
      color: black;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      position: absolute;
      left: 30%;
      transform: translateX(-50%);
    }

    .cart-item button:hover {
      background-color: #BC7FCD;
    }

    .cart-item .item-name {
      font-weight: bold;
    }

    .cart-total {
      margin-top: 20px;
      text-align: right;
    }

    .payment-button {
      background-color: #8cccfd;
      color: #FFFFFF;
      padding: 10px 30px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin-top: 20px;
      right: 41%;
      transform: translateX(-50%);
      position: relative;
    }

    .payment-button:hover {
      background-color: #514ff3;
    }

    .empty-cart-message {
      text-align: center;
      color: #6d6d6d;
      /* Change the text color to red */
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
      margin-top: 600px;
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
      width: 50px;
      /* Adjust the width to your desired size */
      height: auto;
      /* Maintain aspect ratio */
      vertical-align: middle;
      /* Align with the text vertically */
    }

    .footer__text {
      display: inline-block;
      /* Allow the text to be inline with the logo */
      vertical-align: middle;
      /* Align with the logo vertically */
      margin-left: 10px;
      /* Adjust the margin as needed */
      font-size: 20px;
      /* Adjust the font size to your desired size */
      font-weight: bold;
      /* Apply desired font weight */
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
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
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
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
              حسابي
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="userProfile.php">الاعدادات</a>
              <a class="dropdown-item" href="LogOut.php">تسجيل الخروج</a>
            </div>
          </li>
        <?php } else if ($loggedInV) { ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
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

  <section class="container" id="cart-items"></section>
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
    document.addEventListener("DOMContentLoaded", function () {
      fetchCartItems();
    });

    function fetchCartItems() {
      // Replace '1' with the actual user ID
      const userId = "<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>";

      // Fetch data from the PHP script
      fetch(`display_cart.php?userId=${userId}`)
        .then(response => response.json())
        .then(data => {
          const cartSection = document.getElementById('cart-items');
          // Process the fetched data
          if (data.length > 0) {
            let totalDeposit = 0; // Initialize total deposit

            data.forEach(item => {
              // Construct HTML for each item
              const cartItem = document.createElement('div');
              cartItem.classList.add('cart-item');

              const img = document.createElement('img');
              img.src = 'data:image/' + item.pic_type + ';base64,' + item.item_pic;
              img.alt = item.item_name; // Set alt attribute for accessibility

              const detailsContainer = document.createElement('div'); // Container for details
              detailsContainer.classList.add('details-container');

              const name = document.createElement('p');
              name.textContent = `الاسم: ${item.item_name}`;

              const date = document.createElement('p');
              date.textContent = `التاريخ: ${item.date}`;

              const price = document.createElement('p');
              price.textContent = `السعر: ${item.item_price} ريال`;

              const deposit = document.createElement('p');
              deposit.textContent = `العربون: ${item.deposit} ريال`;

              // Add deposit to total
              totalDeposit += parseFloat(item.deposit);

              // Append elements to details container
              detailsContainer.appendChild(name);
              detailsContainer.appendChild(date);
              detailsContainer.appendChild(price);
              detailsContainer.appendChild(deposit);

              // Append elements to cart item
              cartItem.appendChild(img);
              cartItem.appendChild(detailsContainer);

              // Create delete button
              const deleteButton = document.createElement('button');
              deleteButton.textContent = 'حذف من العربة';
              deleteButton.addEventListener('click', () => {
                deleteCartItem(item.id); // Call function to delete item when button is clicked
              });
              cartItem.appendChild(deleteButton);

              // Add a line break after each item
              cartItem.appendChild(document.createElement('br'));

              // Append cart item to HTML content
              cartSection.appendChild(cartItem);
            });


            // Display total deposit
            const totalDepositElement = document.createElement('div');
            totalDepositElement.classList.add('cart-total');
            totalDepositElement.textContent = `العربون الكُلي: ${totalDeposit.toFixed(2)} ريال`;
            totalDepositElement.style.textAlign = "left";
            cartSection.appendChild(totalDepositElement);

            // Create payment button
            const paymentButton = document.createElement('button');
            paymentButton.textContent = 'الدفع';
            paymentButton.classList.add('payment-button');
            paymentButton.addEventListener('click', () => {
              window.location.href = 'payment.php'; // Redirect to payment page when clicked >> to php!!!!!!!!!!!!!!!
            });
            cartSection.appendChild(paymentButton);

          } else {
            // Handle case where cart is empty
            const cartItems = document.getElementById('cart-items');
            cartItems.innerHTML = '<p class="empty-cart-message">العربة فارغة... 😔</p>';
          }

        })
        .catch(error => console.error('Error:', error));
    }

    function deleteCartItem(itemId) {
      // Send request to PHP script to delete cart item and related service information
      fetch(`delete_cart_item.php?itemId=${itemId}`)
        .then(response => {
          if (response.ok) {
            window.location.reload();
          } else {
            console.error('Error deleting cart item');
          }
        })
        .catch(error => console.error('Error:', error));
    }
  </script>
</body>

</html>