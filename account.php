<?php
	session_start();
	if(!isset($_SESSION["email"])) {
		header("Location: login.php");
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Dashboard</title>
	<link rel="stylesheet" type="text/css" href="css/dashBoardStyle.css"/>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Anta&display=swap');
    
    body {
        margin: 0;
        padding: 0;
        font-family: 'Anta', sans-serif;
        background-color: #000;
        color: #fff;
    } 
    .sections {
        float: left;
        width: 50%;  
        background-color: #1a1a1a; 
        justify-content: space-around;
    }
    h2 {
        color: #00bcd4;
        font-family: 'Anta', sans-serif;
    }
    h3 {
        color: #00bcd4;
        font-family: 'Anta', sans-serif;  
    }
    div {
        box-sizing: border-box;
    }
    nav {
        background: #000;
        display: flex;
        justify-content: space-around;
        align-items: center;
        color: #fff;
        padding: 15px 0;
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
        font-family: 'Anta', sans-serif;
    }
    .nav-links a:hover {
        color: #00bcd4;
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
    .sections p {
        color: #fff;
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
    .main-section {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        align-items: center;
        margin-top: 50px;
    }
    .dashbord {
        background: #333;
        width: 30%;
        margin: 15px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        text-align: center;
        padding: 20px;
    }
    .dashbord img {
        border-radius: 50%;
        width: 100px;
        height: 100px;
    }
    .dashbord a {
        display: block;
        margin-top: 15px;
        padding: 10px;
        background: #00bcd4;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        transition: background 0.3s;
    }
    .dashbord a:hover {
        background: #0097a7;
    }
    .dashbord-green {
        background: #2e7d32;
    }
    .dashbord-blue {
        background: #1565c0;
    }
    .dashbord-skyblue {
        background: #0288d1;
    }
    .dashbord-red {
        background: #c62828;
    }
    .dashbord-orange {
        background: #ef6c00;
    }
    </style>
</head>

<body>
    
<script>
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
        link.style.animation = `navLinkFade 0.5s ease forwards ${
          index / 7 + 0.5
        }s `;
      }
    });
    burger.classList.toggle("toggle");
  });
};

navSlide();
</script>
<nav>
  <div class="logo">
    <h4>Tough Clothing</h4>
  </div>
  <ul class="nav-links"> 
    <li><a href="home.html">Home</a></li>
    <li><a href="login.php">Sign In</a></li> 
    <li><a href="cart.php">Cart</a></li>
    <li><a href="products.php">All Items</a></li> 
  </ul>
  <div class="burger">
    <div class="line1"></div>
    <div class="line2"></div>
    <div class="line3"></div>
  </div>
</nav>
<div class="container">
  <div class="main-section">
    <div class="dashbord">
      <div class="icon-section">
        <img src="profpic.png" alt="Profile Picture" width="87" height="90">
      </div>
      <div class="detail-section">
        <a href="#">My Profile</a>
      </div>
    </div>
    <div class="dashbord dashbord-green">
      <div class="icon-section">
        <img src="add.png" alt="Add Advertisement" width="87" height="90">
      </div>
      <div class="detail-section">
        <a href="AddAdvertisement.php">Add Product</a>
      </div>
    </div>
    <div class="dashbord dashbord-blue">
      <div class="icon-section">
        <img src="view.png" alt="View Advertisement" width="87" height="90">
      </div>
      <div class="detail-section">
        <a href="ViewMyAdvertisements.php">View Products</a>
      </div>
    </div>
    <div class="dashbord dashbord-red">
      <div class="icon-section">
        <img src="edit.jpeg" alt="Edit Advertisement" width="87" height="90">
      </div>
      <div class="detail-section">
        <a href="EditAdvertisements.php">Edit Advertisements</a>
      </div>
    </div>
    <div class="dashbord dashbord-orange">
      <div class="icon-section">
        <img src="shop.png" alt="View All Advertisements" width="87" height="90">
      </div>
      <div class="detail-section">
        <a href="products.php">View All Products</a>
      </div>
    </div>
  </div>
</div>
</body>
</html>
