<?php
require_once __DIR__ . '/../vendor/autoload.php';

use MongoDB\Client;

try {
    // 1. Koneksi ke MongoDB Atlas
    $uri = 'mongodb+srv://users:182009@xanzzviell.jrgddli.mongodb.net/?appName=XanzzViell';
    $client = new Client($uri);
    
    // 2. Pilih Database dan Koleksi (Sesuaikan nama 'kelass' dan 'students')
    $collection = $client->selectDatabase('data_user')->selectCollection('students');

    // Kita ganti "../asset_foto" menjadi "../asset/asset_foto"
    $result = $collection->updateMany(
        ['photo' => ['$regex' => '^\.\./asset_foto']], 
        [
            ['$set' => [
                'photo' => [
                    '$replaceOne' => [
                        'input' => '$photo', 
                        'find' => '../asset_foto', 
                        'replacement' => '../asset/asset_foto'
                    ]
                ]
            ]]
        ]
    );

    echo "Berhasil memperbaiki " . $result->getModifiedCount() . " jalur foto.";

} catch (Exception $e) {
    echo "Terjadi kesalahan: " . $e->getMessage();
}
