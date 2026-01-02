<?php
session_start();
include 'includes/db_connection.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $cart_empty = true;
} else {
    $cart_empty = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Cart | Meat Mart</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .cart-container { padding: 50px; max-width: 1000px; margin: auto; }
        table { width: 100%; border-collapse: collapse; background: #1a1a1a; border-radius: 10px; overflow: hidden; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #333; }
        th { background: #2d5a27; color: white; }
        .total-box { text-align: right; margin-top: 20px; font-size: 20px; color: #2d5a27; }
        .checkout-btn { background: #2d5a27; color: white; padding: 12px 25px; border: none; border-radius: 5px; cursor: pointer; float: right; margin-top: 10px; text-decoration: none; }
    </style>
</head>
<body>

<div class="cart-container">
    <h1><i class="fa fa-shopping-basket"></i> Your Shopping Cart</h1>
    
    <?php if ($cart_empty): ?>
        <p>Your cart is empty. <a href="index.php" style="color:#2d5a27;">Go Shopping</a></p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity (kg)</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $grand_total = 0;
                foreach ($_SESSION['cart'] as $id => $qty) {
                    $result = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
                    $product = mysqli_fetch_assoc($result);
                    $subtotal = $product['price'] * $qty;
                    $grand_total += $subtotal;
                    ?>
                    <tr>
                        <td><?php echo $product['name']; ?></td>
                        <td>Rs. <?php echo number_format($product['price'], 2); ?></td>
                        <td><?php echo $qty; ?></td>
                        <td>Rs. <?php echo number_format($subtotal, 2); ?></td>
                        <td><a href="manage_cart.php?action=remove&id=<?php echo $id; ?>" style="color:red;"><i class="fa fa-trash"></i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="total-box">
            <strong>Grand Total: Rs. <?php echo number_format($grand_total, 2); ?></strong>
        </div>
        
        <a href="checkout.php" class="checkout-btn">Proceed to Checkout <i class="fa fa-arrow-right"></i></a>
    <?php endif; ?>
</div>

</body>
</html>