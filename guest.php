<!DOCTYPE html>
<html lang="ar">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>guest</title>
  <link rel="stylesheet" href="Guest_style.css" />
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,1,0" />
</head>

<?php
session_start();
// Check if user is authenticated
$loggedIn = isset($_SESSION['user_id']);

?>

<?php
include "connection.php";

// Fetch the total number of guests
$queryTotalGuests = "SELECT COUNT(*) AS totalGuests FROM guest WHERE user_id=" . $_SESSION['user_id'];
$resultTotalGuests = mysqli_query($conn, $queryTotalGuests);
$rowTotalGuests = mysqli_fetch_assoc($resultTotalGuests);
$totalGuests = $rowTotalGuests['totalGuests'];

// Fetch the number of guests with 'حضور' attendance state
$queryAttendees = "SELECT COUNT(*) AS attendees FROM guest WHERE Attendance = 'حضور' AND user_id=" . $_SESSION['user_id'];
$resultAttendees = mysqli_query($conn, $queryAttendees);
$rowAttendees = mysqli_fetch_assoc($resultAttendees);
$attendees = $rowAttendees['attendees'];

// Fetch the number of guests with 'معتذر' attendance state
$queryDeclines = "SELECT COUNT(*) AS declines FROM guest WHERE Attendance = 'معتذر' AND user_id=" . $_SESSION['user_id'];
$resultDeclines = mysqli_query($conn, $queryDeclines);
$rowDeclines = mysqli_fetch_assoc($resultDeclines);
$declines = $rowDeclines['declines'];

