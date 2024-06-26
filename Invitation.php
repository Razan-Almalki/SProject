<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الدعوة</title>
    <link rel="stylesheet" href="inv.css">
</head>

<body>
    <div id="invitation">
        <div id="invitation-card">

        </div>
    </div>

    <div id="form-att">
        <p>فضلا ادخل رمز التحقق</p>
        <hr>
        <!-- Form to search for guests -->
        <input type="text" class="name" id="ID" placeholder="رمز التحقق">
        <div class="search-container">
            <button class="buttons" onclick="searchGuests()">ابحث</button>
        </div>
    </div>

    <div id="result">
        <!-- Display retrieved guests here -->
    </div>

    <div id="update-att">
        <!-- Update attendance form -->
    </div>

    <div id="success-message">
        <!-- Success message -->
    </div>

    <script>
        function searchGuests() {
            var guestID = document.getElementById('ID').value;

            // Check if at least one field is filled
            if (guestID.trim() === '') {
                alert('يرجى ادخال رمز التحقق.');
                return;
            }

            // Hide the form-att div
            document.getElementById('form-att').style.display = 'none';

            // Send AJAX request to search_guests.php
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("result").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "search_guests.php?ID=" + guestID, true);
            xhttp.send();
        }


        function selectGuest() {
            var selectedGuest = document.querySelector('input[name="guest"]:checked');

            if (!selectedGuest) {
                alert("فضلا اختر اسمك");
                return;
            }

            // Hide the result div
            document.getElementById('result').style.display = 'none';

            var guestId = selectedGuest.value;

            // Send AJAX request to get guest details
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("update-att").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "get_guest_details.php?guest_id=" + guestId, true);
            xhttp.send();

            // Send AJAX request to get guest details
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("invitation").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "get_invitation.php?guest_id=" + guestId, true);
            xhttp.send();
        }


        function updateAttendance() {
            var selectedAttendance = document.querySelector('input[name="attendance"]:checked');

            if (!selectedAttendance) {
                alert("فضلا اختر حدد احد الخيارات");
                return;
            }
            // Hide the update-att div
            document.getElementById('update-att').style.display = 'none';

            var guestId = document.getElementById('guest_id').value;
            var attendance = document.querySelector('input[name="attendance"]:checked').value;

            // Send AJAX request to update_attendance.php
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("success-message").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "update_attendance.php?guest_id=" + guestId + "&attendance=" + attendance, true);
            xhttp.send();
        }

        function newSearch() {
            document.getElementById("form-att").style.display = "block";
            document.getElementById("result").style.display = "block";
            document.getElementById("update-att").style.display = "block";
            document.getElementById("success-message").innerHTML = "";
        }
    </script>
</body>

</html>