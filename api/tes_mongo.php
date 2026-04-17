<?php
// 1. Pastikan path ini benar menuju folder vendor Anda
require 'vendor/autoload.php'; 

try {
    // 2. Coba buat koneksi
    $client = new MongoDB\Client("mongodb://localhost:27017");
    
    // 3. Tes perintah sederhana (list database)
    $databases = $client->listDatabases();

    echo "Koneksi Berhasil! Berikut daftar database Anda:<br>";
    foreach ($databases as $db) {
        echo "- " . $db->getName() . "<br>";
    }
} catch (Exception $e) {
    echo "Koneksi Gagal: " . $e->getMessage();
}
