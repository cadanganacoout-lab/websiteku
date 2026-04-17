<?php
namespace App;

use MongoDB\Client;
use Exception;

class Database {
    private $collection;

    public function __construct() {
        // Gunakan URI MongoDB Atlas Anda
        $uri = 'mongodb+srv://users:182009@xanzzviell.jrgddl1.mongodb.net/?appName=XanzzViell';
        
        try {
            $client = new Client($uri);
            // Ganti 'nama_database' dan 'nama_koleksi' sesuai kebutuhan
            $this->collection = $client->selectDatabase('kelass')->selectCollection('users');
        } catch (Exception $e) {
            die("Koneksi Database Gagal: " . $e->getMessage());
        }
    }

    public function getCollection() {
        return $this->collection;
    }
}
