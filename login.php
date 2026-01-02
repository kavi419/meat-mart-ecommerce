<?php
session_start();
include 'includes/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['name'] = $user['name'];

        if ($user['role'] == 'admin') {
            header("Location: admin_dashboard.php");
        } elseif ($user['role'] == 'staff') {
            header("Location: staff_dashboard.php");
        } else {
            header("Location: index.php");
        }
    } else {
        echo "<script>alert('Invalid Email or Password');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Meat Mart</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body style="display:flex; justify-content:center; align-items:center; height:100vh;">
    <div style="background:#1a1a1a; padding:30px; border-radius:10px; border-left: 5px solid #2d5a27; width:350px;">
        <h2 style="text-align:center; color:#2d5a27;">Login</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required style="width:100%; margin:10px 0; padding:10px; background:#333; color:white; border:none;">
            <input type="password" name="password" placeholder="Password" required style="width:100%; margin:10px 0; padding:10px; background:#333; color:white; border:none;">
            <button type="submit" style="width:100%; padding:10px; background:#2d5a27; color:white; border:none; cursor:pointer;">LOGIN</button>
        </form>
    </div>
</body>
</html>