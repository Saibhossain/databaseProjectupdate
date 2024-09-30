<?php
// Start the session
session_start();

// Include the connection file
include 'db_connection.php';

// Fetch products from the database
$sql = "SELECT product_id, product_name, price, img_url FROM Products";
$result = $conn->query($sql);

// Check if products exist
if ($result->num_rows > 0) {
    // Loop through each product and display it
    while ($row = $result->fetch_assoc()) {
        echo '<div class="product-card">';
        echo '<h3>' . $row['product_name'] . '</h3><br>';
        echo '<img src="' . $row['img_url'] . '" alt="Product Image">';
        echo '<p>৳' . number_format($row['price'], 2) . '</p>';
        
        // Form to handle the Add to Cart action
        echo '<form method="post" action="action/cart_action.php">';
        echo '<input type="hidden" name="product_id" value="' . $row['product_id'] . '">';
        echo '<input type="hidden" name="price" value="' . $row['price'] . '">';
        echo '<button type="submit">Add to Cart</button>';
        echo '</form>';
        
        // Link to redirect to ProductView.html (or ProductView.php)
        echo '<a href="productView_html.php?product_id=' . $row['product_id'] . '">View Product</a>';
        
        echo '</div>';
    }
} else {
    echo "<p>No products found!</p>";
}

// Close the connection
$conn->close();
?>
