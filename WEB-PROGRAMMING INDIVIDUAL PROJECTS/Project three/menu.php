<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Website - Menu</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
    <header>
        <h1>Our Menu</h1>
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
        <h2>Menu Items</h2>
        <table>
            <tr>
                <th>Category</th>
                <th>Item</th>
                <th>Description</th>
                <th>Price</th>
            </tr>
            <tr>
                <td>Fish</td>
                <td>Grilled Salmon</td>
                <td>Fresh salmon grilled to perfection</td>
                <td>$15</td>
            </tr>
            <tr>
                <td>Fish</td>
                <td>Fried Fish</td>
                <td>Crispy fried fish with herbs</td>
                <td>$12</td>
            </tr>
            <tr>
                <td>Drink</td>
                <td>Coke</td>
                <td>Classic cola drink</td>
                <td>$2</td>
            </tr>
            <tr>
                <td>Drink</td>
                <td>Beer</td>
                <td>Refreshing beer</td>
                <td>$4</td>
            </tr>
            <tr>
                <td>Fresh Juice</td>
                <td>Orange Juice</td>
                <td>Freshly squeezed orange juice</td>
                <td>$3</td>
            </tr>
            <tr>
                <td>Fresh Juice</td>
                <td>Apple Juice</td>
                <td>Pure apple juice</td>
                <td>$3</td>
            </tr>
        </table>
    </main>
    <footer>
        <p>&copy; 2023 Our Hotel. All rights reserved.</p>
    </footer>
</body>
</html>