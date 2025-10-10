<?php
$fontFamily = "Arial, sans-serif"; // or any other font you want
$conn = new mysqli("localhost", "root", "", "food_delivery");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$full_name = $_POST['full_name'];
$last_name = $_POST['last_name'];
$address = $_POST['address'];
$gender = $_POST['gender'];
$state = $_POST['state'];
$city = $_POST['city'];
$pincode = $_POST['pincode'];
$email = $_POST['email'];
$phoneno = $_POST['phoneno'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

if ($password !== $confirm_password) {
    die("Passwords do not match.");
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (full_name, last_name, address, gender, state, city, pincode, email,phoneno, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssss", $full_name, $last_name, $address, $gender, $state, $city, $pincode, $email, $phoneno, $hashedPassword);

if ($stmt->execute()) {
    
    

    echo "<p style='font-family: $fontFamily;'>Registration successful. <a href='user_form.html' style='color: blue; text-decoration: underline;'>Go to Login Page</a></p>";

}

else {
    echo "<p style='font-family: $fontFamily;'>Error Email ALready Registered.</p>"; 
}

$stmt->close();
$conn->close();
?>
