<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'staff' && $_SESSION['role'] !== 'admin')) {
    header("Location: login.php");
    exit();
}
include 'includes/db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Dashboard | Meat Mart</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .staff-container { padding: 30px; background: #0b0c10; min-height: 100vh; color: white; }
        .grid-system { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 20px; }
        .card { background: #1a1a1a; padding: 25px; border-radius: 12px; border-left: 5px solid #2d5a27; margin-bottom: 20px; }
        h2 { color: #2d5a27; margin-bottom: 20px; border-bottom: 1px solid #333; padding-bottom: 10px; }
        input, select { width: 100%; padding: 12px; margin: 10px 0; background: #222; border: 1px solid #444; color: white; border-radius: 5px; }
        .action-btn { background: #2d5a27; color: white; padding: 12px; border: none; width: 100%; cursor: pointer; font-weight: bold; border-radius: 5px; }
        .action-btn:hover { background: #1e3d1a; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #333; }
        th { color: #2d5a27; }
        .status-low { color: #ff4d4d; font-weight: bold; }
        .status-ok { color: #2ecc71; }
        .edit-link { color: #3498db; text-decoration: none; margin-right: 15px; font-weight: bold; }
        .delete-link { color: #ff4d4d; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

<div class="staff-container">
    <header style="display:flex; justify-content:space-between; align-items:center;">
        <h1><i class="fa fa-users-cog"></i> Staff Control Panel</h1>
        <div>
            <span>User: <strong><?php echo $_SESSION['name']; ?></strong></span>
            <a href="logout.php" style="color:red; margin-left:15px; text-decoration:none;"><i class="fa fa-sign-out-alt"></i> Logout</a>
        </div>
    </header>

    <div class="grid-system">
        <div class="card">
            <h2><i class="fa fa-boxes"></i> Update Stock</h2>
            <form action="process_stock.php" method="POST">
                <select name="product_id" required>
                    <option value="">Select Product...</option>
                    <?php
                    $p_res = mysqli_query($conn, "SELECT id, name FROM products");
                    while($p_row = mysqli_fetch_assoc($p_res)) {
                        echo "<option value='".$p_row['id']."'>".$p_row['name']."</option>";
                    }
                    ?>
                </select>
                <input type="number" name="quantity" placeholder="Quantity to Add (kg)" required>
                <button type="submit" class="action-btn">UPDATE STOCK</button>
            </form>
        </div>

        <div class="card">
            <h2><i class="fa fa-plus-circle"></i> Add New Product</h2>
            <form action="add_product_process.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="p_name" placeholder="Product Name" required>
                <select name="p_category" required>
                    <option value="Chicken">Chicken</option>
                    <option value="Beef">Beef</option>
                    <option value="Mutton">Mutton</option>
                    <option value="Fish">Fish</option>
                    <option value="Exotic Meat">Exotic Meat</option>
                    <option value="Spices">Spices</option>
                </select>
                <input type="number" step="0.01" name="p_price" placeholder="Price per kg (Rs.)" required>
                <input type="number" name="p_stock" placeholder="Initial Stock Quantity" required>
                <input type="file" name="p_image" accept="image/*" required>
                <button type="submit" class="action-btn">UPLOAD PRODUCT</button>
            </form>
        </div>
    </div>

    <div class="card" style="border-left-color: #3498db;">
        <h2><i class="fa fa-list"></i> Current Inventory</h2>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $inv_res = mysqli_query($conn, "SELECT * FROM products WHERE is_deleted = 0 ORDER BY category ASC");
                while($row = mysqli_fetch_assoc($inv_res)) {
                    $stock = $row['stock_qty'];
                    $status = ($stock <= 10) ? "<span class='status-low'>LOW STOCK</span>" : "<span class='status-ok'>In Stock</span>";
                    ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td><?php echo $stock; ?> kg</td>
                        <td>Rs. <?php echo number_format($row['price'], 2); ?></td>
                        <td><?php echo $status; ?></td>
                        <td>
                            <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="edit-link">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <a href="delete_product.php?id=<?php echo $row['id']; ?>" 
                               class="delete-link" 
                               onclick="return confirm('Are you sure you want to delete this product?');">
                                <i class="fa fa-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="card" style="margin-top:30px; border-left-color: #f39c12;">
        <h2><i class="fa fa-shopping-basket"></i> Pending Orders</h2>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $orders_res = mysqli_query($conn, "SELECT * FROM orders WHERE status = 'pending'");
                if(mysqli_num_rows($orders_res) > 0) {
                    while($order_row = mysqli_fetch_assoc($orders_res)) {
                        echo "<tr>
                                <td>#{$order_row['id']}</td>
                                <td>Rs. ".number_format($order_row['total_amount'], 2)."</td>
                                <td><span style='color:#f39c12;'>Pending</span></td>
                                <td>
                                    <a href='update_order_status.php?id={$order_row['id']}&status=completed' 
                                       class='action-btn' style='padding: 5px 10px; font-size: 12px; text-decoration:none;'>
                                       Mark as Completed
                                    </a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No pending orders.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<div style="margin-bottom: 20px; text-align: right;">
    <a href="trash_bin.php" style="background: #444; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-size: 14px;">
        <i class="fa fa-trash"></i> View Trash Bin
    </a>
</div>

</body>
</html>