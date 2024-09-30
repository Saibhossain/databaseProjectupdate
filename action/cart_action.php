<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, redirect to cart.html with a message
    header("Location: /saibsCode/cart_html.php?message=empty");
    exit();
}

// Include the connection file
include 'db_connection.php';

// Check if AJAX request has product_id and new_quantity
if (isset($_POST['product_id']) && isset($_POST['new_quantity'])) {
    $product_id = $_POST['product_id'];
    $new_quantity = $_POST['new_quantity'];
    $user_id = $_SESSION['user_id'];

    // Update the quantity in the Cart table
    $sql_update = "UPDATE Cart SET quantity = $new_quantity WHERE user_id = $user_id AND product_id = $product_id";
    
    if ($conn->query($sql_update)) {
        echo "Cart updated successfully"; // Send success response back to the AJAX
    } else {
        echo "Error updating cart";
    }

    $conn->close();
    exit(); // Prevent further execution and redirection
}

// Handle regular form submission (if any)
if (isset($_POST['product_id']) && isset($_POST['price'])) {
    $product_id = $_POST['product_id'];
    $price = $_POST['price'];
    $user_id = $_SESSION['user_id'];

    // Check if the product is already in the cart
    $sql_check = "SELECT * FROM Cart WHERE user_id = $user_id AND product_id = $product_id";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        // Update quantity if already in cart
        $sql_update = "UPDATE Cart SET quantity = quantity + 1 WHERE user_id = $user_id AND product_id = $product_id";
        $conn->query($sql_update);
    } else {
        // Insert new record
        $sql_insert = "INSERT INTO Cart (user_id, product_id, quantity, total_price) VALUES ($user_id, $product_id, 1, $price)";
        $conn->query($sql_insert);
    }

    $conn->close();
    header("Location: /saibsCode/cart_html.php");
    exit();
}
?>