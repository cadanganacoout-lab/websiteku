<?php

// Cek apakah vendor ada di luar folder api (untuk lokal dan vercel)
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
} else {
    // Jika vercel meletakkan vendor di tempat berbeda saat runtime
    require_once __DIR__ . '/vendor/autoload.php';
}


use MongoDB\Driver\ServerApi;

$uri = 'mongodb+srv://users:182009@xanzzviell.jrgddli.mongodb.net/?appName=XanzzViell';

// Set the version of the Stable API on the client
// Ganti baris 11 sampai 14 dengan ini:
$client = new MongoDB\Client($uri);

$db = $client->selectDatabase('data_user');
