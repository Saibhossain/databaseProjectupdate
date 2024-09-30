<?php
include 'db_connection.php';

if (isset($_GET['product_id'])) {
    $product_id = intval($_GET['product_id']);

    // Fetch product details based on product_id
    $sql = "SELECT * FROM Products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    // Check if products exist
    if ($result->num_rows > 0) {
        // Loop through each product and display it
        while ($row = $result->fetch_assoc()) {
            echo '<div class="product-card">';
            echo '<h3>' . $row['product_name'] . '</h3><br>';
            echo '<img src="' . $row['img_url'] . '" alt="Product Image">';
            echo '<h3>' . $row['description'] . '</h3><br>';
            echo '<p>$' . number_format($row['price'], 2) . '</p>';
            
            // Form to handle the Add to Cart action
            echo '<form method="post" action="action/cart_action.php">';
            echo '<input type="hidden" name="product_id" value="' . $row['product_id'] . '">';
            echo '<input type="hidden" name="price" value="' . $row['price'] . '">';
            echo '<button type="submit">Add to Cart</button>';
            echo '</form>';
            
            echo '</div>';
        }

        // Fetch product reviews based on product_id
        $review_sql = "SELECT * FROM Review_product WHERE product_id = ?";
        $review_stmt = $conn->prepare($review_sql);
        $review_stmt->bind_param("i", $product_id);
        $review_stmt->execute();
        $review_result = $review_stmt->get_result();

        if ($review_result->num_rows > 0) {
            echo '<div class="reviews-section">';
            echo '<h3>Customer Reviews:</h3>';
            while ($review = $review_result->fetch_assoc()) {
                echo '<div class="review-item">';
                echo '<h4>' . $review['review_text'] . '</h4>';
                echo '<p>Rating: ' . str_repeat('★', $review['rating']) . str_repeat('☆', 5 - $review['rating']) . '</p>';
                echo '<p>time: ' . $review['review_date'] . '</p>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<p>No reviews available for this product.</p>';
        }
    } else {
        echo "<p>No products found!</p>";
    }

} else {
    echo "<p>Invalid product ID!</p>";
    exit();
}
?>