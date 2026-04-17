<?php
include 'config.php';
echo "MongoDB setup...\n";

try {
    // Create unique index for users.username
    $db->users->createIndex(['username' => 1], ['unique' => true]);
    echo "Users unique index created\n";

    // Create indexes for students
    $db->students->createIndex(['name' => 1]);
    echo "Students indexes created\n";

    // Insert default admin if not exists
    $default_user = 'admin';
    $default_pass = password_hash('admin123', PASSWORD_DEFAULT);
    $existing = $db->users->findOne(['username' => $default_user]);
    if (!$existing) {
        $db->users->insertOne([
            'username' => $default_user,
            'password' => $default_pass,
            'created_at' => new MongoDB\BSON\UTCDateTime()
        ]);
        echo "Default admin created: username 'admin', password 'admin123'\n";
    } else {
        echo "Default admin already exists\n";
    }

    echo "\nSetup complete! Run php setup.php once. Login: admin/admin123\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>

