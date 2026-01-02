<?php
session_start();
include 'includes/db_connection.php';

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'staff' && $_SESSION['role'] !== 'admin')) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['restore_id'])) {
    $r_id = $_GET['restore_id'];
    mysqli_query($conn, "UPDATE products SET is_deleted = 0 WHERE id = '$r_id'");
    echo "<script>alert('Product Restored Successfully!'); window.location='trash_bin.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Trash Bin | Meat Mart</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .trash-container { padding: 30px; background: #0b0c10; min-height: 100vh; color: white; }
        .card { background: #1a1a1a; padding: 25px; border-radius: 12px; border-left: 5px solid #e74c3c; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #333; }
        .restore-btn { color: #2ecc71; text-decoration: none; font-weight: bold; }
        .back-btn { color: #888; text-decoration: none; margin-bottom: 20px; display: inline-block; }
    </style>
</head>
<body>
    <div class="trash-container">
        <a href="staff_dashboard.php" class="back-btn"><i class="fa fa-arrow-left"></i> Back to Dashboard</a>
        
        <div class="card">
            <h2><i class="fa fa-trash-alt"></i> Trash Bin (Hidden Products)</h2>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $trash_res = mysqli_query($conn, "SELECT * FROM products WHERE is_deleted = 1");
                    if (mysqli_num_rows($trash_res) > 0) {
                        while($row = mysqli_fetch_assoc($trash_res)) {
                            echo "<tr>
                                    <td>{$row['name']}</td>
                                    <td>{$row['category']}</td>
                                    <td>Rs. ".number_format($row['price'], 2)."</td>
                                    <td>
                                        <a href='trash_bin.php?restore_id={$row['id']}' class='restore-btn'>
                                            <i class='fa fa-undo'></i> Restore
                                        </a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' style='text-align:center;'>Trash bin is empty.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>