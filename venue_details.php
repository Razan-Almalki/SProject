<?php
session_start();

// Check if User_ID is set in the session
if (isset($_SESSION['User_ID'])) {
    $userId = $_SESSION['User_ID'];
    
} else {
    // Handle case when User_ID is not set
    echo "User ID is not set in the session.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venue Details</title>
    <link rel="stylesheet" href="Rubastyles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.11/index.global.min.js"></script>
</head>

<body>
    <header>
        <h1>Venue Details</h1>
    </header>

    <nav>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Venues</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </nav>

    <section class="showDetailsItem-panels" id="detailsSection">
        <!-- Content will be dynamically loaded here -->
    </section>

    <div class="clacontener">
        <div id="calendar" class="calendar"></div>
    </div>

    <!-- WhatsApp Click to Chat Button -->
    <a id="whatsappLink" href="#" target="_blank">
        <img src="images/WhatsApp_icon.png" alt="WhatsApp Icon" width="70">
    </a>

    <div class="show-rating">
        <div class="stars"></div>
        <p id="numOfRates"></p>
    </div>

    <button class="calendarButton" onclick="fetchVenueDetailsAndAddToCart()">أضف إلى العربة</button>

    <div class="pageSections">الخريطة</div>

    <div class="map" id="mapContainer"></div>

    <div class="pageSections" id="commentsTitle">التعليقات</div>

    <!-- Comment Form -->
    <div class="starsANDcomm">
        <div class="rating-box">
            <div class="stars" onclick="setRating(event)">
                <i class="fa-solid fa-star" data-rating="1"></i>
                <i class="fa-solid fa-star" data-rating="2"></i>
                <i class="fa-solid fa-star" data-rating="3"></i>
                <i class="fa-solid fa-star" data-rating="4"></i>
                <i class="fa-solid fa-star" data-rating="5"></i>
            </div>
        </div>

        <form id="commentForm" onsubmit="submitComment(event)">
            <label class="commentHeader">أترك تعليق:</label><br>
            <textarea id="comment" name="comment" rows="4" cols="50" required></textarea><br>
            <button class="submitForm" type="submit">إرسال</button>
        </form>

    </div>

    <section class="comments" id="commentsSection">
        <!-- Comments will be dynamically loaded here -->
    </section>


    <script>

        document.addEventListener("DOMContentLoaded", function () {
            fetchVenueDetails();
        });

        function fetchVenueDetails() {
            const venueId = getVenueIdFromUrl();
            fetch(`http://localhost/idVenue.php?id=${venueId}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Venue details:', data);
                    displayVenueDetails(data);
                    fetchVendorPhoneNumber(venueId);
                    fetchReservedDates(venueId);
                    fetchMap(venueId);
                })
                .catch(error => console.error('Error fetching venue details:', error));
        }

        ////////////////////////////////////////////// venue details

        function displayVenueDetails(data) {
            const detailsSection = document.getElementById('detailsSection');
            if (!detailsSection) {
                console.error('Parent element "detailsSection" not found.');
                return;
            }
            detailsSection.innerHTML = '';

            // Check if data is fetched correctly
            console.log('Fetched venue details:', data);

            // Create elements for venue details
            const img = document.createElement('img');
            img.src = data.pic ? 'data:' + data.pic_type + ';base64,' + data.pic : 'placeholder.jpg'; // Placeholder image if pic is undefined
            img.alt = 'Venue Image';
            //img.style.maxWidth = '100%';
            //img.style.height = 'auto';
            detailsSection.appendChild(img);

            const info = document.createElement('div');
            info.classList.add('info'); // Add a class to the div
            info.textContent = 'معلومات رئيسية';

            const h2 = document.createElement('span');
            h2.classList.add('name'); // Add a class to the span
            h2.textContent = 'الاسم: ' + (data.name ? data.name : 'N/A');

            const pDescription = document.createElement('span');
            pDescription.classList.add('description'); // Add a class to the span
            pDescription.textContent = 'الوصف: ' + (data.description ? data.description : 'N/A');

            const pPrice = document.createElement('span');
            pPrice.classList.add('price'); // Add a class to the span
            pPrice.textContent = 'السعر: ' + (data.price ? data.price : 'N/A') + ' ريال';

            const pDeposit = document.createElement('span');
            pDeposit.classList.add('deposit'); // Add a class to the span
            pDeposit.textContent = 'العربون: ' + (data.deposit ? data.deposit : 'N/A') + ' ريال';

            const pSocialMedia = document.createElement('span');
            pSocialMedia.classList.add('social-media'); // Add a class to the span
            pSocialMedia.textContent = 'مواقع التواصل الإجتماعي: ' + (data.social_media ? data.social_media : 'N/A');

            const pTheme = document.createElement('span');
            pTheme.classList.add('theme'); // Add a class to the span
            pTheme.textContent = 'النوع: ' + (data.theme ? data.theme : 'N/A');


            detailsSection.appendChild(info);
            detailsSection.appendChild(h2);
            detailsSection.appendChild(pDescription);
            detailsSection.appendChild(pPrice);
            detailsSection.appendChild(pDeposit);
            detailsSection.appendChild(pSocialMedia);
            detailsSection.appendChild(pTheme);

            // Call fetchReview function to display review data
            fetchReview(data.id, data, detailsSection);

            fetchComments(data.id, data, detailsSection);
        }

        ///////////////////////////////////phone

        // Function to fetch vendor's phone number and update WhatsApp link
        function fetchVendorPhoneNumber(venueId) {
            fetch(`get_vendor.php?id=${venueId}`) // Fetch vendor's phone number based on service ID
                .then(response => response.json()) // Parse the JSON response
                .then(data => {
                    const vendorPhoneNumber = data.vendor_phone_number; // Extract vendor's phone number from response
                    if (vendorPhoneNumber) { // Check if vendor's phone number exists
                        const whatsappLink = document.getElementById('whatsappLink'); // Get WhatsApp link element
                        whatsappLink.href = `https://wa.me/${vendorPhoneNumber}`; // Set href attribute with vendor's phone number
                    } else {
                        console.error('Vendor phone number not found');
                    }
                })
                .catch(error => console.error('Error fetching vendor phone number:', error)); // Log any errors
        }

        ///////////////////////////////////////map
        function fetchMap(venueId) {
            fetch(`idVenue.php?id=${venueId}`)
                .then(response => response.json())
                .then(data => {
                    // Check if map data is available
                    if (data.map) {
                        const mapContainer = document.getElementById('mapContainer');
                        mapContainer.innerHTML = data.map;
                    } else {
                        console.error('Map data not found.');
                    }
                })
                .catch(error => console.error('Error fetching map data:', error));
        }

        //////////////////////////////////////////////calender

        let selectedStartDate;

        function fetchReservedDates(venueId) {
            fetch(`http://localhost/get_reservations.php?service_id=${venueId}`)
                .then(response => response.json())
                .then(reservedDates => {
                    console.log('Reserved dates:', reservedDates);
                    initCalendar(reservedDates); // Pass reserved dates to the initCalendar function
                })
                .catch(error => console.error('Error fetching reserved dates:', error));
        }

        function initCalendar(reservedDates) {
            var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                headerToolbar: {
                    left: 'customPrevButton customNextButton todayButton',
                    center: 'title',
                    right: ''
                },
                customButtons: {
                    customPrevButton: {
                        text: 'السابق', // Arabic translation for 'prev' button
                        className: 'custom-button', // Add class for custom styling
                        click: function () {
                            calendar.prev(); // Navigate to previous view
                        }
                    },
                    customNextButton: {
                        text: 'التالي', // Arabic translation for 'next' button
                        className: 'custom-button', // Add class for custom styling
                        click: function () {
                            calendar.next(); // Navigate to next view
                        }
                    },
                    todayButton: {
                        text: 'اليوم', // Arabic translation for 'today' button
                        className: 'custom-button', // Add class for custom styling
                        click: function () {
                            calendar.today(); // Navigate to today's date
                        }
                    }
                },
                initialView: 'dayGridMonth',
                allDaySlot: false,
                locale: 'ar', // Setting locale to Arabic
                eventOverlap: function (stillEvent, movingEvent) {
                    return true;
                },
                selectable: true, // Set selectable to true by default
                select: function (info) {
                    handleSelectedDate(info, reservedDates);
                },
                dayCellDidMount: function (info) {
                    handleUnselectedDate(info, reservedDates);
                },
                loading: function () { },
            });

            calendar.render();
        }

        function handleSelectedDate(info, reservedDates) {
            const selectedDate = info.startStr;
            if (reservedDates.includes(selectedDate)) {
                // If the selected date is reserved, prevent selection
                return false;
            }
            // Otherwise, allow selection
            selectedStartDate = selectedDate;
            if (info.dayEl) {
                info.dayEl.style.backgroundColor = 'lightblue';
            }
        }

        function handleUnselectedDate(info, reservedDates) {
            const year = info.date.getFullYear(); // Get the year (YYYY)
            const month = String(info.date.getMonth() + 1).padStart(2, '0'); // Get the month (MM)
            const day = String(info.date.getDate()).padStart(2, '0'); // Get the day (DD)
            const cellDate = year + '-' + month + '-' + day; // Concatenate year, month, and day with hyphens

            if (reservedDates.includes(cellDate)) {
                const cell = info.el;
                cell.classList.add('reserved-date');
                cell.removeEventListener('click', handleClickOnReservedDate); // Remove click event listener
            }
        }

        function handleClickOnReservedDate(event) {
            event.preventDefault(); // Prevent the default action (click) for reserved dates
        }

        ////////////////////////////////////////////// Fetch to add to cart
        function getVenueIdFromUrl() {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('id');
        }

        function fetchVenueDetailsAndAddToCart() {
            const serviceId = getVenueIdFromUrl();
            fetch(`http://localhost/idVenue.php?id=${serviceId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to fetch service details');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Service details:', data);
                    // Extract service details
                    const serviceName = data.name;
                    const servicePrice = data.price;
                    const serviceDeposit = data.deposit;
                    const servicePic = data.pic;
                    const userId = <?php echo json_encode($userId); ?>; // PHP variable echoed into JavaScript
                    console.log('Service Name:', serviceName);
                    console.log('Service Price:', servicePrice);
                    console.log('Service Deposit:', serviceDeposit);
                    console.log('Service Pic:', servicePic);
                    console.log('User ID:', userId);
                    console.log('Date:', selectedStartDate);

                    // Call addToCart function with the extracted service details
                    addToCart(serviceId, serviceName, servicePrice, serviceDeposit, servicePic, userId, selectedStartDate);
                })
                .catch(error => console.error('Error fetching service details:', error.message));
        }

        function addToCart(serviceId, serviceName, servicePrice, serviceDeposit, servicePic, userId, selectedDate) {
            // Check if a date is selected
            if (!selectedDate) {
                console.error('No date selected.');
                return;
            }
            const formData = new FormData();
            formData.append('serviceId', serviceId);
            formData.append('serviceName', serviceName);
            formData.append('servicePrice', servicePrice);
            formData.append('serviceDeposit', serviceDeposit);
            formData.append('servicePic', servicePic);
            formData.append('userId', userId);
            formData.append('date', selectedDate);

            fetch('http://localhost/add_to_cart.php', {
                method: 'POST',
                body: formData
            })
                .then(response => {
                    if (response.ok) {
                        console.log('Service added to cart successfully!');
                        // Call reserveService function after adding to cart
                        reserveService(serviceId, userId, selectedDate);
                    } else {
                        throw new Error('Failed to add service to cart');
                    }
                })
                .catch(error => {
                    console.error('Error adding service to cart:', error);
                });
        }

        //////////////////////////////////////////////Reservation

        function reserveService(serviceId, userId, reservationDate) {
            const formData = new FormData();
            formData.append('serviceId', serviceId);
            formData.append('userId', userId);
            formData.append('reservationDate', reservationDate);

            console.log('User ID:', userId);
            console.log('serviceId:', serviceId);
            console.log('reservationDate:', reservationDate);
            fetch('http://localhost/add_reservation.php', {
                method: 'POST',
                body: formData
            })
                .then(response => {
                    if (response.ok) {
                        console.log('Service reserved successfully!');
                        // Reload the page after reserving the service
                        window.location.reload();
                    } else {
                        throw new Error('Failed to reserve service');
                    }
                })
                .catch(error => {
                    console.error('Error reserving service:', error);
                });
        }

        //////////////////////////////////////////////Comments

        function fetchComments(venueId, venueDetails) {
            fetch(`http://localhost/get_review.php?id=${venueId}`)
                .then(response => response.json())
                .then(reviewData => {
                    // Check if any reviews are returned
                    if (reviewData.length > 0) {
                        // Create a section element to hold the comments
                        const commentsSection = document.createElement('section');
                        commentsSection.id = 'commentsSection';

                        // Iterate through each review and create HTML elements to display them
                        reviewData.forEach(comment => {
                            // Create a container for each comment
                            const commentContainer = document.createElement('div');
                            commentContainer.classList.add('comment');

                            // Create paragraph elements to display comment text, author, and date
                            const commentText = document.createElement('p');
                            commentText.textContent = comment.Comment;
                            commentText.classList.add('comment-text');

                            const commentAuthor = document.createElement('p');
                            commentAuthor.textContent = 'كُتب بواسطة: ' + comment.user_id;
                            commentAuthor.classList.add('comment-author');

                            const commentDate = document.createElement('p');
                            commentDate.textContent = 'بتاريخ: ' + comment.created_at;
                            commentDate.classList.add('comment-date');

                            // Append comment text, author, and date to the comment container
                            commentContainer.appendChild(commentText);
                            commentContainer.appendChild(commentAuthor);
                            commentContainer.appendChild(commentDate);

                            // Append the comment container to the comments section
                            commentsSection.appendChild(commentContainer);
                        });

                        // Find the comment form and its parent element
                        const commentForm = document.getElementById('commentForm');
                        const parentElement = commentForm.parentNode;

                        // Insert the comments section after the comment form
                        parentElement.insertBefore(commentsSection, commentForm.nextSibling);
                    } else {
                        // If no comments are found, display a message
                        const commentsSection = document.createElement('section');
                        commentsSection.id = 'commentsSection';

                        const noCommentsMessage = document.createElement('p');
                        noCommentsMessage.textContent = 'لا توجد تعليقات...🤫';
                        noCommentsMessage.style.textAlign = 'center';
                        noCommentsMessage.style.direction = 'rtl';
                        noCommentsMessage.style.color = '#6d6d6d';

                        commentsSection.appendChild(noCommentsMessage);

                        // Find the comment form and its parent element
                        const commentForm = document.getElementById('commentForm');
                        const parentElement = commentForm.parentNode;

                        // Insert the comments section after the comment form
                        parentElement.insertBefore(commentsSection, commentForm.nextSibling);
                    }
                })
                .catch(error => console.error('Error fetching review data:', error));
        }



        ////////////////////////////////////////////// Rate


        // Function to send review data to add_review.php
        function sendReviewData(activeStars, comment, serviceId) {
            // Constrain activeStars within the range of 1 to 5
            const rating = Math.min(Math.max(activeStars, 1), 5);
            const formData = new FormData();
            formData.append('rating', rating);
            formData.append('comment', comment);
            formData.append('service_id', serviceId); // Include service ID in the form data

            return fetch('http://localhost/add_review.php', {
                method: 'POST',
                body: formData
            })
                .then(response => {
                    if (response.ok) {
                        console.log('Review submitted successfully!');
                        return response.json(); // Return response data if needed
                    } else {
                        throw new Error('Failed to submit review');
                    }
                });
        }


        // Global variable to store active stars
        let activeStarsValue = 0;

        // Function to handle rating selection
        function setRating(event) {
            const stars = document.querySelectorAll('.rating-box .stars i');
            const selectedRating = parseInt(event.target.dataset.rating);

            stars.forEach((star, index) => {
                if (index < selectedRating) {
                    star.classList.add('active');
                } else {
                    star.classList.remove('active');
                }
            });

            // Update the global variable with the number of active stars
            activeStarsValue = document.querySelectorAll('.rating-box .stars i.active').length;
            console.log('Active Stars:', activeStarsValue);
        }

        // Function to handle form submission for comments
        function submitComment(event) {
            event.preventDefault(); // Prevent default form submission

            console.log("Active Stars in submitComment:", activeStarsValue); // Log activeStars value to the console

            const comment = document.getElementById('comment').value; // Get comment text
            const serviceId = getVenueIdFromUrl(); // Get the service ID

            sendReviewData(activeStarsValue, comment, serviceId)
                .then(response => {
                    console.log(response); // Log the response
                    document.getElementById('commentForm').reset(); // Reset the form
                    location.reload();
                })
                .catch(error => console.error('Error submitting review:', error));
        }


        /////////////////////////////////////////////////rate and num of rate show


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
                        starsContainer.classList.add('detailedStars'); // Add a unique class name for the stars container
                        starsContainer.classList.add('stars'); // Add the stars class if needed
                        starsContainer.style.display = 'flex'; // Use flexbox for layout

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

                        // Create a text node with the number of rates
                        const ratesText = document.createTextNode(` (${validRatingsCount})`);
                        // Append the ratesText to the starsContainer
                        starsContainer.appendChild(ratesText);

                        // Append the starsContainer to the article or any parent element
                        article.appendChild(starsContainer);

                    } else {
                        const p4 = document.createElement('div');
                        p4.classList.add('detailedStars');
                        p4.textContent = 'لا توجد تقييمات';
                        p4.style.display = 'flex'; // Use flexbox for layout

                        // Append average rate paragraph to the article
                        article.appendChild(p4);
                    }

                })
                .catch(error => console.error('Error fetching review data:', error));
        }

    </script>

    <footer>
        <p>&copy; 2024 Venue Shop. All rights reserved.</p>
    </footer>

</body>

</html>