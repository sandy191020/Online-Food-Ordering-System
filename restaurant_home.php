<?php
session_start();

if (!isset($_SESSION['restaurant_id'])) {
    header("Location: resturant.html");
    exit();
}

if (!isset($_SESSION['users_name'])) {
    echo "Name not found in session.";
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="resto.css">
</head>
<body>
    <div class="form">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['users_name']); ?>!</h1>
        <p>You are now logged in.</p>
        <a href="logoutresturant.php">
            <button class="submit">Logout</button>
        </a>
        <a href="resto_main_site.php">
    <button class="submit">Enter Site</button>
</a>

    </div>
</body>
</html>
