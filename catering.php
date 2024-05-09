<?php 
session_start(); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> 🍽️ تقديم الطعام</title>
    <link rel="stylesheet" href="Rubastyles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
</head>

<body>
    <header>
        <h1>تقديم الطعام</h1>
    </header>
    <nav>
        <ul>
            <li><a href="#">الرئيسية</a></li>
            <li><a href="service.html">الخدمات</a></li>
            <li><a href="#">معلومات عنا</a></li>
            <li><a href="#">التواصل</a></li>
        </ul>
    </nav>

    <section class="showItem-panels" id="cateringSection">
    </section>

    <footer>
        <p>&copy; 2024 My Shop. All rights reserved.</p>
    </footer>


    <script>

        fetch('http://localhost/get_catering_data.php')
            .then(response => response.json())
            .then(data => {
                const cateringSection = document.getElementById('cateringSection');

                data.forEach(catering => {
                    // Check if the service type is 'Catering'
                    if (catering.type === 'Catering') {
                        const article = document.createElement('article');
                        article.classList.add('catering');

                        // Create an image element
                        const img = document.createElement('img');
                        img.src = catering.pic ? 'data:image/' + catering.pic_type + ';base64,' + catering.pic : 'placeholder.jpeg'; // Placeholder image if pic is undefined
                        img.alt = catering.name;

                        const h2 = document.createElement('h2');
                        h2.textContent = catering.name;

                        const p2 = document.createElement('p');
                        p2.textContent = 'السعر: ' + catering.price + ' ريال';

                        const p3 = document.createElement('p');
                        p3.textContent = 'العربون: ' + catering.deposit + ' ريال';

                        // Append image, heading, and paragraphs to the article
                        article.appendChild(img);
                        article.appendChild(h2);
                        article.appendChild(p2);
                        article.appendChild(p3);

                        // Fetch and append rate and number of rates
                        fetchReview(catering.id, catering, article);

                        // Append article to the catering section
                        cateringSection.appendChild(article);
                    }
                });
            })
            .catch(error => console.error('Error fetching catering data:', error));

        function fetchReview(cateringId, cateringDetails, article) {
            fetch(`http://localhost/get_review.php?id=${cateringId}`)
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
                        const readMoreButton = createReadMoreButton(cateringId);
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
                        const readMoreButton = createReadMoreButton(cateringId);
                        article.appendChild(readMoreButton);
                    }
                })
                .catch(error => console.error('Error fetching review data:', error));
        }

        // Function to create the read more button
        function createReadMoreButton(cateringId) {

            const readMoreButton = document.createElement('button');
            readMoreButton.textContent = 'إقرأ المزيد';
            readMoreButton.addEventListener('click', () => {
                window.location.href = `http://localhost/catering_details.php?id=${cateringId}`;
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