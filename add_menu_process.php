<?php
session_start();
include 'connect.php'; // make sure db.php is correct

if (!isset($_SESSION['user_id'])) {
    header("Location: restaurant_home.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_name = $_POST['item_name'];
    $price = $_POST['price'];
    $restaurant_id = $_SESSION['user_id'];

    // Handle image
    $image_name = $_FILES['item_image']['name'];
    $image_tmp = $_FILES['item_image']['tmp_name'];
    $upload_dir = "uploads/";

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $target_file = $upload_dir . basename($image_name);

    if (move_uploaded_file($image_tmp, $target_file)) {
        // Insert into DB
        $sql = "INSERT INTO menu (restaurant_id, item_name, price, image_path) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isds", $restaurant_id, $item_name, $price, $target_file);
        
        if ($stmt->execute()) {
            echo "✅ Item added successfully! <a href='resto_main_site.php'>Back to Dashboard</a>";
        } else {
            echo "❌ Error adding item: " . $conn->error;
        }
    } else {
        echo "❌ Image upload failed.";
    }
} else {
    echo "❌ Form not submitted correctly.";
}
?>
