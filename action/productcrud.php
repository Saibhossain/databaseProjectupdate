<?php
session_start();
require_once 'db_connection.php';

//function for track user action
function logAdminAction($admin_id, $action_type, $action_description, $conn) {
    $action_date = date('Y-m-d H:i:s'); // Get the current date and time

    $sql = "INSERT INTO Admin_actions (admin_id, action_type, action_description, action_date) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('isss', $admin_id, $action_type, $action_description, $action_date);
    $stmt->execute();
    $stmt->close();
}





if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    //Create
    if ($action == 'create') {

        $product_name = $_POST['product_name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category_id = $_POST['category_id'];
        $is_resold = isset($_POST['is_resold']) ? 1 : 0; // Checkbox for 'is_resold'

        // Handle file upload
        $targetDir = "media/products/";
        $image = $_FILES['image']['name'];
        $targetFilePath = $targetDir . basename($image);
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Check if image file is valid
        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                // Insert into Products table
                $sql_product = "INSERT INTO Products (product_name, description, price, img_url,is_resold,category_id) VALUES (?, ?, ?, ?,?,?)";
                $stmt = $conn->prepare($sql_product);
                $stmt->bind_param('ssdsii', $product_name, $description, $price, $targetFilePath, $is_resold, $category_id );
                $stmt->execute();
                $product_id = $stmt->insert_id; // Get the last inserted product ID

                // Log the action in Admin_actions
                $admin_id = $_SESSION['user_id'];
                $action_type = "add";
                $action_description = "Added product: $product_name , product_ID: $product_id (Category ID: $category_id, Resold: $is_resold)";
                logAdminAction($admin_id, $action_type, $action_description, $conn);

                echo "Product added successfully!";
                
                $stmt->close();
                $stmt_category->close();
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Invalid file type. Only JPG, JPEG, PNG & GIF files are allowed.";
        }
                                

    } 
     // Update
    elseif ($action == 'update') {
            
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category_id = $_POST['category_id'];
        $is_resold = isset($_POST['is_resold']) ? 1 : 0;

        // Update the Products table
        $sql_product = "UPDATE Products SET product_name = ?, description = ?, price = ?
                        WHERE product_id = ?";
        $stmt = $conn->prepare($sql_product);
        $stmt->bind_param('ssdi', $product_name, $description, $price, $product_id);
        $stmt->execute();


        // Log the action in AdminActions
        $admin_id = $_SESSION['user_id'];
        $action_type = "update";
        $action_description = "Updated product: $product_name (Category ID: $category_id, Resold: $is_resold)";
        logAdminAction($admin_id, $action_type, $action_description, $conn);

        echo "Product updated successfully!";
        $stmt->close();
        $stmt_category->close();

    } //Delete
    elseif ($action == 'delete') {
        $product_id = $_POST['product_id'];

        // Delete from Products table
        $sql_product = "DELETE FROM Products WHERE product_id = ?";
        $stmt = $conn->prepare($sql_product);
        $stmt->bind_param('i', $product_id);
        $stmt->execute();

        // Log the action in AdminActions
        $admin_id = $_SESSION['user_id'];
        $action_type = "delete";
        $action_description = "Deleted product with ID: $product_id";
        logAdminAction($admin_id, $action_type, $action_description, $conn);

        echo "Product deleted successfully!";
        $stmt->close();
        $stmt_category->close();
    }

    
}


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $action = $_GET['action'];

    if($action == 'readProduct'){

        $sql = "SELECT * FROM Products";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h2>Product List</h2>";
            while ($row = $result->fetch_assoc()) {
                echo "ID: " . $row["product_id"] . " - Name: " . $row["product_name"] . " - Price: $" . $row["price"] . "<br>";
            }
            
        } else {
            echo "No products found.";
        }
    }elseif($action == 'totalProduct'){

        $sql = "SELECT COUNT(product_id) as total from products";
        $result = $conn->query($sql);
        

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        echo "<br><h2>The Number of total products is:-   " . $row['total'] . "</h2>";
        } else {
            echo "Some ERROR detected ! ";
        }
    }elseif($action == 'readIphone'){

        $sql = "SELECT * FROM products where product_name LIKE 'iphone%'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h2>Product List</h2>";
            while ($row = $result->fetch_assoc()) {
                echo "ID: " . $row["product_id"] . " --- Name: " . $row["product_name"] . " --- Date: $" . $row["created_at"] . "<br>";
            }
        } else {
            echo "No Iphone found.";
        }
    }
}

$conn->close();
?>
