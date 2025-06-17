<?php
session_start();

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'website', 3306);
    
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Retrieve form data
    $fullName = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $country = $_POST['country'];
    $cardName = $_POST['cardname'];
    $cardNumber = $_POST['cardnumber'];
    $expMonth = $_POST['expmonth'];
    $expYear = $_POST['expyear'];
    $cvv = $_POST['cvv'];
    
    // Prepare the order description
    $description = '';
    foreach ($_SESSION['cart'] as $id => $product) {
        $productName = htmlspecialchars($product['name']);
        $productPrice = htmlspecialchars($product['price']);
        $productQuantity = htmlspecialchars($product['quantity']);
        $productSize = isset($product['size']) ? htmlspecialchars($product['size']) : 'Not specified';
        $description .= "{$productName} - Size: {$productSize} - Rs {$productPrice} x {$productQuantity}\n";
    }

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO customer_details (Full_Name, Email, Address, City, State, Zip_Code, Country, Name_on_Card, CreditCardNumber, Exp_Month, Exp_Year, CVV, Description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssssss", $fullName, $email, $address, $city, $state, $zip, $country, $cardName, $cardNumber, $expMonth, $expYear, $cvv, $description);

    // Execute SQL statement
    if ($stmt->execute()) {
        // Clear the cart session
        unset($_SESSION['cart']);
        header('Location: checkout.php?status=success');
        exit();
    } else {
        header('Location: checkout.php?status=error');
        exit();
    }

    // Close the connection
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e0f7fa;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        header {
            background: #000;
            color: #fff;
            padding-top: 30px;
            min-height: 70px;
            border-bottom: #00bcd4 3px solid;
        }
        header a {
            color: #fff;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 16px;
        }
        header ul {
            padding: 0;
            list-style: none;
        }
        header li {
            float: left;
            display: inline;
            padding: 0 20px 0 20px;
        }
        .checkout-form {
            background: #fff;
            padding: 20px;
            margin-top: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .checkout-form h2 {
            margin-bottom: 20px;
            color: #000;
        }
        .checkout-form label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #000;
        }
        .checkout-form input, .checkout-form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #00bcd4;
            border-radius: 5px;
        }
        .checkout-form button {
            background: #000;
            color: #fff;
            border: 0;
            padding: 15px 20px;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
            font-size: 16px;
        }
        .checkout-form button:hover {
            background: #333;
        }
        .order-summary {
            background: #fff;
            padding: 20px;
            margin-top: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .order-summary h3 {
            margin-bottom: 20px;
            color: #000;
        }
        .order-summary ul {
            list-style: none;
            padding: 0;
        }
        .order-summary ul li {
            padding: 10px 0;
            border-bottom: 1px solid #00bcd4;
        }
        .order-summary p {
            font-weight: bold;
            margin-top: 20px;
            color: #000;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div id="branding">
                <h1><a href="home.html">Tough Clothing</a></h1>
            </div>
            <nav>
                <ul>
                    <li><a href="home.html">Home</a></li>
                    <li><a href="products1.html">Shop</a></li>
                    <li><a href="aboutus.html">About</a></li>
                    <li><a href="services.html">Services</a></li>
                    <li><a href="Contactpage.html">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container">
        <div class="checkout-form">
            <h2>Checkout</h2>
            <form action="checkout.php" method="post">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required>
                
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                
                <label for="address">Address</label>
                <input type="text" id="address" name="address" required>
                
                <label for="city">City</label>
                <input type="text" id="city" name="city" required>
                
                <label for="state">State</label>
                <input type="text" id="state" name="state" required>
                
                <label for="zip">Zip Code</label>
                <input type="text" id="zip" name="zip" required>
                
                <label for="country">Country</label>
                <input type="text" id="country" name="country" required>
                
                <label for="cardname">Name on Card</label>
                <input type="text" id="cardname" name="cardname" required>
                
                <label for="cardnumber">Credit Card Number</label>
                <input type="text" id="cardnumber" name="cardnumber" required>
                
                <label for="expmonth">Exp Month</label>
                <input type="text" id="expmonth" name="expmonth" required>
                
                <label for="expyear">Exp Year</label>
                <input type="text" id="expyear" name="expyear" required>
                
                <label for="cvv">CVV</label>
                <input type="text" id="cvv" name="cvv" required>
                
                <button type="submit">Place Order</button>
            </form>
        </div>
        <div class="order-summary">
            <h3>Your Order</h3>
            <ul>
                <?php
                $totalPrice = 0;
                foreach ($_SESSION['cart'] as $id => $product) {
                    $productName = htmlspecialchars($product['name']);
                    $productPrice = htmlspecialchars($product['price']);
                    $productQuantity = htmlspecialchars($product['quantity']);
                    $productSize = isset($product['size']) ? htmlspecialchars($product['size']) : 'Not specified'; // Display size or a default message
                    $subtotal = $productPrice * $productQuantity;
                    $totalPrice += $subtotal;
                    echo "<li>{$productName} - Size: {$productSize} - Rs {$productPrice} x {$productQuantity} = Rs {$subtotal}</li>";
                }
                ?>
            </ul>
            <p>Total: Rs <?php echo $totalPrice; ?></p>
        </div>
    </div>
</body>
</html>
