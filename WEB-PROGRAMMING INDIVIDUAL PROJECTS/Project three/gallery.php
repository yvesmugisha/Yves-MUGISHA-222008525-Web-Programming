<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Website - Gallery</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
    <header>
        <h1>Gallery</h1>
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
        <h2>Food and Drink Gallery</h2>
        <p>Click on any image to place an order.</p>
        <div class="gallery">
            <a href="order.php"><img src="/pcs/download.jpg" alt="Grilled Salmon"></a>
            <a href="order.php"><img src="/pcs/fish.jpg" alt="Fried Fish"></a>
            <a href="order.php"><img src="/pcs/coke.jpg" alt="Coke"></a>
            <a href="order.php"><img src="/pcs/orange.jpg" alt="Orange Juice"></a>
            <a href="order.php"><img src="/pcs/beer.jpg" alt="Beer"></a>
        </div>
    </main>
    <footer>
        <p>&copy; 2023 Our Hotel. All rights reserved.</p>
    </footer>
</body>
</html>