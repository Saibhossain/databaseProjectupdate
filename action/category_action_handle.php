<?php
// Include the connection file
include 'db_connection.php';

// Fetch products from the database
$sql = "SELECT category_name FROM Categorys";
$result = $conn->query($sql);

// Check if products exist
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<a href="product_html.php">';
        echo '<div class="product-card">';
        echo '<h3>' . $row['category_name'] . '</h3>';
      
        echo '</div>';
    }
} else {
    echo "<p>No products found!</p>";
}


$conn->close();
?>
