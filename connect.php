<?php
$host = "localhost";
$username = "root"; 
$password = "";     
$database = "food_delivery"; 

$conn = mysqli_connect($host, $username, $password, $database);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
