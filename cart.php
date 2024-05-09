<?php 
session_start(); 

$user_id = $_SESSION['User_ID'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #e0a7b2, #88b5d5, #0c7a71);
            min-height: 100vh;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
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
            color: #FFFFFF;
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
    </style>
</head>

<body>
    <h1>عربة التسوق</h1>

    <section class="container" id="cart-items"></section>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetchCartItems();
        });

        function fetchCartItems() {
            // Replace '1' with the actual user ID
            const userId = "<?php echo isset($_SESSION['User_ID']) ? $_SESSION['User_ID'] : ''; ?>";

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
                            window.location.href = 'payment.html'; // Redirect to payment page when clicked >> to php!!!!!!!!!!!!!!!
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