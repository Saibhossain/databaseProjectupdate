<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Store</title>
    <link rel="stylesheet" href="/saibsCode/style/product_style.css">
</head>
<body>
    <!-- First Header (Top Section) -->
    <header class="header-top">
        <div class="logo">MyStore</div>
        <div class="search-bar">
            <input type="text" placeholder="Search for products...">
            <button>Search</button>
        </div>
        <div class="user">
            <?php
            session_start();
            if (isset($_SESSION['username'])) {
                echo '<span>Welcome, ' . htmlspecialchars($_SESSION['username']) . '</span>';
            } else {
                echo '<a href="login.html">Hello,SignIn</a>';
            }
            ?>
        </div>
        <div class="cart">
            <a href="cart_html.php">Cart</a>
        </div>
    </header>

    <!-- Second Header (Menu and Other Links) -->
    <header class="header-bottom">
        <button class="menu-button" onclick="toggleMenu()">☰ Menu</button>
        <a href="#">Today's Deals</a>
        <a href="#">Customer Service</a>
        <a href="#">Region</a>
        <li><a href="#" id="weather-link">Today's Weather</a></li>
    </header>

    <!-- Menu Overlay -->
    <div class="menu" id="menu">
        <span class="close-btn" onclick="toggleMenu()">X</span>
        <ul>
            <?php
            if (isset($_SESSION['username'])) {
                echo '<li><a>Hello, ' . htmlspecialchars($_SESSION['username']) . '</a></li>';
            } else {
                echo '<li><a href="login.html">User Login</a></li>';
            }
            ?>
            <li><a href="#">Today's Deals</a></li>
            <li><a href="#">Customer Service</a></li>
            <li><a href="#">Region</a></li>
            <li><a href="#">Weather</a></li>
            <li><a href="#">Order History</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="product_html.php">View All product</a></li>
        </ul>
          <!-- Logout Button (Visible only if logged in) -->
          <?php if (isset($_SESSION['username'])): ?>
            <form action="action/logout.php" method="post">
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        <?php endif; ?>
    </div>

    <!-- Main Content Section -->
    <section class="products-section">
        <h2>List of All Category</h2>
        <div class="products-container">
            <?php include '../saibsCode/action/category_action_handle.php'; ?>
        </div>
    </section>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 MyStore. All rights reserved.</p>
    </footer>

    
   <!-- place JS script -->
   <script src="/saibsCode/script/product_html.js"></script>

</body>
</html>
