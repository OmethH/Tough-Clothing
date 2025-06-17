<?php
session_start();

if (isset($_POST["btnSubmit"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    // Establish database connection
    $conn = mysqli_connect("localhost", "root", "", "website", 3306);
    
    // Check connection
    if (!$conn) {
        die("DB connection failed: " . mysqli_connect_error());
    }
    
    // Prevent SQL injection using prepared statements
    $sql = "SELECT Email, Password FROM signin WHERE Email = ? AND Password = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    // Check if statement preparation was successful
    if ($stmt === false) {
        die("Error preparing the statement: " . mysqli_error($conn));
    }

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ss", $email, $password);
    
    // Execute statement
    mysqli_stmt_execute($stmt);
    
    // Get result
    $result = mysqli_stmt_get_result($stmt);
    
    // Check if there are any rows returned
    if (mysqli_num_rows($result) > 0) {
        $_SESSION['email'] = $email;
        header("Location: ./home.html");
        exit();
    } else {
        header("Location: ./login.php?error=1");
        exit();
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    
</head>

<body>
    <nav>
        <ul>
            <li><a href="home.html">Home</a></li>
            <li><a href="aboutus.html">About</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </nav>

    <div class="loginform">
        <h1>Login</h1>
        <form action="login.php" method="post">
            <p>Email Address</p>
            <input type="email" name="email" placeholder="Email Address" required>
            <p>Password</p>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="btnSubmit">Login</button>
            <a href="signup.php">Create Account?</a>
            <p><a href = "forgot.php">Forgot Password?</a></p>
        </form>

        <?php
        if (isset($_GET['error']) && $_GET['error'] == 1) {
            echo '<p style="color:red;">Invalid email or password.</p>';
        }
        ?>
    </div>
</body>
</html>
