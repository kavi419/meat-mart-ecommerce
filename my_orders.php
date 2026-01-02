<?php
session_start();
include 'includes/db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY order_date DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Orders | Meat Mart</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .container { max-width: 900px; margin: 50px auto; padding: 20px; background: #1a1a1a; border-radius: 10px; }
        .order-card { background: #222; padding: 20px; margin-bottom: 15px; border-left: 5px solid #2d5a27; border-radius: 5px; }
        .status-badge { padding: 5px 10px; border-radius: 15px; font-size: 12px; font-weight: bold; text-transform: uppercase; }
        .pending { background: #f39c12; color: #000; }
        .completed { background: #2d5a27; color: #fff; }
        .order-meta { display: flex; justify-content: space-between; margin-bottom: 10px; color: #888; }
    </style>
</head>
<body>

<div class="container">
    <h2 style="color: #2d5a27; text-align: center;"><i class="fa fa-history"></i> My Order History</h2>
    
    <?php if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) { ?>
            <div class="order-card">
                <div class="order-meta">
                    <span>Order ID: <strong>#<?php echo $row['id']; ?></strong></span>
                    <span>Date: <?php echo $row['order_date']; ?></span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="font-size: 18px;">Total Amount: <strong>Rs. <?php echo number_format($row['total_amount'], 2); ?></strong></p>
                    </div>
                    <div>
                        <span class="status-badge <?php echo $row['status']; ?>">
                            <?php echo $row['status']; ?>
                        </span>
                    </div>
                </div>
                <hr style="border: 0.5px solid #333; margin: 15px 0;">
                <a href="order_details.php?id=<?php echo $row['id']; ?>" style="color: #2d5a27; text-decoration: none; font-size: 14px;">View Items <i class="fa fa-chevron-right"></i></a>
            </div>
        <?php } 
    } else {
        echo "<p style='text-align:center;'>You haven't placed any orders yet.</p>";
    } ?>
    
    <div style="text-align: center; margin-top: 20px;">
        <a href="index.php" style="color: white; text-decoration: none;"> <i class="fa fa-arrow-left"></i> Back to Shopping</a>
    </div>
</div>

</body>
</html>