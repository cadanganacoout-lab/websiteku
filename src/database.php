<?php
require __DIR__ . '/../vendor/autoload.php';

use MongoDB\Client;

class Database {
    private $collection;

    public function __construct() {
$uri = $_ENV['MONGODB_URI'] ?? 'mongodb://localhost:27017';

        try {
            $client = new Client($uri);
            $this->collection = $client->selectDatabase('kelas')->selectCollection('users');
        } catch (Exception $e) {
            die("Koneksi Database Gagal: " . $e->getMessage());
        }
    }

    public function getCollection() {
        return $this->collection;
    }
}

// mongodb+srv://users:182009@xanzzviell.jrgddli.mongodb.net/?appName=XanzzViell