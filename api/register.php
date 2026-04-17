<?php
session_start();
include 'config.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - X RPL 1</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .register-box { width: 300px; margin: 80px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
        .register-box input { width: 100%; margin-bottom: 10px; padding: 8px; box-sizing: border-box; }
        .register-box button { width: 100%; padding: 10px; background: #28a745; color: white; border: none; cursor: pointer; }
        .register-box p { font-size: 14px; text-align: center; }
    </style>
</head>
<body>
    <div class="register-box">
        <h2>Daftar Akun</h2>
        <form action="proses_register.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required>
            <button type="submit" name="register">Daftar Sekarang</button>
        </form>
        <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </div>
</body>
</html>
