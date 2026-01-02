<?php
include 'includes/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['p_id'];
    $name = mysqli_real_escape_string($conn, $_POST['p_name']);
    $category = $_POST['p_category'];
    $price = $_POST['p_price'];
    $stock = $_POST['p_stock'];

    $sql = "UPDATE products SET name='$name', category='$category', price='$price', stock_qty='$stock' WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Product Updated Successfully!'); window.location='staff_dashboard.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>