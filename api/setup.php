<?php
include 'config.php';
echo "Setting up database...\n\n";

// Create users table if not exists
$conn->query("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Create students table
$conn->query("CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    role VARCHAR(50),
    address TEXT,
    skills JSON,
    hobby TEXT,
    photo VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Insert default admin if not exists
$default_user = 'admin';
$default_pass = password_hash('admin123', PASSWORD_DEFAULT);
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $default_user);
$stmt->execute();
if ($stmt->get_result()->num_rows == 0) {
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $default_user, $default_pass);
    $stmt->execute();
    echo "Default admin created: username 'admin', password 'admin123'\n";
}

$stmt->close();
echo "Setup complete! Run this once. Delete after. Login with admin/admin123\n";
$conn->close();
?>

