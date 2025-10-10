<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: user_form.html");
    exit();
}

// Check if 'users_name' is set
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
    <link rel="stylesheet" href="user.css">
</head>
<body>
    <div class="form">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['users_name']); ?>!</h1>
        <p>You are now logged in.</p>
        <a href="logout.php">
            <button class="submit">Logout</button>
        </a>
        <a href="main_site.php">
    <button class="submit">Enter Site</button>
</a>

    </div>
</body>
</html>
