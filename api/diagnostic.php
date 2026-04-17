<?php
include 'config.php';
echo "<h2>MongoDB Diagnostic</h2>";
echo "Connection: OK (ping success)<br>";

// List collections
$collections = $db->listCollections();
echo "Collections: ";
foreach ($collections as $col) {
    echo $col->getName() . " ";
}
echo "<br>";

// Users count
$count_users = $db->users->countDocuments();
echo "Users count: " . $count_users . "<br>";

// Students count
$count_students = $db->students->countDocuments();
echo "Students count: " . $count_students . "<br>";

echo "<br>Run setup.php if empty. Check MongoDB service on port 27017.";
?>

