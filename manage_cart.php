<?php
session_start();

if (isset($_GET['action']) && $_GET['action'] == "add") {
    $id = $_GET['id'];

    
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]++;
    } else {
        $_SESSION['cart'][$id] = 1;
    }

    echo "<script>alert('Product added to cart!'); window.location='category.php';</script>";
}

if (isset($_GET['action']) && $_GET['action'] == "remove") {
    $id = $_GET['id'];
    unset($_SESSION['cart'][$id]); 
    header("Location: cart.php");
}
?>