<?php
session_start();
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'db.php';
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $menu_item = $_POST['menu_item'];
    $address = $_POST['address'];
    $order_date = $_POST['order_date'];

    $sql = "INSERT INTO orders (full_name, email, phone, menu_item, address, order_date) VALUES ('$full_name', '$email', '$phone', '$menu_item', '$address', '$order_date')";
    if ($conn->query($sql) === TRUE) {
        $message = "Order placed successfully!";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Website - Order</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
    <header>
        <h1>Place Your Order</h1>
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
        <h2>Order Form</h2>
        <?php if($message): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        <form method="post">
            <label>Full Name:</label>
            <input type="text" name="full_name" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Phone:</label>
            <input type="text" name="phone" required>

            <label>Select Menu:</label>
            <select name="menu_item" required>
                <option value="">Select an item</option>
                <option value="Grilled Salmon">Grilled Salmon</option>
                <option value="Fried Fish">Fried Fish</option>
                <option value="Coke">Coke</option>
                <option value="Beer">Beer</option>
                <option value="Orange Juice">Orange Juice</option>
                <option value="Apple Juice">Apple Juice</option>
            </select>

            <label>Address:</label>
            <textarea name="address" required></textarea>

            <label>Date:</label>
            <input type="date" name="order_date" required>

            <button type="submit">Place Order</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2023 Our Hotel. All rights reserved.</p>
    </footer>
</body>
</html>