<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Available Restaurants</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        /* Add flip-specific styling inside here (inline for demo) */

        body {
    font-family: 'Poppins', sans-serif;
}
.main-title {
    font-family: 'Poppins', sans-serif;
}

.card-front h3,
.card-back h4 {
    font-family: 'Poppins', sans-serif;
}

        .card {
            width: 300px;
            height: 380px;
            perspective: 1000px;
        }

        .card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            transition: transform 0.8s;
            transform-style: preserve-3d;
        }

        .card:hover .card-inner {
            transform: rotateY(180deg);
        }

        .card-front, .card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }

        .card-front {
            background: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .card-front img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .card-front h3 {
            margin: 10px 0;
            color: #111827;
            font-size: 1.3rem;
        }

        .card-back {
            background: #f3f4f6;
            transform: rotateY(180deg);
            padding: 20px;
            overflow-y: auto;
        }

        .card-back h4 {
            margin-bottom: 15px;
            color: #111827;
        }

        .menu-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .menu-item input {
            width: 45px;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 6px;
            margin-left: 10px;
        }

        .menu-item button {
            background: #3b82f6;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
            margin-left: 10px;
        }

        .menu-item button:hover {
            background: #2563eb;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            padding: 20px 40px;
        }

        .footer-buttons {
            text-align: center;
            margin: 50px 0;
        }

        .btn {
            text-decoration: none;
            margin: 0 15px;
            padding: 12px 20px;
            background-color: #1f2937;
            color: white;
            border-radius: 12px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: #111827;
            transform: scale(1.05);
        }

        .logout {
            background-color: #ef4444;
        }

        .logout:hover {
            background-color: #dc2626;
        }

        .main-title {
            text-align: center;
            font-size: 2.8rem;
            margin: 40px 0 10px;
            color: #1f2937;
            font-weight: bold;
        }
        .card-back {
    overflow-y: auto;
    max-height: 400px; /* or more, depending on your layout */
}

    </style>
</head>
<body>

<h2 class="main-title">🍽️ Available Restaurants</h2>

<div class="card-container">
<?php
$res_q = mysqli_query($conn, "SELECT * FROM restaurant_signup");
$placeholders = ['default1.jpg', 'default2.webp', 'default3.jpeg','default4.jpeg','default5.jpeg','default6.avif'];

while ($res = mysqli_fetch_assoc($res_q)) {
    $res_id = $res['id'];
    $resname = $res['resname'];

    $img_q = mysqli_query($conn, "SELECT image FROM menu WHERE restaurant_id = $res_id AND image IS NOT NULL AND image != '' ORDER BY RAND() LIMIT 1");
    $img_row = mysqli_fetch_assoc($img_q);

    if ($img_row && file_exists("uploads/" . $img_row['image'])) {
        $imagePath = "uploads/" . $img_row['image'];
    } else {
        $imagePath = "uploads/" . $placeholders[array_rand($placeholders)];
    }

    echo "<div class='card'>
            <div class='card-inner'>
                <div class='card-front'>
                    <img src='$imagePath' alt='Restaurant'>
                    <h3>$resname</h3>
                </div>
                <div class='card-back'>
                    <h4>Menu</h4>";

    $menu_q = mysqli_query($conn, "SELECT * FROM menu WHERE restaurant_id = $res_id");
    while ($item = mysqli_fetch_assoc($menu_q)) {
        $iid = $item['id'];
        $itemName = htmlspecialchars($item['item_name'], ENT_QUOTES);
        $itemPrice = $item['price'];
        echo "<div class='menu-item'>
                <span>$itemName - ₹$itemPrice</span>
                <input type='number' id='qty_$iid' value='1' min='1'>
                <button onclick='addToCart($iid, $res_id, \"qty_$iid\")'>Add</button>
              </div>";
    }

    echo "</div></div></div>";
}
?>
</div>

<div class="footer-buttons">
    <a href="checkout.php" class="btn">🛒 Checkout</a>
    <a href="view_orders.php" class="btn">📜 Order History</a>
    <a href="logout.php" class="btn logout">🚪 Logout</a>
</div>

<script>
function addToCart(itemId, restaurantId, qtyId) {
    const qty = document.getElementById(qtyId).value;
    fetch('add_to_cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `item_id=${itemId}&restaurant_id=${restaurantId}&quantity=${qty}`
    })
    .then(res => res.text())
    .then(msg => alert(msg));
}
</script>

</body>
</html>
