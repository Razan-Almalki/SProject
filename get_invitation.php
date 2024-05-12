<?php
include 'connection.php';

$guestId = $_GET['guest_id'];

// Fetch guest details
$sql_guest = "SELECT * FROM guest WHERE ID='$guestId'";
$result_guest = $conn->query($sql_guest);

if ($result_guest->num_rows > 0) {
    $guest = $result_guest->fetch_assoc();

    // Fetch user details
    $userId = $guest['user_id'];
    $sql_user = "SELECT First_name, Last_name FROM user WHERE User_ID='$userId'";
    $result_user = $conn->query($sql_user);

    if ($result_user->num_rows > 0) {
        $user = $result_user->fetch_assoc();
        $userName = $user['First_name'] . " " . $user['Last_name'];
    } else {
        $userName = "Guest";
    }

    // Fetch reservation details
    $sql_reservation = "SELECT * FROM reservation WHERE User_ID='$userId'";
    // Modify the query to include the condition for Service_type being 'venue'
    $sql_reservation .= " AND Service_ID IN (SELECT Service_ID FROM services WHERE Service_type = 'Venue')";
    
    $result_reservation = $conn->query($sql_reservation);

    if ($result_reservation->num_rows > 0) {
        $reservation = $result_reservation->fetch_assoc();
        $serviceId = $reservation['Service_ID'];
        $reservationDate = $reservation['Reservation_date'];

        // Fetch service details
        $sql_service = "SELECT Service_name, Location FROM services WHERE Service_ID='$serviceId'";
        $result_service = $conn->query($sql_service);

        if ($result_service->num_rows > 0) {
            $service = $result_service->fetch_assoc();
            $serviceName = $service['Service_name'];
            $location = $service['Location'];

            // Construct the invitation HTML content
            $invitationContent = '
                <div id="invitation-content">
                <h1>دعوة</h1>
                <p>بكل الحب والترحيب نتشرف <br> بدعوتكم لحضور حفل زفاف</p>
                <div>
                    <p>' . $userName . '</p>
                </div>
                <div id="service-details">
                    <div>
                        <p>بتاريخ <br><br>' . $reservationDate . '</p>
                    </div>
                    <div>
                        <p>' . $serviceName . '</p>
                        <p>' . $location . '</p>
                    </div>
                </div>
                <p>وبحضوركم يتم الفرح والسرور</p>
                </div>
            ';

            // Send the invitation content back
            echo $invitationContent;
        } else {
            echo "Error fetching service details: " . $conn->error;
        }
    } else {
        echo "No reservations found for a venue service.";
    }
} else {
    echo "Guest not found";
}

$conn->close();
?>
