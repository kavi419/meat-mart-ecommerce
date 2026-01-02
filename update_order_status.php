<?php
session_start();
include 'includes/db_connection.php';

if (isset($_GET['id']) && isset($_GET['status'])) {
    $order_id = $_GET['id'];
    $new_status = $_GET['status'];

    $sql = "UPDATE orders SET status = '$new_status' WHERE id = '$order_id'";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Order Updated!'); window.location='staff_dashboard.php';</script>";
    }
}
?>