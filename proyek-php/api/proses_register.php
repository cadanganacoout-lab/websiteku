<?php
include 'config.php';

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // 1. Cek apakah password dan konfirmasi password sama
    if ($password !== $confirm_password) {
        echo "<script>alert('Konfirmasi password tidak sesuai!'); window.location='register.php';</script>";
        exit();
    }

    // 2. Cek apakah username sudah ada di database
    $check_user = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
    if (mysqli_num_rows($check_user) > 0) {
        echo "<script>alert('Username sudah digunakan, cari yang lain!'); window.location='register.php';</script>";
    } else {
        // 3. Enkripsi password sebelum disimpan (Keamanan Penting!)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // 4. Masukkan ke database
        $insert = mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')");

        if ($insert) {
            echo "<script>alert('Registrasi Berhasil! Silahkan Login.'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Gagal mendaftar, coba lagi.'); window.location='register.php';</script>";
        }
    }
}
?>