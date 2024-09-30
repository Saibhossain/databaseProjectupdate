<?php
require_once 'db_connection.php';


//handling user login (login.html)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'Login') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // echo "<h2>$email</h2>";   
        // echo "<h2>$password</h2>";
        // echo "<h2>$is_admin</h2>";

        // Prepare the SQL statement with placeholders
        $sql = "SELECT user_id, username, password, is_admin FROM Users WHERE email = ?";
        
    
        if ($stmt = $conn->prepare($sql)) {
        // Bind the email parameter
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();        // Store the result

        // Check if any row is returned
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $username, $hashed_password, $is_admin_db);  
            $stmt->fetch(); // Fetch the data

                // Verify the password
                if (password_verify($password, $hashed_password)) {
                    session_start();
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['username'] = $username;
                    $_SESSION['is_admin'] = $is_admin_db;
                    $_SESSION['loggedin'] = true;

                    // Check if the user is an admin
                    if ($is_admin_db == 1) {
                        echo "Login from admin";
                        header("Location: /saibsCode/productCRUD_html.php");
                        exit();
                    } else {
                        echo "Access denied: Only admins can access this page.";
                        echo "Login from user";
                        header("Location: /saibsCode/category_html.php");
                    }
                } else {
                    echo "Invalid password!";
                }
        } else {
                echo "No user found with this email!";
            }
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
        $conn->close();
}


// Handle user registration (Sign Up)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'Sign_Up') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['cpassword']; 

    // Validate passwords
    if ($password != $confirm_password) {
        echo "Passwords do not match!";
        exit();
    }

    // Check if the user already exists
    $sql = "SELECT * FROM Users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "User with this email already exists!";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    
    $sql = "INSERT INTO Users (username, email, password, is_admin) VALUES ('$name', '$email', '$hashed_password', 0)";

    if ($conn->query($sql) === TRUE) {
        echo "Account created successfully!";
        // Redirect the user to the login page
        header("Location: login.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>