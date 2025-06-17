<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $selected_size = $_POST['size']; // Capture the selected size from the form

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$product_id])) {
        // If product already exists in cart, update quantity and size
        $_SESSION['cart'][$product_id]['quantity']++;
        $_SESSION['cart'][$product_id]['size'] = $selected_size; // Update size
    } else {
        $conn = mysqli_connect("localhost", "root", "", "website", "3306");
        if (!$conn) {
            die("DB connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT * FROM advertisement WHERE Add_ID = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $product_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                $_SESSION['cart'][$product_id] = [
                    'name' => $row['Product_Name'],
                    'price' => $row['Price'],
                    'image' => $row['Image_Path'],
                    'quantity' => 1,
                    'size' => $selected_size  // Store the selected size
                ];
            }

            mysqli_stmt_close($stmt);
        }

        mysqli_close($conn);
    }

    header("Location: products.php"); // Redirect to the products page or wherever needed
    exit();
}
?>
