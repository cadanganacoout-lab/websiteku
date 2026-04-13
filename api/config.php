<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "tbs_xrpl1";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$conn->set_charset("utf8mb4");


?>

