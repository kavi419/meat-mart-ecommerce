<?php 
session_start();
include 'includes/db_connection.php'; 

$cart_count = 0;
if(isset($_SESSION['cart'])){
    $cart_count = count($_SESSION['cart']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Meat Mart | Fresh to your doorstep</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>

        .cart-link { position: relative; color: white; text-decoration: none; font-size: 1.1rem; }
        .cart-badge {
            position: absolute;
            top: -12px;
            right: -15px;
            background: #e74c3c;
            color: white;
            font-size: 11px;
            padding: 2px 6px;
            border-radius: 50%;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="search-container">
                <form action="category.php" method="GET">
                    <input type="text" name="search" placeholder="Search for meat...">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>

            <div class="logo">MEAT<span>MART</span>.lk</div>
            <ul class="nav-links">
                <li><a href="index.php">HOME</a></li>
                <li><a href="category.php?type=Chicken">CHICKEN</a></li>
                <li><a href="category.php?type=Beef">BEEF</a></li>
                <li><a href="feedback.php">FEEDBACK</a></li>
                <li><a href="my_orders.php">MY ORDERS</a></li>
                
                <li>
                    <a href="cart.php" class="cart-link">
                        <i class="fa fa-shopping-cart"></i>
                        <?php if($cart_count > 0): ?>
                            <span class="cart-badge"><?php echo $cart_count; ?></span>
                        <?php endif; ?>
                    </a>
                </li>

                <li><a href="login.php" class="login-btn">LOGIN</a></li>
            </ul>
        </nav>
    </header>

    <div class="hero">
        <h1 style="color:#2d5a27;">Slang-infused cuts for backyard legends and kitchen savages.</h1>
    </div>

    <section class="product-section">
        <h2 class="section-title">CHICKEN PRODUCTS</h2>
        <div class="product-list">
            <?php
            $chicken_sql = "SELECT * FROM products WHERE category = 'Chicken' AND is_deleted = 0 LIMIT 5";
            $result = mysqli_query($conn, $chicken_sql);
            while($row = mysqli_fetch_assoc($result)) {
                echo '<div class="product-item">
                        <img src="images/' . $row['image'] . '" alt="' . $row['name'] . '" style="width:100%; height:150px; object-fit:cover;">
                        <h4>' . $row['name'] . '</h4>
                        <p class="price">Rs. ' . number_format($row['price'], 2) . '</p>
                        <a href="manage_cart.php?action=add&id=' . $row['id'] . '" class="buy-btn" style="text-decoration:none;">Add to Cart</a>
                      </div>';
            }
            ?>
        </div>
    </section>

    <section class="product-section">
        <h2 class="section-title">BEEF PRODUCTS</h2>
        <div class="product-list">
            <?php
            $beef_sql = "SELECT * FROM products WHERE category = 'Beef' LIMIT 5";
            $result = mysqli_query($conn, $beef_sql);
            while($row = mysqli_fetch_assoc($result)) {
                echo '<div class="product-item">
                        <img src="images/' . $row['image'] . '" alt="' . $row['name'] . '" style="width:100%; height:150px; object-fit:cover;">
                        <h4>' . $row['name'] . '</h4>
                        <p class="price">Rs. ' . number_format($row['price'], 2) . '</p>
                        <a href="manage_cart.php?action=add&id=' . $row['id'] . '" class="buy-btn" style="text-decoration:none;">Add to Cart</a>
                      </div>';
            }
            ?>
        </div>
    </section>

    <div class="categories">
        <div class="cat-card"><i class="fas fa-drumstick-bite"></i><p>CHICKEN</p></div>
        <div class="cat-card"><i class="fas fa-cow"></i><p>BEEF</p></div>
    </div>
</body>
</html>