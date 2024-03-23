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
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
            max-width: 100px;
            margin-right: 20px;
        }
        .cart-item p {
            margin: 0;
        }
        .cart-item .item-name {
            font-weight: bold;
        }
        .cart-total {
            margin-top: 20px;
            text-align: right;
        }
        @media (max-width: 600px) {
            .container {
                padding: 10px;
            }
            .cart-item img {
                max-width: 80px;
            }
            .cart-item {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Shopping Cart</h1>
        <?php
            // Database connection
            $servername = "localhost"; // Change this to your MySQL server hostname
            $username = "Razan"; // Change this to your MySQL username
            $password = "0559945643"; // Change this to your MySQL password
            $database = "myDB"; // Change this to your database name

            $conn = new mysqli($servername, $username, $password, $database);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch data from the cart table
            $sql = "SELECT * FROM cart";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<div class='cart-item'>";
                    echo "<img src='https://via.placeholder.com/150' alt='Product Image'>";
                    echo "<div>";
                    echo "<p class='item-name'>" . $row["product_name"] . "</p>";
                    echo "<p>Price: $" . $row["price"] . "</p>";
                    echo "<p>Quantity: " . $row["quantity"] . "</p>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "0 results";
            }
            $conn->close();
        ?>
        <div class="cart-total">
            <p>Total: <span id="total">0.00</span></p>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            calculateTotal();
        });

        function calculateTotal() {
            var prices = document.querySelectorAll('.cart-item p:nth-child(2)');
            var quantities = document.querySelectorAll('.cart-item p:nth-child(3)');
            var total = 0;

            prices.forEach(function(price, index) {
                var priceValue = parseFloat(price.textContent.replace('Price: $', ''));
                var quantity = parseInt(quantities[index].textContent.replace('Quantity: ', ''));
                total += priceValue * quantity;
            });

            document.getElementById('total').textContent = total.toFixed(2);
        }
    </script>
</body>
</html>
