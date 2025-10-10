<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['restaurant_id'])) {
    header("Location: resturant_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_name = $_POST['item_name'];
    $price = $_POST['price'];
    $restaurant_id = $_SESSION['restaurant_id'];

    // Handle image upload
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target);

    // Insert into DB
    $sql = "INSERT INTO menu (restaurant_id, item_name, price, image) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isds", $restaurant_id, $item_name, $price, $image);
    $stmt->execute();

    echo "<script>alert('✅ Item added successfully!'); window.location='add_menu.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Menu Item</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap');

        * {
            font-family: 'Nunito', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 50px 20px;
            color: #2c3e50;
        }

        h2 {
            font-size: 30px;
            margin-bottom: 30px;
        }

        form {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            display: flex;
            flex-direction: column;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"] {
            margin-bottom: 15px;
            padding: 10px 14px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        button {
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            background-color: #27ae60;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #1e8449;
        }

        a {
            margin-top: 20px;
            text-decoration: none;
        }

        a button {
            background-color: #e74c3c;
        }

        a button:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <h2>Add New Menu Item</h2>
    <form action="add_menu.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="item_name" placeholder="Item Name" required>
        <input type="number" name="price" step="0.01" placeholder="Price" required>
        <input type="file" name="image" accept="image/*" required>
        <button type="submit">Add Menu Item</button>
    </form>

    <a href="logoutresturant.php"><button>Logout</button></a>
</body>
</html>