// Fetch the number of guests with 'معتذر' attendance state
$queryPending = "SELECT COUNT(*) AS Pending FROM guest WHERE Attendance = 'معلق' AND user_id=" . $_SESSION['user_id'];
$resultPending = mysqli_query($conn, $queryPending);
$rowPending = mysqli_fetch_assoc($resultPending);
$pending = $rowPending['Pending'];
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
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
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
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
              حسابي
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="userProfile.php">الاعدادات</a>
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
  <!-- Begin Content -->
  <div id="Content">

    <!-- Begin overview -->
    <div id="overview">
      <h2>نظرة عامة</h2>
      <hr>
      <div id="guest-state">
        <img src="guest.jpg" width="75px" height="75px" alt="guest-icon">
        <div id="guest-counter" onclick="showAllGuests()">عدد الضيوف <br /> <?php echo $totalGuests; ?> </div>
        <div id="counter-detial">
          <div id="guest-attendee" onclick="showAttendees()">عدد الحاضرين <?php echo $attendees; ?> </div>
          <div id="guest-decline" onclick="showDeclines()">عدد المعتذرين <?php echo $declines; ?> </div>
          <div id="guest-pending" onclick="showPending()">عدد المعلقين <?php echo $pending; ?></div>
        </div>
      </div>
    </div>
    <!-- End overview -->

    <!-- Begin guests-list -->
    <div id="guest-list">
      <div id="guest-action">
        <div id="buttons">
          <button id="add-guest-button" type="button" onclick="openPopup()">
            <span class="material-symbols-outlined">add_circle</span>
            <span class="material-symbols-outlined">ضيف</span>
          </button>
          <button id="add-group-button" type="button" onclick="openGroupPopup()">
            <span class="material-symbols-outlined">add_circle</span>
            <span class="material-symbols-outlined">مجموعة</span>
          </button>
        </div>
        <div id="search-bar">
          <input id="search-input" type="search" placeholder="ابحث" oninput="searchGuests()">
          <span class="search-icon material-symbols-outlined">search</span>
        </div>
      </div>
      <div id="guest-table">
        <div id="guest-secondary-action">
          <div id="main-checkbox">
            <label>
              <input type="checkbox" id="select-all-checkbox" onchange="toggleSelectAll()">اختر الكل
            </label>
          </div>
          <div id="additional-buttons">
            <button id="switch-group-button" type="button" onclick="openMoveGroupPopup()"> <span
                class="material-symbols-outlined">
                sync_alt
              </span> تبديل مجموعة</button>
            <button id="remove-button" type="button" onclick="openRemoveGuestPopup()"> <span
                class="material-symbols-outlined">
                delete
              </span> حذف</button>
          </div>
        </div>
        <div id="result">
          <?php
          // Fetch Table_names from guest_tables
          $sql_fetch_tables = "SELECT * FROM guest_tables WHERE user_id=" . $_SESSION['user_id'];
          $result_tables = $conn->query($sql_fetch_tables);

          // Fetch guests corresponding to each Table_name
          if ($result_tables->num_rows > 0) {
            while ($row = $result_tables->fetch_assoc()) {
              $table_name = $row['Table_name'];
              echo "<div id='guest-row'>";
              echo "<table id='table'>";
              echo "<thead>";
              echo "<tr>";
              echo "<th style='width: 5%'></th>"; // Adjust the width as needed
              echo "<th style='width: 35%'>$table_name</th>"; // Adjust the width as needed
              echo "<th style='width: 30%'>حالة الحضور</th>"; // Adjust the width as needed
              // Check if the group name requires a dropdown menu
              if ($table_name != 'اقارب العروس' && $table_name != 'اقارب العريس') {
                echo "<th style='width: 30%; position: relative;' class='dropdown'>";
                echo "<button class='dropbtn'><span>...</span></button>";
                echo "<div class='dropdown-content'>";
                echo "<a href=''>Rename</a>";
                echo "<a href=''>Delete</a>";
                echo "</div>";
                echo "</th>";
              } else {
                echo "<th style='width: 30%'></th>";
              }
              echo "</tr>";
              echo "</thead>";
              echo "<tbody>";

              // Fetch guests for this Table_name
              $sql_fetch_guests = "SELECT * FROM guest WHERE user_id=" . $_SESSION['user_id'] . " AND Relationship='$table_name'";
              $result_guests = $conn->query($sql_fetch_guests);

              if ($result_guests->num_rows > 0) {
                while ($guest = $result_guests->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td><input type='checkbox' class='guest-checkbox' data-guest-id='1' onchange='apeareanddis()'></td>";
                  echo "<td>{$guest['F_Name']} {$guest['M_Name']} {$guest['L_Name']}</td>"; // Display guest's name
                  echo "<td>{$guest['Attendance']}</td>"; // Display guest's attendance
                  echo "<td><button class='guest-edit-button' onclick='openSideDiv({$guest['ID']})'><span class='guest-edit material-symbols-outlined'>more_horiz</span></button></td>";
                  echo "</tr>";
                }
              }

              echo "</tbody>";
              echo "</table>";
              echo "</div>";
            }
          } else {
            echo "No tables found";
          }
          ?>
        </div>
      </div>
    </div>
    <!-- End guests-list -->
    </main>
    <!-- End main -->

    <!-- Begin Footer -->
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
    <!-- End Footer -->
  </div>
  <!-- End Content -->

  <div id="popup" class="popup" style="display: none;">
    <form action="add_guest.php" method="post">
      <div class="popup__header">
        <h2 class="popup__title">اضافة ضيف</h2>
        <button class="popup__close" onclick="closePopup()">&#10006;</button>
      </div>
      <div class="form__group field">
        <input type="input" class="form__field" placeholder="الاسم الاول" name="f_Name" id="first_name" required />
        <label for="first_name" class="form__label">الاسم الاول</label>
      </div>

      <div class="form__group field">
        <input type="input" class="form__field" placeholder="الاسم الثاني" name="m_Name" id="middle_name" required />
        <label for="middle_name" class="form__label">الاسم الثاني</label>
      </div>

      <div class="form__group field">
        <input type="input" class="form__field" placeholder="الاسم الاخير" name="l_Name" id="last_name" required />
        <label for="last_name" class="form__label">الاسم الاخير</label>
      </div>

      <div class="form__group field">
        <input type="input" class="form__field" placeholder="الجوال" name="phone" id="phone" required />
        <label for="phone" class="form__label">الجوال</label>
      </div>

      <div class="form__group field">
        <label for="img_category" class="form__label">المجموعة</label>
        <select id="img_category" name="img_category" class="form__field" required>
          <option selected disabled value style="display: none"></option>
          <?php
          $sql_fetch_relationships = "SELECT Table_name FROM guest_tables WHERE user_id=" . $_SESSION['user_id'];
          $result_relationships = $conn->query($sql_fetch_relationships);

          $relationship_options = array();
          if ($result_relationships->num_rows > 0) {
            while ($row = $result_relationships->fetch_assoc()) {
              $relationship_options[] = $row['Table_name'];
            }
          }
          foreach ($relationship_options as $option) {
            echo "<option value='$option'>$option</option>";
          }
          ?>
        </select>
      </div>

      <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">

      <br>
      <button type="submit">إضافة</button>
    </form>
  </div>

  <div id="group-popup" class="popup" style="display: none;">
    <form id="add-group-form" action="add_group.php" method="post">
      <div class="popup__header">
        <h2 class="popup__title">اضافة مجموعة</h2>
        <button class="popup__close" onclick="closeGroupPopup()">&#10006;</button>
      </div>

      <div class="form__group field">
        <input type="input" id="group-name" class="form__field" placeholder="اسم المجموعة" name="group_name" required />
        <label for="group-name" class="form__label">اسم المجموعة</label>
      </div>

      <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">

      <br>
      <button id="add-group-btn" type="submit">إضافة</button>
    </form>
  </div>

  <div id="move-group-popup" class="popup" style="display: none;">
    <form id="move-group-form" action="switch_group.php" method="post">
      <div class="popup__header">
        <h2 class="popup__title">نقل الضيوف إلى مجموعة اخرى</h2>
        <button class="popup__close" onclick="closeMoveGroupPopup()">&#10006;</button>
      </div>

      <div class="form__group field">
        <?php
        // Fetch group names from guest_tables
        $sql_fetch_groups = "SELECT DISTINCT Table_name FROM guest_tables WHERE user_id=" . $_SESSION['user_id'];
        $result_groups = $conn->query($sql_fetch_groups);

        if ($result_groups->num_rows > 0) {
          while ($row = $result_groups->fetch_assoc()) {
            $group_name = $row['Table_name'];
            echo "<input type='radio' id='$group_name' name='new_group' value='$group_name'>";
            echo "<label for='$group_name'>$group_name</label><br>";
          }
        } else {
          echo "No groups found";
        }
        ?>
      </div>

      <input type="hidden" id="group_name" name="group_name" value="">

      <input type="hidden" id="guests_names" name="guests_names" value="">

      <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">

      <br>
      <button id="move-group-btn" type="submit" onclick="guestName()">تحريك الضيوف</button>
    </form>
  </div>

  <div id="remove-guest-popup" class="popup" style="display: none;">
    <form id="remove-guest-form" action="Delete_guest.php" method="post">
      <div class="popup__header">
        <h2 class="popup__title">حذف الضيف</h2>
        <button class="popup__close" onclick="closeRemoveGuestPopup()">&#10006;</button>
      </div>
      <div class="form__group field">
        <input type="hidden" id="delete_guests_names" name="delete_guests_names" value="">
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
      </div>
      <div class="popup__body">
        <p>هل أنت متأكد أنك تريد حذف هذا الضيف؟</p>
        <button type="submit" onclick="deleteGuest()">نعم، حذف</button>
        <button type="button" onclick="closeRemoveGuestPopup()">لا، إلغاء</button>
      </div>
    </form>
  </div>

  <script>
    function openRemoveGuestPopup() {
      document.getElementById("remove-guest-popup").style.display = "block";
      document.getElementById("overlay").style.display = "block";
    }

    function closeRemoveGuestPopup() {
      document.getElementById("remove-guest-popup").style.display = "none";
      document.getElementById("overlay").style.display = "none";
    }

    function deleteGuest() {
      // Get all checked checkboxes
      var checkedGuests = document.querySelectorAll('.guest-checkbox:checked');
      var guestsNames = [];

      // Extract names of checked guests
      checkedGuests.forEach(function (guest) {
        guestsNames.push(guest.parentNode.nextElementSibling.textContent.trim());
      });

      document.getElementById('delete_guests_names').value = guestsNames.join(', '); // Or use any other delimiter you prefer
    }
  </script>


  <!-- Hidden input to store checked guest IDs -->
  <?php
  if (!empty($_POST['guest_ids'])) {
    foreach ($_POST['guest_ids'] as $guest_id) {
      echo "<input type='hidden' name='guest_ids[]' value='$guest_id'>";
    }
  }
  ?>

  <script>
    function openMoveGroupPopup() {
      document.getElementById("move-group-popup").style.display = "block";
      document.getElementById("overlay").style.display = "block";
    }

    function closeMoveGroupPopup() {
      document.getElementById("move-group-popup").style.display = "none";
      document.getElementById("overlay").style.display = "none";
    }
  </script>

  <script>
    function openRemoveGuestPopup() {
      document.getElementById("remove-guest-popup").style.display = "block";
      document.getElementById("overlay").style.display = "block";
    }

    function closeRemoveGuestPopup() {
      document.getElementById("remove-guest-popup").style.display = "none";
      document.getElementById("overlay").style.display = "none";
    }
  </script>

  <script>
    // Check if alert message is set in the session and display it
    <?php if (isset($_SESSION['alert'])): ?>
      alert('<?php echo $_SESSION['alert']; ?>');
      <?php // Unset the alert message
        unset($_SESSION['alert']); ?>
    <?php endif; ?>
  </script>

  <div id="sideDiv" class="side-div">
    <h2>Guest Information</h2>

    <button class="close-button" onclick="closeSideDiv()">
      <span class="material-symbols-outlined">close</span>
    </button>

    <form id="updateForm" action="Update_guest_info.php" method="post">
      <div class="form__group field">
        <input type="input" class="form__field" placeholder="الاسم الاول" name="update_first_name"
          id="update_first_name" required />
        <label for="update_first_name" class="form__label">الاسم الاول</label>
      </div>

      <div class="form__group field">
        <input type="input" class="form__field" placeholder="الاسم الثاني" name="update_middle_name"
          id="update_middle_name" required />
        <label for="update_middle_name" class="form__label">الاسم الثاني</label>
      </div>

      <div class="form__group field">
        <input type="input" class="form__field" placeholder="الاسم الاخير" name="update_last_name" id="update_last_name"
          required />
        <label for="update_last_name" class="form__label">الاسم الاخير</label>
      </div>

      <div class="form__group field">
        <input type="input" class="form__field" placeholder="الجوال" name="update_phone" id="update_phone" required />
        <label for="update_phone" class="form__label">الجوال</label>
      </div>

      <div class="form__group field">
        <label for="update_group" class="form__label">المجموعة</label>
        <select id="update_group" name="update_group" class="form__field" required>
          <option selected disabled value style="display: none"></option>
          <?php
          $sql_fetch_relationships = "SELECT Table_name FROM guest_tables WHERE user_id=" . $_SESSION['user_id'];
          $result_relationships = $conn->query($sql_fetch_relationships);

          $relationship_options = array();
          if ($result_relationships->num_rows > 0) {
            while ($row = $result_relationships->fetch_assoc()) {
              $relationship_options[] = $row['Table_name'];
            }
          }
          foreach ($relationship_options as $option) {
            echo "<option value='$option'>$option</option>";
          }
          ?>
        </select>
      </div>

      <input type="hidden" name="update_guest_id" id="update_guest_id" value="">

      <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">

      <br>
      <button type="submit">Update</button>
    </form>
  </div>

  <script>
    function openSideDiv(ID) {
      document.getElementById("sideDiv").style.width = "35%";
      document.getElementById("overlay").style.display = "block";
      document.getElementById("update_guest_id").value = ID;
    }

    function closeSideDiv() {
      document.getElementById("sideDiv").style.width = "0";
      document.getElementById("overlay").style.display = "none";
    }
  </script>

  <div id="overlay"></div>

  <script>
    function showAllGuests() {
      var table = document.getElementById("guest-table");
      var rows = table.getElementsByTagName("tr");
      for (var i = 0; i < rows.length; i++) {
        rows[i].style.display = "";
      }
    }

    function showAttendees() {
      showGuestsByAttendance('حضور');
    }

    function showDeclines() {
      showGuestsByAttendance('معتذر');
    }

    function showPending() {
      showGuestsByAttendance('معلق');
    }

    function showGuestsByAttendance(attendanceState) {
      var table = document.getElementById("guest-table");
      var rows = table.getElementsByTagName("tr");
      for (var i = 0; i < rows.length; i++) {
        var cells = rows[i].getElementsByTagName("td");
        if (cells.length > 0) {
          var attendance = cells[2].innerText.trim(); // Assuming attendance state is in the third column
          if (attendance === attendanceState) {
            rows[i].style.display = "";
          } else {
            rows[i].style.display = "none";
          }
        }
      }
    }
  </script>

  <script>
    function openGroupPopup() {
      document.getElementById("group-popup").style.display = "block";
      document.getElementById("overlay").style.display = "block";
    }

    function closeGroupPopup() {
      document.getElementById("group-popup").style.display = "none";
      document.getElementById("overlay").style.display = "none";
    }
  </script>

  <script>
    function openPopup() {
      var popup = document.getElementById("popup");
      popup.style.display = "block";
      document.getElementById("overlay").style.display = "block";
    }

    function closePopup() {
      var popup = document.getElementById("popup");
      popup.style.display = "none";
      document.getElementById("overlay").style.display = "none";

      var select = document.getElementById('img_category');
      select.selectedIndex = 0;
    }
  </script>

  <script>
    function searchGuests() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("search-input");
      filter = input.value.toUpperCase();
      table = document.getElementById("guest-table");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1]; // Index 1 is where guest names are located
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
  </script>

  <script>
    function toggleSelectAll() {
      var checkboxes = document.getElementsByClassName('guest-checkbox');
      var selectAllCheckbox = document.getElementById('select-all-checkbox');
      var additionalButtons = document.getElementById('additional-buttons');

      if (selectAllCheckbox.checked) {
        for (var i = 0; i < checkboxes.length; i++) {
          checkboxes[i].checked = true;
        }
        additionalButtons.style.display = 'block';
      } else {
        for (var i = 0; i < checkboxes.length; i++) {
          checkboxes[i].checked = false;
        }
        additionalButtons.style.display = 'none';
      }
    }
  </script>

  <script>
    function apeareanddis() {
      var checkboxes = document.getElementsByClassName('guest-checkbox');
      var additionalButtons = document.getElementById('additional-buttons');
      var checkedCount = 0; // Keep track of the number of checked checkboxes

      for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
          checkedCount++;
        }
      }

      if (checkedCount > 0) {
        additionalButtons.style.display = 'block';
      } else {
        additionalButtons.style.display = 'none';
      }
    }
  </script>

  <script>
    function guestName() {
      // Get all checked checkboxes
      var checkedGuests = document.querySelectorAll('.guest-checkbox:checked');
      var guestsNames = [];

      // Get the value of selected group
      var selectedGroup = document.querySelector('input[name="new_group"]:checked').value;

      // Extract names of checked guests
      checkedGuests.forEach(function (guest) {
        guestsNames.push(guest.parentNode.nextElementSibling.textContent.trim());
      });

      // Set the values of hidden inputs
      document.getElementById('group_name').value = selectedGroup;
      document.getElementById('guests_names').value = guestsNames.join(', '); // Or use any other delimiter you prefer
    }
  </script>

  <script>
    var util = {
      f: {
        addStyle: function (elem, prop, val, vendors) {
          var i, ii, property, value
          if (!util.f.isElem(elem)) {
            elem = document.getElementById(elem)
          }
          if (!util.f.isArray(prop)) {
            prop = [prop]
            val = [val]
          }
          for (i = 0; i < prop.length; i += 1) {
            var thisProp = String(prop[i]),
              thisVal = String(val[i])
            if (typeof vendors !== "undefined") {
              if (!util.f.isArray(vendors)) {
                vendors.toLowerCase() == "all" ? vendors = ["webkit", "moz", "ms", "o"] : vendors = [vendors]
              }
              for (ii = 0; ii < vendors.length; ii += 1) {
                elem.style[vendors[i] + thisProp] = thisVal
              }
            }
            thisProp = thisProp.charAt(0).toLowerCase() + thisProp.slice(1)
            elem.style[thisProp] = thisVal
          }
        },
        cssLoaded: function (event) {
          var child = util.f.getTrg(event)
          child.setAttribute("media", "all")
        },
        events: {
          cancel: function (event) {
            util.f.events.prevent(event)
            util.f.events.stop(event)
          },
          prevent: function (event) {
            event = event || window.event
            event.preventDefault()
          },
          stop: function (event) {
            event = event || window.event
            event.stopPropagation()
          }
        },
        getSize: function (elem, prop) {
          return parseInt(elem.getBoundingClientRect()[prop], 10)
        },
        getTrg: function (event) {
          event = event || window.event
          if (event.srcElement) {
            return event.srcElement
          } else {
            return event.target
          }
        },
        isElem: function (elem) {
          return (util.f.isNode(elem) && elem.nodeType == 1)
        },
        isArray: function (v) {
          return (v.constructor === Array)
        },
        isNode: function (elem) {
          return (typeof Node === "object" ? elem instanceof Node : elem && typeof elem === "object" && typeof elem.nodeType === "number" && typeof elem.nodeName === "string" && elem.nodeType !== 3)
        },
        isObj: function (v) {
          return (typeof v == "object")
        },
        replaceAt: function (str, index, char) {
          return str.substr(0, index) + char + str.substr(index + char.length);
        }
      }
    },
      //////////////////////////////////////
      // ok that's all the utilities      //
      // onto the select box / form stuff //
      //////////////////////////////////////
      form = {
        f: {
          init: {
            register: function () {
              console.clear()// just cuz codepen
              var child, children = document.getElementsByClassName("field"), i
              for (i = 0; i < children.length; i += 1) {
                child = children[i]
                util.f.addStyle(child, "Opacity", 1)
              }
              children = document.getElementsByClassName("psuedo_select")
              for (i = 0; i < children.length; i += 1) {
                child = children[i]
                child.addEventListener("click", form.f.select.toggle)
              }
            },
            unregister: function () {
              //just here as a formallity
              //call this to stop all ongoing timeouts are ready the page for some sort of json re-route
            }
          },
          select: {
            blur: function (field) {
              field.classList.remove("focused")
              var child, children = field.childNodes, i, ii, nested_child, nested_children
              for (i = 0; i < children.length; i += 1) {
                child = children[i]
                if (util.f.isElem(child)) {
                  if (child.classList.contains("deselect")) {
                    child.parentNode.removeChild(child)
                  } else if (child.tagName == "SPAN") {
                    if (!field.dataset.value) {
                      util.f.addStyle(child, ["FontSize", "Top"], ["16px", "32px"])
                    }
                  } else if (child.classList.contains("psuedo_select")) {
                    nested_children = child.childNodes
                    for (ii = 0; ii < nested_children.length; ii += 1) {
                      nested_child = nested_children[ii]
                      if (util.f.isElem(nested_child)) {
                        if (nested_child.tagName == "SPAN") {
                          if (!field.dataset.value) {
                            util.f.addStyle(nested_child, ["Opacity", "Transform"], [0, "translateY(24px)"])
                          }
                        } else if (nested_child.tagName == "UL") {
                          util.f.addStyle(nested_child, ["Height", "Opacity"], [0, 0])
                        }
                      }
                    }
                  }
                }
              }
            },
            focus: function (field) {
              field.classList.add("focused")
              var bool = false, child, children = field.childNodes, i, ii, iii, nested_child, nested_children, nested_nested_child, nested_nested_children, size = 0
              for (i = 0; i < children.length; i += 1) {
                child = children[i]
                util.f.isElem(child) && child.classList.contains("deselect") ? bool = true : null
              }
              if (!bool) {
                child = document.createElement("div")
                child.className = "deselect"
                child.addEventListener("click", form.f.select.toggle)
                field.insertBefore(child, children[0])
              }
              for (i = 0; i < children.length; i += 1) {
                child = children[i]
                if (util.f.isElem(child) && child.classList.contains("psuedo_select")) {
                  nested_children = child.childNodes
                  for (ii = 0; ii < nested_children.length; ii += 1) {
                    nested_child = nested_children[ii]
                    if (util.f.isElem(nested_child) && nested_child.tagName == "UL") {
                      size = 0
                      nested_nested_children = nested_child.childNodes
                      for (iii = 0; iii < nested_nested_children.length; iii += 1) {
                        nested_nested_child = nested_nested_children[iii]
                        if (util.f.isElem(nested_nested_child) && nested_nested_child.tagName == "LI") {
                          size += util.f.getSize(nested_nested_child, "height")
                          console.log("size: " + size)
                        }
                      }
                      util.f.addStyle(nested_child, ["Height", "Opacity"], [size + "px", 1])
                    }
                  }
                }
              }
            },
            selection: function (child, parent) {
              var children = parent.childNodes, i, ii, nested_child, nested_children, time = 0, value
              if (util.f.isElem(child) && util.f.isElem(parent)) {
                parent.dataset.value = child.dataset.value
                value = child.innerHTML
              }
              for (i = 0; i < children.length; i += 1) {
                child = children[i]
                if (util.f.isElem(child)) {
                  if (child.classList.contains("psuedo_select")) {
                    nested_children = child.childNodes
                    for (ii = 0; ii < nested_children.length; ii += 1) {
                      nested_child = nested_children[ii]
                      if (util.f.isElem(nested_child) && nested_child.classList.contains("selected")) {
                        if (nested_child.innerHTML) {
                          time = 1E2
                          util.f.addStyle(nested_child, ["Opacity", "Transform"], [0, "translateY(24px)"], "all")
                        }
                        setTimeout(function (c, v) {
                          c.innerHTML = v
                          util.f.addStyle(c, ["Opacity", "Transform", "TransitionDuration"], [1, "translateY(0px)", ".1s"], "all")
                        }, time, nested_child, value)
                      }
                    }
                  } else if (child.tagName == "SPAN") {
                    util.f.addStyle(child, ["FontSize", "Top"], ["12px", "8px"])
                  }
                }
              }
            },
            toggle: function (event) {
              util.f.events.stop(event)
              var child = util.f.getTrg(event), children, i, parent
              switch (true) {
                case (child.classList.contains("psuedo_select")):
                case (child.classList.contains("deselect")):
                  parent = child.parentNode
                  break
                case (child.classList.contains("options")):
                  parent = child.parentNode.parentNode
                  break
                case (child.classList.contains("option")):
                  parent = child.parentNode.parentNode.parentNode
                  form.f.select.selection(child, parent)
                  break
              }
              parent.classList.contains("focused") ? form.f.select.blur(parent) : form.f.select.focus(parent)
            }
          }
        }
      }
    window.onload = form.f.init.register
  </script>

  <script>

  </script>
</body>

</html>