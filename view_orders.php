<?php
session_start();
include 'includes/db_connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$query = "SELECT orders.id, users.name, orders.total_amount, orders.status, orders.order_date 
          FROM orders 
          JOIN users ON orders.user_id = users.id 
          ORDER BY orders.order_date DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Orders | Admin</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .orders-table { width: 90%; margin: 50px auto; border-collapse: collapse; background: #1a1a1a; color: white; }
        .orders-table th, .orders-table td { padding: 15px; border: 1px solid #333; text-align: center; }
        .orders-table th { background: #2d5a27; }
        .status-pending { color: orange; font-weight: bold; }
        .status-completed { color: lightgreen; font-weight: bold; }
        .btn-complete { background: #2d5a27; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; font-size: 12px; }
    </style>
</head>
<body>

<div style="padding: 20px;">
    <h2 style="text-align: center; color: #2d5a27;">Customer Orders Management</h2>
    <table class="orders-table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Total Price</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td>#<?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td>Rs. <?php echo number_format($row['total_amount'], 2); ?></td>
                <td><?php echo $row['order_date']; ?></td>
                <td>
                    <span class="<?php echo ($row['status'] == 'pending') ? 'status-pending' : 'status-completed'; ?>">
                        <?php echo strtoupper($row['status']); ?>
                    </span>
                </td>
                <td>
                    <?php if($row['status'] == 'pending') { ?>
                        <a href="update_order.php?id=<?php echo $row['id']; ?>" class="btn-complete">Mark as Completed</a>
                    <?php } else { echo "No Actions"; } ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <div style="text-align: center;">
        <a href="admin_dashboard.php" style="color: #2d5a27;">Back to Dashboard</a>
    </div>
</div>

</body>
</html>