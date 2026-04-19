<?php
session_start();
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'db.php';
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $location = $_POST['location'];
    $message_text = $_POST['message'];

    $sql = "INSERT INTO contacts (full_name, email, phone, location, message) VALUES ('$full_name', '$email', '$phone', '$location', '$message_text')";
    if ($conn->query($sql) === TRUE) {
        $message = "Message sent successfully!";
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
    <title>Hotel Website - Contact Us</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
    <header>
        <h1>Contact Us</h1>
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
        <h2>Send us a Message</h2>
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

            <label>Location:</label>
            <input type="text" name="location" required>

            <label>Message:</label>
            <textarea name="message" required></textarea>

            <button type="submit">Send Message</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2023 Our Hotel. All rights reserved.</p>
    </footer>
</body>
</html>