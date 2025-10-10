<?php
include("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $owner_fname=$_POST['owner_fname'];
    $owner_lname = $_POST['owner_lname'];
    $licence_number = $_POST['licence_number'];
    $bussines_arena=$_POST['bussines_arena'];
    $phone_number = $_POST['phone_number'];
    $resname=$_POST['resname'];
    $serving=$_POST['serving'];
    $address = $_POST['address'];
    $state=$_POST['state'];
    $code=$_POST['code'];
    $phno=$_POST['phno'];
    $email = $_POST['email'];
    $password = $_POST['password']; // plain password input
    $confirm_password=$_POST['confirm_password'];
    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }
    

    // ✅ Hash the password here
    $password = password_hash($password, PASSWORD_DEFAULT);


   
    
    $query = "INSERT INTO restaurant_signup (owner_fname,owner_lname,licence_number,bussines_arena,phone_number,resname,serving,address,state,code,
    phno,email,password) 
              VALUES ('$owner_fname', '$owner_lname', '$licence_number','$bussines_arena','$phone_number','$resname','$serving', '$address','$state','$code', '$phno', '$email', '$password')";
    

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Restaurant registered successfully'); window.location.href='resturant.html';</script>";
    } else {
        echo "❌ Error: " . mysqli_error($conn);
    }
}
?>
