<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart items
$cart_items = [];
$total = 0;
$query = "SELECT c.*, m.item_name, m.price, m.restaurant_id FROM cart c 
          JOIN menu m ON c.item_id = m.id 
          WHERE c.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $row['subtotal'] = $row['price'] * $row['quantity'];
    $total += $row['subtotal'];
    $cart_items[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Place Order
    $insert_order = $conn->prepare("INSERT INTO orders (user_id, total_amount, order_date) VALUES (?, ?, NOW())");
    if (!$insert_order) {
        die("❌ Order prepare failed: " . $conn->error);
    }
    $insert_order->bind_param("id", $user_id, $total);
    $insert_order->execute();
    $order_id = $insert_order->insert_id;

    // Order details
    $details_stmt = $conn->prepare("INSERT INTO order_details (order_id, item_id, quantity, price) VALUES (?, ?, ?, ?)");
    if (!$details_stmt) {
        die("❌ Order details prepare failed: " . $conn->error);
    }

    foreach ($cart_items as $item) {
        $details_stmt->bind_param("iiid", $order_id, $item['item_id'], $item['quantity'], $item['price']);
        $details_stmt->execute();

        // Link to restaurant
        $resto = $item['restaurant_id'];
        $link_stmt = $conn->prepare("INSERT INTO restaurant_orders (order_id, restaurant_id) VALUES (?, ?)");
        if ($link_stmt) {
            $link_stmt->bind_param("ii", $order_id, $resto);
            $link_stmt->execute();
        } else {
            error_log("❌ Restaurant link insert failed: " . $conn->error);
        }
    }

    // Clear cart
    $clear_stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $clear_stmt->bind_param("i", $user_id);
    $clear_stmt->execute();

    echo "<script>alert('✅ Order Placed Successfully!'); window.location='view_orders.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f7f9fc;
            color: #333;
            padding: 20px;
            text-align: center;
        }

        h2, h3, h4 {
            margin-bottom: 15px;
            color: #2c3e50;
        }

        table {
            margin: 0 auto;
            border-collapse: collapse;
            width: 80%;
            max-width: 700px;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #3498db;
            color: white;
        }

        tr:last-child td {
            border-bottom: none;
        }

        img {
            margin-top: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        button {
            background-color: #27ae60;
            color: white;
            font-size: 16px;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #219150;
        }
    </style>
</head>
<body>

<h2>Your Cart</h2>

<?php if (count($cart_items) > 0): ?>
    <table>
        <tr><th>Item</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr>
        <?php foreach ($cart_items as $item): ?>
        <tr>
            <td><?= htmlspecialchars($item['item_name']) ?></td>
            <td><?= $item['quantity'] ?></td>
            <td>₹<?= $item['price'] ?></td>
            <td>₹<?= $item['subtotal'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h3>Total: ₹<?= $total ?></h3>
    <h4>Scan QR to Pay:</h4>
    <img src="qr.jpg" alt="QR Code" style="width:300px; height:auto;"><br>

    <form method="POST">
        <button type="submit">Confirm Order</button>
    </form>
<?php else: ?>
    <p>Your cart is empty!</p>
<?php endif; ?>

</body>
</html>
