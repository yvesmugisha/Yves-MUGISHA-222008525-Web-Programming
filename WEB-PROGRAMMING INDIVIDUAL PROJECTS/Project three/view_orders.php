<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';
$sql = "SELECT * FROM orders ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Website - View Orders</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
    <header>
        <h1>Customer Orders</h1>
    </header>
    <nav>
        <a href="index.php">Home</a>
        <a href="about.php">About Us</a>
        <a href="menu.php">Menu</a>
        <a href="order.php">Order</a>
        <a href="gallery.php">Gallery</a>
        <a href="contact.php">Contact Us</a>
        <a href="view_orders.php">View Orders</a>
        <a href="logout.php">Logout</a>
    </nav>
    <main>
        <h2>All Customer Orders</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Menu Item</th>
                <th>Address</th>
                <th>Order Date</th>
                <th>Created At</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['full_name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['menu_item']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td><?php echo $row['order_date']; ?></td>
                <td><?php echo $row['created_at']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </main>
    <footer>
        <p>&copy; 2023 Our Hotel. All rights reserved.</p>
    </footer>
</body>
</html>
<?php $conn->close(); ?>