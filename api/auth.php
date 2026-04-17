<?php
session_start();
include 'config.php';

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    if (empty($username) || empty($password)) {
        $_SESSION['login_error'] = "Username dan password harus diisi!";
        header("Location: login.php");
        exit();
    }

    try {
        $user = $db->users->findOne(['username' => $username]);
        if ($user && password_verify($password, $user['password'])) {
            $userRole = $user['role'] ?? 'user';
            if ($userRole === 'admin') {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = (string)$user['_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = 'admin';
            } else {
                $_SESSION['user_logged_in'] = true;
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $userRole;
            }
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['login_error'] = "Username atau password salah!";
            header("Location: login.php");
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['login_error'] = "Database error: " . $e->getMessage();
        header("Location: login.php");
        exit();
    }
}

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: index.php");
    exit();
}
?>

