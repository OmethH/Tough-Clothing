<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link rel="stylesheet" href="CSS/formStyle.css" type="text/css">

<style>
        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            background-color: #f4f4f4; 
            color: #333; 
        }

        div {
            box-sizing: border-box;
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
            color: #4CAF50; 
            letter-spacing: 2px;
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
                background: #000; 
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
        <li><a href="account.php">Account</a></li>
        <li><a href="products.php">All Products</a></li>
    </ul>
    <div class="burger">
        <div class="line1"></div>
        <div class="line2"></div>
        <div class="line3"></div>
    </div>
</nav>

<div class="form-style-5">
    <form action="./AddAdvertisement.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend><span class="number">1</span> Product Info</legend>
            <p>
                <input type="text" name="txtTitle" placeholder="Product Name" required>
                <textarea name="txtPrice" placeholder="Price of the product"></textarea>
                <input type="file" name="imageFile" placeholder="Upload a Picture" required>
                <textarea name="txtCategory" placeholder="Category of the product"></textarea>
            </p>
        </fieldset>
        <fieldset>
            <label for="txtPublish">Publish the Advertisement :
                <input type="checkbox" name="txtPublish">
            </label>
        </fieldset>
        <input type="submit" name="btnSubmit" value="Add Post">
    </form>

    <?php
    if (isset($_POST["btnSubmit"])) {
        $title = $_POST["txtTitle"];
        $price = $_POST["txtPrice"];
        $publish = isset($_POST["txtPublish"]) ? 1 : 0;
        $category= $_POST["txtCategory"];

        // Check if the uploads directory exists, if not create it
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $file_name = basename($_FILES["imageFile"]["name"]);
        $file_path = $uploadDir . $file_name;

        if (move_uploaded_file($_FILES["imageFile"]["tmp_name"], $file_path)) {
            $conn = mysqli_connect("localhost", "root", "", "website");

            if (!$conn) {
                die("DB connection failed: " . mysqli_connect_error());
            }

            // Ensure to escape the inputs to prevent SQL injection
            $title = mysqli_real_escape_string($conn, $title);
            $price = mysqli_real_escape_string($conn, $price);
            $file_path = mysqli_real_escape_string($conn, $file_path);
            $category = mysqli_real_escape_string($conn, $category);

            $sql = "INSERT INTO advertisement (Product_Name, Price, Image_Path, Publish, Category) VALUES ('$title', '$price', '$file_path', '$publish', '$category')";

            if (mysqli_query($conn, $sql)) {
                echo "Advertisement added successfully!";
            } else {
                echo "Error: " . mysqli_error($conn);
            }

            mysqli_close($conn);
        } else {
            echo "Error uploading the file.";
        }
    }
    ?>
</div>
</body>
</html>
