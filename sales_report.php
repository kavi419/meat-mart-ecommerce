<?php
include 'includes/db_connection.php';
session_start();

$report_query = "SELECT COUNT(id) as total_orders, SUM(total_amount) as total_revenue FROM orders WHERE status='completed'";
$report_res = mysqli_query($conn, $report_query);
$report_data = mysqli_fetch_assoc($report_res);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sales Report | Admin</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .report-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; padding: 20px; }
        .stat-card { background: #1a1a1a; padding: 30px; text-align: center; border-radius: 10px; border-bottom: 4px solid #2d5a27; }
        .stat-card h3 { color: #888; font-size: 18px; }
        .stat-card p { font-size: 32px; font-weight: bold; color: white; }
    </style>
</head>
<body>
    <h2 style="text-align:center; margin-top:30px; color:#2d5a27;">Business Sales Overview</h2>
    
    <div class="report-grid">
        <div class="stat-card">
            <h3>TOTAL COMPLETED ORDERS</h3>
            <p><?php echo $report_data['total_orders']; ?></p>
        </div>
        <div class="stat-card">
            <h3>TOTAL REVENUE (INCOME)</h3>
            <p>Rs. <?php echo number_format($report_data['total_revenue'], 2); ?></p>
        </div>
    </div>

    <div style="padding:20px;">
        <h3 style="color:#2d5a27;">Recent Successful Transactions</h3>
        <table style="width:100%; color:white; border-collapse: collapse; background:#1a1a1a;">
            <tr style="background:#2d5a27;">
                <th style="padding:10px;">Order ID</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
            <?php
            $recent_sales = mysqli_query($conn, "SELECT id, total_amount, order_date FROM orders WHERE status='completed' ORDER BY order_date DESC LIMIT 10");
            while($sale = mysqli_fetch_assoc($recent_sales)) {
                echo "<tr style='border-bottom:1px solid #333; text-align:center;'>
                        <td style='padding:10px;'>#{$sale['id']}</td>
                        <td>Rs. ".number_format($sale['total_amount'], 2)."</td>
                        <td>{$sale['order_date']}</td>
                      </tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>