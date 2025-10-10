<?php
session_start();

// Check if the restaurant is logged in
if (!isset($_SESSION['restaurant_id'])) {
    header("Location: restaurant_home.php");
    exit();
}

// Define the directory where the images are stored
$image_dir = 'uploads/';
$images = glob($image_dir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

// Random image selection
$random_image = (count($images) > 0) ? $images[array_rand($images)] : 'default.jpg';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Restaurant Dashboard</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap');

        * {
            font-family: 'Nunito', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f9f9f9;
            padding: 40px;
            text-align: center;
            color: #333;
        }

        h2 {
            font-size: 32px;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        p {
            font-size: 18px;
            margin-bottom: 30px;
        }

        img {
            width: 320px;
            height: auto;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
            margin-bottom: 30px;
        }

        button {
            padding: 12px 24px;
            font-size: 16px;
            font-weight: bold;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background-color: #2c80b4;
        }

        a {
            text-decoration: none;
        }

        a + br + br {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h2>Welcome to Your Restaurant Panel</h2>
    <p>From here, you can add menu items, view orders, and more.</p>

    <img src="<?php echo $random_image; ?>" alt="Random Image">

    <br><br>
    <a href="add_menu.php"><button>Add Menu Item</button></a>
    <br><br>
    <a href="logoutresturant.php"><button>Logout</button></a>
</body>
</html>
