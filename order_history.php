<?php
session_start();
include("connect.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../user_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM orders WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);

echo '<h2>Your Orders</h2>';
while ($order = mysqli_fetch_assoc($result)) {
    echo "<div class='order'>
            <p>Order ID: {$order['id']}</p>
            <p>Total Price: {$order['total_price']}</p>
            <p>Status: {$order['status']}</p>
          </div>";
}
?>
