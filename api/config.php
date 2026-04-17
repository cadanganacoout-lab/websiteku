<?php

require_once __DIR__ . '/../vendor/autoload.php';


use MongoDB\Driver\ServerApi;

$uri = 'mongodb+srv://users:182009@xanzzviell.jrgddli.mongodb.net/?appName=XanzzViell';

// Set the version of the Stable API on the client
// Ganti baris 11 sampai 14 dengan ini:
$client = new MongoDB\Client($uri);

$db = $client->selectDatabase('data_user');
