<?php
session_start();
include 'includes/db_connection.php';

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'staff' && $_SESSION['role'] !== 'admin')) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    $res = mysqli_query($conn, "SELECT image FROM products WHERE id = '$product_id'");
    $row = mysqli_fetch_assoc($res);
    $image_path = "images/" . $row['image'];

    $sql = "UPDATE products SET is_deleted = 1 WHERE id = '$product_id'";
    
    if (mysqli_query($conn, $sql)) {

        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        echo "<script>alert('Product moved to trash and hidden from shop!'); window.location='staff_dashboard.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("Location: staff_dashboard.php");
}
?>