<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['email']) && isset($_POST['pass'])) {
    $conn = mysqli_connect("localhost", "root", "", "food_delivery");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $email = $_POST['email'];
    $password = $_POST['pass'];

    $stmt = $conn->prepare("SELECT * FROM restaurant_signup WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['restaurant_id'] = $row['id'];
            $_SESSION['users_name'] = $row['owner_fname'] . ' ' . $row['owner_lname'];
            header("Location: restaurant_home.php");
            exit();
        } else {
            echo "❌ Incorrect password.";
        }
    } else {
        echo "❌ Email not found.";
    }

} else {
    header("Location: restaurant_login.html");
    exit();
}
?>
