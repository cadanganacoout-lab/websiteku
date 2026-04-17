<?php
session_start();
include 'config.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - X RPL 1</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .login-box { width: 300px; margin: 100px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
        .login-box input { width: 100%; margin-bottom: 10px; padding: 8px; }
        .login-box button { width: 100%; padding: 10px; background: #333; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Login Admin</h2>
        <form action="auth.php" method="POST">
            <?php if (isset($_SESSION['login_error']) && !empty($_SESSION['login_error'])) { ?>
                <div style="color: red; margin-bottom: 10px;"><?php echo $_SESSION['login_error']; unset($_SESSION['login_error']); ?></div>
            <?php } ?>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Masuk</button>
            <p>tidak punya akun? <a href="register.php">Daftar di sini</a></p>
        </form>
    </div>
</body>
</html>
