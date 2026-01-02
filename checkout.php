<?php
session_start();
include 'includes/db_connection.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login to place an order'); window.location='login.php';</script>";
    exit();
}

if (empty($_SESSION['cart'])) {
    header("Location: index.php");
    exit();
}

$grand_total = 0;
foreach ($_SESSION['cart'] as $id => $qty) {
    $result = mysqli_query($conn, "SELECT price FROM products WHERE id = $id");
    $product = mysqli_fetch_assoc($result);
    $grand_total += ($product['price'] * $qty);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $payment_method = $_POST['payment_method'];

    $order_query = "INSERT INTO orders (user_id, total_amount, status) VALUES ('$user_id', '$grand_total', 'pending')";
    
    if (mysqli_query($conn, $order_query)) {
        $order_id = mysqli_insert_id($conn);

        foreach ($_SESSION['cart'] as $id => $qty) {
            $p_res = mysqli_query($conn, "SELECT price FROM products WHERE id = $id");
            $p_data = mysqli_fetch_assoc($p_res);
            $price = $p_data['price'];
            mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ('$order_id', '$id', '$qty', '$price')");
        }

        unset($_SESSION['cart']);
        echo "<script>alert('Order Placed Successfully via " . strtoupper($payment_method) . "!'); window.location='my_orders.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout | Meat Mart</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .checkout-box { max-width: 500px; margin: 50px auto; background: #1a1a1a; padding: 30px; border-radius: 10px; border-top: 5px solid #2d5a27; color: white; }
        input, textarea, select { width: 100%; padding: 12px; margin: 10px 0; background: #333; border: 1px solid #444; color: white; border-radius: 5px; }
        .payment-info { background: #222; padding: 15px; border-radius: 5px; margin: 15px 0; border: 1px dashed #2d5a27; }
    </style>
</head>
<body>
    <div class="checkout-box">
        <h2 style="color:#2d5a27; text-align:center;">Complete Your Order</h2>
        <p style="text-align:center;">Total Amount: <span style="font-size:1.5rem; color:#2d5a27;">Rs. <?php echo number_format($grand_total, 2); ?></span></p>
        
        <form method="POST">
            <label>Delivery Details:</label>
            <textarea name="address" placeholder="Your Full Delivery Address" rows="3" required></textarea>
            <input type="text" name="phone" placeholder="Contact Number (07X XXXXXXX)" required>
            
            <label>Payment Method:</label>
            <select name="payment_method" id="payMethod" onchange="toggleCard()" required>
                <option value="cod">Cash on Delivery (COD)</option>
                <option value="card">Credit / Debit Card (Online Simulation)</option>
            </select>

            <div id="cardSection" style="display:none;" class="payment-info">
                <p style="font-size:12px; color:#888;">Simulation Only - No real money deducted</p>
                <input type="text" placeholder="Card Number (16 Digits)">
                <div style="display:flex; gap:10px;">
                    <input type="text" placeholder="MM/YY">
                    <input type="text" placeholder="CVV">
                </div>
            </div>

            <button type="submit" class="buy-btn" style="width:100%; padding:15px; font-size:18px; margin-top:10px;">PLACE ORDER</button>
        </form>
    </div>

    <script>
        function toggleCard() {
            var method = document.getElementById('payMethod').value;
            var cardSec = document.getElementById('cardSection');
            cardSec.style.display = (method === 'card') ? 'block' : 'none';
        }
    </script>
</body>
</html>