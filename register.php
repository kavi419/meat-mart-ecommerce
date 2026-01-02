<!DOCTYPE html>
<html>
<head>
    <title>Register | Meat Mart</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .register-box { max-width: 400px; margin: 50px auto; background: #1a1a1a; padding: 30px; border-radius: 10px; border-top: 5px solid #2d5a27; color: white; }
        input { width: 100%; padding: 12px; margin: 10px 0; background: #222; border: 1px solid #444; color: white; border-radius: 5px; }
        .reg-btn { background: #2d5a27; color: white; padding: 12px; border: none; width: 100%; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>
    <div class="register-box">
        <h2 style="text-align:center; color:#2d5a27;">Create Account</h2>
        <form action="process_register.php" method="POST">
            <label>Full Name</label>
            <input type="text" name="full_name" placeholder="John Doe" required>
            
            <label>Email Address</label>
            <input type="email" name="email" placeholder="john@example.com" required>
            
            <label>Password</label>
            <input type="password" name="password" placeholder="••••••••" required>
            
            <button type="submit" class="reg-btn">REGISTER NOW</button>
            <p style="text-align:center; margin-top:15px; font-size:14px;">
                Already have an account? <a href="login.php" style="color:#2d5a27;">Login here</a>
            </p>
        </form>
    </div>
</body>
</html>