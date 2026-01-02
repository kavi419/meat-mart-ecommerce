<?php
session_start();
include 'includes/db_connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id'");
    $product = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product | Meat Mart</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .edit-container { max-width: 500px; margin: 50px auto; background: #1a1a1a; padding: 30px; border-radius: 10px; color: white; border-top: 5px solid #3498db; }
        input, select { width: 100%; padding: 12px; margin: 10px 0; background: #222; border: 1px solid #444; color: white; }
        .update-btn { background: #3498db; color: white; padding: 12px; border: none; width: 100%; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>
    <div class="edit-container">
        <h2>Edit Product: <?php echo $product['name']; ?></h2>
        <form action="update_product_process.php" method="POST">
            <input type="hidden" name="p_id" value="<?php echo $product['id']; ?>">
            
            <label>Product Name:</label>
            <input type="text" name="p_name" value="<?php echo $product['name']; ?>" required>
            
            <label>Category:</label>
            <select name="p_category">
                <option value="Chicken" <?php if($product['category'] == 'Chicken') echo 'selected'; ?>>Chicken</option>
                <option value="Beef" <?php if($product['category'] == 'Beef') echo 'selected'; ?>>Beef</option>
                <option value="Mutton" <?php if($product['category'] == 'Mutton') echo 'selected'; ?>>Mutton</option>
            </select>
            
            <label>Price (Rs.):</label>
            <input type="number" step="0.01" name="p_price" value="<?php echo $product['price']; ?>" required>
            
            <label>Stock (kg):</label>
            <input type="number" name="p_stock" value="<?php echo $product['stock_qty']; ?>" required>
            
            <button type="submit" class="update-btn">SAVE CHANGES</button>
            <a href="staff_dashboard.php" style="display:block; text-align:center; color:#888; margin-top:15px; text-decoration:none;">Cancel</a>
        </form>
    </div>
</body>
</html>