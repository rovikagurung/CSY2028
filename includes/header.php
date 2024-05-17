<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Car Auction Site</title>
    <link rel="stylesheet" href="carbuy.css">
</head>
<body>
    <header>
    <h1>
        <span class="C">C</span><span class="a">a</span><span class="r">r</span><span class="b">b</span><span class="u">u</span><span class="y">y</span>
    </h1>
    <form action="search.php" method="get">
        <input type="text" name="search" placeholder="Search for a car">
        <input type="submit" value="Search">
    </form>        
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="addAuction.php">Add Auction</a></li>
                    <li><a href="logout.php">Logout</a></li>
                    <li>Welcome, <?php echo $_SESSION['user_name']; ?></li>
                <?php else: ?>
                    <li><a href="register.php">Register</a></li>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <img src="banners/1.jpg" alt="Banner">
    <main>
