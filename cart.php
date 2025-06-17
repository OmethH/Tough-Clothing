<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
    <link rel="stylesheet" type="text/css" href="cart.css">
</head>
<body>
<nav>
    <ul>
        <li><a href="home.html">Home</a></li>
        <li><a href="products1.html">Shop</a></li>
        <li><a href="aboutus.html">About</a></li>
        <li><a href="services.html">Services</a></li>
        <li><a href="Contactpage.html">Contact</a></li>
    </ul>
</nav>
<div class="container">
    <h1>Your Shopping Cart</h1>
    <div class="cart">
        <div class="products">
            <?php
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $id => $product) {
            ?>
            <div class="product">
                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image">
                <div class="product-info">
                    <h3 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h3>
                    <h4 class="product-price">Rs <?php echo htmlspecialchars($product['price']); ?></h4>
                    <p class="product-size">Size: <?php echo htmlspecialchars($product['size']); ?></p>
                    <p class="product-quantity">Qnt: <input value="<?php echo htmlspecialchars($product['quantity']); ?>" name=""></p>
                    <form action="removeHandler.php" method="post">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                        <p class="product-remove">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                            <button type="submit" class="remove">Remove</button>
                        </p>
                    </form>
                </div>
            </div>
            <?php
                }
            } else {
                echo "<p>Your cart is empty.</p>";
            }
            ?>
        </div>
        <div class="cart-total">
            <p>
                <span>Total Price</span>
                <span>
                    Rs 
                    <?php
                    $totalPrice = 0;
                    $totalItems = 0;
                    if (isset($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $product) {
                            $totalPrice += $product['price'] * $product['quantity'];
                            $totalItems += $product['quantity'];
                        }
                    }
                    echo $totalPrice;
                    ?>
                </span>
            </p>
            <p>
                <span>Number of Items</span>
                <span><?php echo $totalItems; ?></span>
            </p>
            <form action="checkoutHandler.php" method="post">
                <button type="submit">Proceed to Checkout</button>
            </form>
        </div>
    </div>
</div>
<footer>
    <p>&copy; Tough Clothing Online Store. All rights reserved.</p>
</footer>
</body>
</html>
