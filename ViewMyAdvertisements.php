<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>View My Advertisements</title>
<link rel="stylesheet" href="CSS/formStyle.css" type="text/css">

<style>
        @import url('https://fonts.googleapis.com/css2?family=Anta&display=swap');

        body {
            margin: 0;
            padding: 0;
            font-family: 'Anta', sans-serif;
            background-color: #f4f4f4;
        }

        nav {
            background: #0077cc; 
            display: flex;
            justify-content: space-around;
            align-items: center;
            color: #fff;
        }

        .nav-links {
            display: flex;
            justify-content: space-around;
            width: 50%;
            text-transform: uppercase;
        }

        .nav-links a {
            display: block;
            text-transform: uppercase;
            text-decoration: none;
            color: #fff;
            border-bottom: 2px solid transparent;
            transition: 0.5s ease;
            transform: translateX(0%);
            padding: 10px 0; 
        }

        .nav-links a:hover {
            color: #004d99; 
            letter-spacing: 5px;
        }

        .burger {
            display: none;
        }

        .burger div {
            width: 25px;
            height: 3px;
            background: #fff;
            margin: 5px;
            transition: all 0.5s ease;
        }

        @media only screen and (max-width: 760px) {
            nav {
                justify-content: space-between;
                padding: 0 5vw;
            }

            .nav-links {
                position: absolute;
                right: 0;
                top: 8vh;
                min-height: 92vh;
                background: #333;
                display: flex;
                flex-direction: column;
                align-items: center;
                width: 50%;
                margin: 0;
                padding: 0;
                transform: translateX(100%);
                transition: all 0.5s ease-in;
            }

            .nav-links a {
                opacity: 0;
            }

            .burger {
                display: block;
            }
        }

        @media only screen and (max-width: 640px) {
            nav {
                justify-content: space-between;
                padding: 0 5vw;
            }
        }

        .nav-active {
            transform: translateX(0);
        }

        @media only screen and (max-width: 460px) {
            .nav-links {
                width: 100%;
                transition: all 0.5s ease;
            }
        }

        .nav-active {
            transform: translateX(0);
        }

        @keyframes navLinkFade {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .toggle .line1 {
            transform: rotate(-45deg) translate(-5px, 6px);
        }

        .toggle .line2 {
            opacity: 0;
        }

        .toggle .line3 {
            transform: rotate(45deg) translate(-5px, -6px);
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .column {
            flex: 1;
            max-width: 30%;
            margin: 20px;
            padding: 10px;
            box-sizing: border-box;
        }

        @media screen and (max-width: 650px) {
            .column {
                max-width: 100%;
                display: block;
            }
        }

        .card {
            background: #fff;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            overflow: hidden;
        }

        .card img {
            width: 100%;
            height: auto;
        }

        .container {
            padding: 16px;
        }

        .container h2, .container p {
            margin: 0;
            padding: 0;
        }

        hr {
            border: 1px solid #f4f4f4;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .button-container a {
            background-color: #333;
            padding: 8px;
            border-radius: 4px;
            color: #fff;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .button-container a:hover {
            background-color: #7CFC00;
        }

        .button-container a.delete {
            background-color: red;
        }

        .button-container a.delete:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const navSlide = () => {
        const burger = document.querySelector(".burger");
        const nav = document.querySelector(".nav-links");
        const navLinks = document.querySelectorAll(".nav-links a");

        burger.addEventListener("click", () => {
            nav.classList.toggle("nav-active");

            navLinks.forEach((link, index) => {
                if (link.style.animation) {
                    link.style.animation = "";
                } else {
                    link.style.animation = `navLinkFade 0.5s ease forwards ${index / 7 + 0.5}s`;
                }
            });
            burger.classList.toggle("toggle");
        });
    };

    navSlide();
});
</script>

<nav>
    <div class="logo">
        <h4>Tough Clothing</h4>
    </div>
    <ul class="nav-links">
        <li><a href="home.html">Home</a></li>
        <li><a href="login.php">Sign In</a></li>
        <li><a href="account.php">My Account</a></li>
        <li><a href="products.php">All Products</a></li>
    </ul>
    <div class="burger">
        <div class="line1"></div>
        <div class="line2"></div>
        <div class="line3"></div>
    </div>
</nav>

<div class="row">
    <?php
        $conn = mysqli_connect("localhost", "root", "", "website", "3306");
        if (!$conn) {
            die("DB connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT * FROM advertisement WHERE Category = 'T-shirt'";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
    ?>
    <div class="column">
        <div class="card">
            <img src="<?php echo htmlspecialchars($row['Image_Path']); ?>" alt="Product Image">
            <div class="container">
                <h2><?php echo htmlspecialchars($row['Product_Name']); ?></h2>
                <p>Price: <?php echo htmlspecialchars($row['Price']); ?></p>
                <hr>
                <div class="button-container">
                    <a href="EditAdvertisements.php?Add_ID=<?php echo $row['Add_ID']; ?>">Edit</a>
                    <a class="delete" href="DeleteAdvertisement.php?Add_ID=<?php echo $row['Add_ID']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </div>
            </div>
        </div>
    </div>
    <?php
                }
            } else {
                echo "<p>No advertisements found.</p>";
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "<p>Error preparing query: " . mysqli_error($conn) . "</p>";
        }

        mysqli_close($conn);
    ?>
</div>

</body>
</html>
