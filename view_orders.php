<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch orders for the user
$query = "SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);

// Execute the query and check for errors
if ($stmt->execute()) {
    $result = $stmt->get_result();
} else {
    echo "❌ Error fetching orders: " . $stmt->error;
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Orders</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #f2f5f9;
            padding: 30px;
            color: #333;
            text-align: center;
        }

        h2 {
            margin-bottom: 25px;
            color: #2c3e50;
        }

        table {
            margin: 0 auto;
            border-collapse: collapse;
            width: 80%;
            max-width: 700px;
            background: #fff;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #3498db;
            color: white;
            font-size: 16px;
        }

        tr:last-child td {
            border-bottom: none;
        }

        td {
            font-size: 15px;
        }

        p {
            font-size: 18px;
            margin-top: 40px;
            color: #888;
        }
    </style>
</head>
<body>

<h2>Your Order History</h2>

<?php if ($result->num_rows > 0): ?>
    <table>
        <tr><th>Order #</th><th>Total Amount</th><th>Order Date</th></tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['order_id'] ?></td>
                <td>₹<?= $row['total_amount'] ?></td>
                <td><?= $row['order_date'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>You don't have any orders yet!</p>
<?php endif; ?>

</body>
</html>
