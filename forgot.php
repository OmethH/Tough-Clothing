<?php
// Create connection
$conn = mysqli_connect("localhost", "root", "", "website", "3306");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is set
if (isset($_POST['users']) && isset($_POST['newpass'])) {
    $user = $_POST['users'];
    $new_pass = $_POST['newpass'];

    // Update the password in the database
    $sql = "UPDATE signin SET Password='$new_pass' WHERE User_Name='$user'";

    if ($conn->query($sql) === TRUE) {
        header("Location: login.php");
        echo "Password updated successfully";
    } else {
        echo "Error updating password: " . $conn->error;
    }
} else {
    echo "Please fill in all fields.";
}

$conn->close();
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome Icons  -->
    <link rel="stylesheet" href="forgot.css">

    <title>Tough Clothing</title>
</head>

<body>

    <div class="card">
        <div class="lock-icon">
            <h2>Forgot Password?</h2>
            <p>You can reset your Password here</p>
            <form method="POST" action="forgot.php">
                <input type="text" class="passInput" placeholder="Username" name="users" id="users">
                <input type="password" class="passInput" placeholder="Password" name="newpass" id="newpass">
                <button type="submit">Reset My Password</button>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; Tough Clothing. All rights reserved.</p>
    </footer>

</body>

</html>