<?php
session_start();
include 'includes/db_connection.php';

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'staff' && $_SESSION['role'] !== 'admin')) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['p_name']);
    $category = mysqli_real_escape_string($conn, $_POST['p_category']);
    $price = $_POST['p_price'];
    $stock = $_POST['p_stock'];

    $target_dir = "images/";

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_extension = pathinfo($_FILES["p_image"]["name"], PATHINFO_EXTENSION);
    $file_name = time() . "_" . uniqid() . "." . $file_extension; 
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["p_image"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO products (name, category, price, stock_qty, image) 
                VALUES ('$name', '$category', '$price', '$stock', '$file_name')";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Product Added Successfully!'); window.location='staff_dashboard.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Error uploading image. Check folder permissions.'); window.location='staff_dashboard.php';</script>";
    }
}
?>