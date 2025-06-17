<?php
session_start();

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit();
}

// Assuming you are redirecting to the checkout page
header('Location: checkout.php');
exit();
?>
