<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'includes/db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | Meat Mart</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .admin-container { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background: #000; padding: 20px; border-right: 2px solid #2d5a27; }
        .sidebar h2 { color: #2d5a27; font-size: 20px; text-align: center; }
        .sidebar ul { list-style: none; padding: 0; margin-top: 30px; }
        .sidebar ul li { padding: 15px; border-bottom: 1px solid #333; }
        .sidebar ul li a { color: white; text-decoration: none; display: block; }
        .sidebar ul li:hover { background: #2d5a27; }
        
        .main-content { flex: 1; padding: 30px; background: #0b0c10; }
        .stats-grid { display: flex; gap: 20px; margin-bottom: 30px; }
        .stat-card { background: #1a1a1a; padding: 20px; flex: 1; border-radius: 10px; border-bottom: 4px solid #2d5a27; text-align: center; }
        .stat-card h3 { color: #888; font-size: 14px; }
        .stat-card p { font-size: 24px; font-weight: bold; margin-top: 10px; }
        
        .chart-container { background: #1a1a1a; padding: 20px; border-radius: 10px; }
    </style>
</head>
<body>

<div style="margin-bottom: 20px; text-align: right;">
    <a href="trash_bin.php" style="background: #444; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-size: 14px;">
        <i class="fa fa-trash"></i> View Trash Bin
    </a>
</div>

<div class="admin-container">
    <div class="sidebar">
        <h2><i class="fa fa-user-shield"></i> ADMIN PANEL</h2>
        <ul>
            <li><a href="#"><i class="fa fa-chart-line"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-box"></i> Manage Stocks</a></li>
            <li><a href="#"><i class="fa fa-users"></i> Customers</a></li>
            <li><a href="view_orders.php"><i class="fa fa-file-invoice"></i> View Orders</a></li>
            <li><a href="sales_report.php">Sales Report</a></li>
            <li><a href="logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <header style="display:flex; justify-content:space-between; margin-bottom:30px;">
            <h1>Welcome Back, Admin!</h1>
            <p><?php echo date('D, d M Y'); ?></p>
        </header>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>TOTAL SALES</h3>
                <p>Rs. 45,000.00</p>
            </div>
            <div class="stat-card">
                <h3>NEW ORDERS</h3>
                <p>12</p>
            </div>
            <div class="stat-card">
                <h3>PENDING STOCKS</h3>
                <p>05</p>
            </div>
        </div>

        <div class="chart-container">
            <h3>Weekly Sales Analysis</h3>
            <canvas id="salesChart"></canvas>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Sales (Rs.)',
                data: [5000, 7000, 4000, 9000, 12000, 15000, 10000],
                borderColor: '#2d5a27',
                backgroundColor: 'rgba(45, 90, 39, 0.2)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true, ticks: { color: 'white' } },
                x: { ticks: { color: 'white' } }
            },
            plugins: { legend: { labels: { color: 'white' } } }
        }
    });
</script>

</body>
</html>