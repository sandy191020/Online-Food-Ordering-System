<?php
session_start();
include("connect.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../user_login.php");
    exit();
}

$res_id = $_GET['res_id'];
// Query to fetch the selected restaurant's menu
$menu_result = mysqli_query($conn, "SELECT * FROM menu WHERE restaurant_id = $res_id");

echo '<h2>Your Cart</h2>';
$total = 0;
echo '<form method="POST" action="checkout.php">';
while ($menu = mysqli_fetch_assoc($menu_result)) {
    $item_id = $menu['id'];
    $item_name = $menu['item_name'];
    $price = $menu['price'];
    echo "
    <div class='cart-item'>
        <p>$item_name - $price</p>
        <input type='number' name='item_qty[$item_id]' value='1' min='1'>
    </div>";
    $total += $price;
}
echo "<h3>Total: $total</h3>";
echo "<button type='submit'>Proceed to Checkout</button>";
echo '</form>';
?>
