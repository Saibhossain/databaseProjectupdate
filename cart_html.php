<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="saibsCode/style/cart_style.css">
</head>
<body>
    <h2>Your Cart</h2>
    
    <?php
    // Check for any messages in the URL
    if (isset($_GET['message']) && $_GET['message'] == 'empty') {
        echo "<p>Cart is empty. Please log in to add items.</p>";
    } else {
        // Display cart items from the database if the user is logged in
        include 'action/db_connection.php';
        session_start();
        
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $sql_cart = "SELECT Products.product_id, Products.product_name, Cart.quantity, Cart.total_price
             FROM Cart 
             JOIN Products ON Cart.product_id = Products.product_id 
             WHERE Cart.user_id = $user_id";
                         
            $result_cart = $conn->query($sql_cart);
            
            if ($result_cart->num_rows > 0) {
                while ($row = $result_cart->fetch_assoc()) {
                    $product_id = $row['product_id'];
                    $quantity = $row['quantity'];
                    $price = $row['total_price'];
                    $total_price = $quantity * $price;

                    echo "<div class='cart-item'>";
                    echo "<h3>" . htmlspecialchars($row['product_name']) ."</h3>";

                    // Quantity controls with correct JavaScript call
                    // Ensuring $product_id is an integer and $price is properly formatted as a float
                    $product_id = intval($row['product_id']);
                    $price = floatval($row['total_price']);
                    $total_price = $quantity * $price;

                    echo "<div class='quantity-controls'>";
                    echo "<button onclick='updateQuantity($product_id, $price, -1)'>-</button>";
                    echo "<span id='quantity-$product_id'>$quantity</span>";
                    echo "<button onclick='updateQuantity($product_id, $price, 1)'>+</button>";
                    echo "</div>";

                    // Display the total price for this product
                    echo "<p>Total Price: <span id='total-price-$product_id'>" . number_format($total_price, 2) . "</span> taka</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>Your cart is empty.</p>";
            }
        } else {
            echo "<p>Please log in to view your cart.</p>";
        }
        
        $conn->close();
    }
    ?>
    <script src="/saibsCode/script/cart.js"></script>
</body>
</html>
