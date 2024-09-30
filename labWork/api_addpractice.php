
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
        <div class="Admin">
            <a href="category_html.php">List of all category</a>
        </div>
        <div class="cart">
            <a href="cart_html.php">Cart</a>
        </div>
    </header>

    <!-- Second Header (Menu and Other Links) -->
    <header class="header-bottom">
        <button class="menu-button" onclick="toggleMenu()">☰ Menu</button>
        <div class="user-info">
            <?php
            session_start();
            if (isset($_SESSION['username'])) {
                echo '<span>Welcome, ' . htmlspecialchars($_SESSION['username']) . '</span>';
            } else {
                echo '<a href="category_html.php">Login</a>';
            }
            ?>
        </div>
        <a href="#">Today's Deals</a>
        <a href="#">Customer Service</a>
        <li><a href="#" id="region-link">Region</a></li>
        <li><a href="#" id="weather-link">Weather</a></li>
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
            <li><a href="#" id="region-link">Region</a></li>
                <div id="map-container" style="display:none;">
                    <div id="map"></div>
                </div>

            <li><a href="#">Order History</a></li>
            <li><a href="#">Settings</a></li>
        </ul>
        <!-- Logout Button (Visible only if logged in) -->
        <?php if (isset($_SESSION['username'])): ?>
            <form action="logout.php" method="post">
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        <?php endif; ?>
    </div>

    <section class="products-section">
        <h2>Display Products</h2>
        <div class="products-container">
            <?php include 'product_action_handle.php'; ?>
        </div>
    </section>
    


    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 MyStore. All rights reserved.</p>
    </footer>

    <script>
        function toggleMenu() {
            var menu = document.getElementById("menu");
            menu.classList.toggle("show");
        }
    </script>


    <!-- place JS script -->
     <script src="apitest.js"></script>

</body>
</html>
