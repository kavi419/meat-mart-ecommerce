<?php
include 'includes/db_connection.php';

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$type = isset($_GET['type']) ? $_GET['type'] : 'all';

if (!empty($search)) {

    $sql = "SELECT * FROM products WHERE name LIKE '%$search%' OR category LIKE '%$search%'";
    $display_title = "Search Results for: " . htmlspecialchars($search);
} elseif ($type != 'all') {

    $sql = "SELECT * FROM products WHERE category='$type'";
    $display_title = $type . " Selection";
} else {

    $sql = "SELECT * FROM products";
    $display_title = "All Products";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $display_title; ?> - Meat Mart</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .product-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px; padding: 50px; }
        .product-card { background: #1a1a1a; border-radius: 15px; overflow: hidden; border: 1px solid #2d5a27; transition: 0.3s; text-align: center; padding-bottom: 20px; }
        .product-card:hover { transform: scale(1.05); box-shadow: 0 10px 20px rgba(45, 90, 39, 0.3); }
        .product-card img { width: 100%; height: 200px; object-fit: cover; }
        .product-card h3 { margin: 15px 0; color: white; }
        .product-card p { color: #2d5a27; font-weight: bold; font-size: 1.2rem; }
        .buy-btn { background: #2d5a27; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-top: 10px; display: inline-block; text-decoration: none; font-size: 14px; transition: 0.3s; }
        .buy-btn:hover { background: #1e3d1a; }
        .category-header { text-align: center; padding: 40px; background: #000; border-bottom: 2px solid #2d5a27; text-transform: uppercase; }
        .no-results { text-align: center; width: 100%; padding: 50px; color: #888; }
    </style>
</head>
<body>

<div class="category-header">
    <h1><?php echo $display_title; ?></h1>
</div>

<div class="product-grid">
    <?php
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {

            $stock_label = ($row['stock_qty'] <= 0) ? "<span style='color:red;'>Out of Stock</span>" : "Rs. " . number_format($row['price'], 2) . " /kg";
            
            echo '<div class="product-card">
                    <img src="images/'.$row['image'].'" onerror="this.src=\'images/default-meat.jpg\'">
                    <h3>'.$row['name'].'</h3>
                    <p>'.$stock_label.'</p>';
                    
            if ($row['stock_qty'] > 0) {
                echo '<a href="manage_cart.php?action=add&id='.$row['id'].'" class="buy-btn">Add to Cart</a>';
            }
            
            echo '</div>';
        }
    } else {
        
        echo '<div class="no-results">
                <i class="fas fa-search-minus" style="font-size: 50px; margin-bottom: 20px;"></i>
                <p>No products found matching your search or category.</p>
                <a href="category.php" style="color: #2d5a27; text-decoration: none;">View All Products</a>
              </div>';
    }
    ?>
</div>

</body>
</html>