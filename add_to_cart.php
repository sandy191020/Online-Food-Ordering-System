<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("❌ You must be logged in to add items to the cart.");
}

// Check if form was submitted properly
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['item_id'], $_POST['quantity'])) {
    
    // Database connection
    $conn = new mysqli("localhost", "root", "", "food_delivery");

    // Check connection
    if ($conn->connect_error) {
        die("❌ Connection failed: " . $conn->connect_error);
    }

    // Sanitize and prepare input
    $user_id = $_SESSION['user_id'];
    $item_id = intval($_POST['item_id']);
    $quantity = intval($_POST['quantity']);

    // Check if item already exists in the cart
    $checkStmt = $conn->prepare("SELECT quantity FROM cart WHERE user_id = ? AND item_id = ?");
    if (!$checkStmt) {
        die("❌ Check prepare failed: " . $conn->error);
    }
    $checkStmt->bind_param("ii", $user_id, $item_id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // If item exists, update quantity
        $updateStmt = $conn->prepare("UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND item_id = ?");
        if (!$updateStmt) {
            die("❌ Update prepare failed: " . $conn->error);
        }
        $updateStmt->bind_param("iii", $quantity, $user_id, $item_id);
        $updateStmt->execute();
        $updateStmt->close();
    } else {
        // If not exists, insert new item
        $insertStmt = $conn->prepare("INSERT INTO cart (user_id, item_id, quantity) VALUES (?, ?, ?)");
        if (!$insertStmt) {
            die("❌ Insert prepare failed: " . $conn->error);
        }
        $insertStmt->bind_param("iii", $user_id, $item_id, $quantity);
        $insertStmt->execute();
        $insertStmt->close();
    }

    $checkStmt->close();
    $conn->close();

    // Redirect or success message
     echo "<script>
            alert('✅ Item added to cart successfully!');
            window.history.back();
          </script>";
    exit(); // Optional but clean — stops further processing


} else {
    echo "❌ Invalid form submission.";
}
?>
