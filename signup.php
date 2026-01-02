<!DOCTYPE html>
<html>
<head>
    <title>Signup - Meat Mart</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body style="display:flex; justify-content:center; align-items:center; height:100vh;">
    <div style="background:#1a1a1a; padding:30px; border-radius:10px; border-top: 5px solid #2d5a27; width:350px;">
        <h2 style="text-align:center; color:#2d5a27;">Create Account</h2>
        <form action="signup_process.php" method="POST">
            <input type="text" name="name" placeholder="Full Name" required style="width:100%; margin:10px 0; padding:10px; background:#333; color:white; border:none;">
            <input type="email" name="email" placeholder="Email" required style="width:100%; margin:10px 0; padding:10px; background:#333; color:white; border:none;">
            <input type="password" name="password" placeholder="Password" required style="width:100%; margin:10px 0; padding:10px; background:#333; color:white; border:none;">
            <select name="role" style="width:100%; margin:10px 0; padding:10px; background:#333; color:white; border:none;">
                <option value="customer">Customer</option>
                <option value="staff">Staff</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit" style="width:100%; padding:10px; background:#2d5a27; color:white; border:none; cursor:pointer; font-weight:bold;">SIGN UP</button>
        </form>
        <p style="text-align:center; font-size:12px; margin-top:15px;">Already have an account? <a href="login.php" style="color:#2d5a27;">Login here</a></p>
    </div>
</body>
</html>