<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Website - About Us</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
    <header>
        <h1>About Our Hotel</h1>
    </header>
    <nav>
        <a href="index.php">Home</a>
        <a href="about.php">About Us</a>
        <a href="menu.php">Menu</a>
        <a href="order.php">Order</a>
        <a href="gallery.php">Gallery</a>
        <a href="contact.php">Contact Us</a>
        <?php if(isset($_SESSION['user'])): ?>
            <a href="view_orders.php">View Orders</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </nav>
    <main>
        <h2>About Us</h2>
        <p>Our hotel has been serving guests for over 20 years with exceptional service and delicious cuisine. We pride ourselves on using fresh ingredients and providing a memorable dining experience.</p>
    </main>
    <footer>
        <p>&copy; 2023 Our Hotel. All rights reserved.</p>
    </footer>
</body>
</html>