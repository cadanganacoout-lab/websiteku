<?php
include 'config.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // 1. Cek apakah password dan konfirmasi password sama
    if ($password !== $confirm_password) {
        echo "<script>alert('Konfirmasi password tidak sesuai!'); window.location='register.php';</script>";
        exit();
    }

    // 2. Cek apakah username sudah ada di database
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "<script>alert('Username sudah digunakan, cari yang lain!'); window.location='register.php';</script>";
    } else {
        // 3. Enkripsi password sebelum disimpan (Keamanan Penting!)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // 4. Masukkan ke database
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password);
        $insert = $stmt->execute();
        $stmt->close();

        if ($insert) {
            echo "<script>alert('Registrasi Berhasil! Silahkan Login.'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Gagal mendaftar, coba lagi.'); window.location='register.php';</script>";
        }
    }
}
?>