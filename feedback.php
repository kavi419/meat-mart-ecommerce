<?php include 'includes/db_connection.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Feedback | Meat Mart</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .feedback-form { max-width: 600px; margin: 50px auto; padding: 30px; background: #1a1a1a; border-radius: 10px; border: 1px solid #2d5a27; }
        .feedback-form input, .feedback-form textarea { width: 100%; padding: 12px; margin: 10px 0; background: #222; border: 1px solid #444; color: white; border-radius: 5px; }
        .submit-btn { background: #2d5a27; color: white; padding: 12px; border: none; width: 100%; cursor: pointer; border-radius: 5px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="feedback-form">
        <h2 style="color:#2d5a27; text-align:center;">Feedback & Complaints</h2>
        <form action="process_feedback.php" method="POST">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <input type="text" name="subject" placeholder="Subject (Complaint or Feedback)" required>
            <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
            <button type="submit" class="submit-btn">SEND MESSAGE</button>
        </form>
    </div>
</body>
</html>