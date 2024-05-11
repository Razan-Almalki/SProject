<?php
session_start();
include 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Wedding Planner</title>
<style>
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

</style>
</head>
<body>
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
<h1 style="color:#896ba6;">This is where you'll discover packages customized to your budget</h1>

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

</body>
</html>