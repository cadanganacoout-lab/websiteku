<?php
include 'config.php';

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validasi input kosong
    if (empty($username) || empty($password) || empty($confirm_password)) {
        echo "<script>alert('Semua field harus diisi!'); window.location='register.php';</script>";
        exit();
    }
    
    // Validasi panjang password minimal 6 karakter
    if (strlen($password) < 6) {
        echo "<script>alert('Password minimal 6 karakter!'); window.location='register.php';</script>";
        exit();
    }

    // Cek apakah password dan konfirmasi password sama
    if ($password !== $confirm_password) {
        echo "<script>alert('Konfirmasi password tidak sesuai!'); window.location='register.php';</script>";
        exit();
    }

    try {
        // Cek apakah username sudah ada
        $existing = $db->users->findOne(['username' => $username]);
        if ($existing) {
            echo "<script>alert('Username sudah digunakan, cari yang lain!'); window.location='register.php';</script>";
            exit();
        }

        // Enkripsi password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user
        $result = $db->users->insertOne([
            'username' => $username,
            'password' => $hashed_password,
'role' => 'user',
            'created_at' => new MongoDB\BSON\UTCDateTime()
        ]);

        if ($result->getInsertedCount() > 0) {
            echo "<script>alert('Registrasi Berhasil! Silahkan Login.'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Gagal mendaftar!'); window.location='register.php';</script>";
        }
    } catch (Exception $e) {
        echo "<script>alert('Error: " . addslashes($e->getMessage()) . "'); window.location='register.php';</script>";
    }
}
?>

