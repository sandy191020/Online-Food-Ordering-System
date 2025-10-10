<?php
session_start();

// Check if form was submitted(we're using request method for it) 
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['email']) && isset($_POST['pass'])) {

    $conn = mysqli_connect("localhost", "root", "", "food_delivery");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $email = $_POST['email'];
    $password = $_POST['pass'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
    
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id']; // or 'user_id' depending on your table
            $_SESSION['users_name'] = $row['full_name'] . ' ' . $row['last_name'];
            header("Location: user_home.php");
            exit();
        } else {
            echo "❌ Incorrect password.";
        }
    }
     else {
        echo "❌ Email not found.";
    }

} else {
    echo "❌ Form not submitted correctly.";
}
?>