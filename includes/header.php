<?php
session_start(); // Start the PHP session to access session variables
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Car Auction Site</title>
    <link rel="stylesheet" href="css/carbuy.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<header>
    <div class="header-top">
        <h1>
            <a href="index.php">
                <span class="c">C</span>
                <span class="a">a</span>
                <span class="r">r</span>
                <span class="b">b</span>
                <span class="u">u</span>
                <span class="y">y</span>
            </a>
        </h1>
        <div class="hamburger" onclick="toggleNav()">&#9776;</div> <!-- Hamburger icon for mobile menu -->
    </div>
    <nav id="navbar">
        <!-- Search form -->
        <form action="search.php" method="get" class="search-form">
            <input type="text" name="search" placeholder="Search for a car">
            <input type="submit" value="Search">
        </form>
        
        <!-- Navigation links -->
        <ul>
            <li><a href="index.php">Home</a></li>
            <?php if (isset($_SESSION['user_id'])): ?> <!-- Check if user is logged in -->
                <li><a href="addAuction.php">Add Auction</a></li>
                <li><a href="addCategory.php">Add Category</a></li>
                <li><a href="logout.php">Logout</a></li>
                <li><a>Welcome, <?= $_SESSION['name']; ?></a></li> <!-- Display user's name -->
            <?php else: ?>
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
<img src="banners/1.jpg" alt="Banner"> <!-- Banner image -->
<script>
    // JavaScript function to toggle navigation display for mobile view
    function toggleNav() {
        var navbar = document.getElementById("navbar");
        if (navbar.style.display === "block") {
            navbar.style.display = "none";
        } else {
            navbar.style.display = "block";
        }
    }
</script>
</body>
</html>
