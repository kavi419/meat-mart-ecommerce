<?php
session_start();
include 'includes/db_connection.php';

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'staff' && $_SESSION['role'] !== 'admin')) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $product_id = $_POST['product_id'];
    $added_qty = $_POST['quantity'];

    if (!empty($product_id) && !empty($added_qty)) {
 
        $sql = "UPDATE products SET stock_qty = stock_qty + $added_qty WHERE id = $product_id";

        if (mysqli_query($conn, $sql)) {

            echo "<script>alert('Stock Updated Successfully!'); window.location='staff_dashboard.php';</script>";
        } else {
            echo "Error updating stock: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Please select a product and enter quantity!'); window.location='staff_dashboard.php';</script>";
    }
}
?>