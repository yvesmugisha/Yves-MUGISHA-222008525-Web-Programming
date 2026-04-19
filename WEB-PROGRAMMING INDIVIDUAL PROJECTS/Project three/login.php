<?php
session_start();
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'db.php';
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password === $row['password']) {
            $_SESSION['user'] = $username;
            header("Location: view_orders.php");
            exit();
            
        } else {
            $message = "Invalid password.";
        }
    } else {
        $message = "User not found.";
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Website - Login</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
    <header>
        <h1>Login</h1>
    </header>
    <nav>
        <a href="index.php">Home</a>
        <a href="about.php">About Us</a>
        <a href="menu.php">Menu</a>
        <a href="order.php">Order</a>
        <a href="gallery.php">Gallery</a>
        <a href="contact.php">Contact Us</a>
    </nav>
    <main>
        <h2>Admin Login</h2>
        <?php if($message): ?>
            <p style="color: red;"><?php echo $message; ?></p>
        <?php endif; ?>
        <form method="post">
            <label>Username:</label>
            <input type="text" name="username" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2023 Our Hotel. All rights reserved.</p>
    </footer>
</body>
</html>