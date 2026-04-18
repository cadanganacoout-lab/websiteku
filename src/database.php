<?php
require __DIR__ . '/../vendor/autoload.php';

use MongoDB\Client;

class Database {
    private $collection;

    public function __construct() {
        $uri = getenv('MONGODB_URI');

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