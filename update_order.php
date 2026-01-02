<?php
include 'includes/db_connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "UPDATE orders SET status='completed' WHERE id=$id";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: view_orders.php");
    }
}
?>