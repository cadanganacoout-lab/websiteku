<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "users";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>

<?php
session_start();
include 'config.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    $data = mysqli_fetch_assoc($query);

    if (mysqli_num_rows($query) > 0) {
        // Verifikasi password (asumsi menggunakan password_hash)
        if (password_verify($password, $data['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['username'] = $data['username'];
            header("Location: index.php"); // Ke halaman utama setelah sukses
        } else {
            echo "<script>alert('Password salah!'); window.location='login.php';</script>";
        }
    } else {
        echo "<script>alert('Username tidak ditemukan!'); window.location='login.php';</script>";
    }
}
?>