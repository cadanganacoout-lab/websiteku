<?php
include 'config.php';
echo "<h2>DB Diagnostic</h2>";
echo "Connection: " . ($conn ? "OK" : "FAILED") . "<br>";

if ($conn) {
    $dbs = mysqli_query($conn, "SHOW DATABASES LIKE 'tbs_xrpl1'");
    echo "DB tbs_xrpl1 exists: " . (mysqli_num_rows($dbs) > 0 ? "YES" : "NO") . "<br>";
    
    mysqli_select_db($conn, 'tbs_xrpl1');
    $tables = mysqli_query($conn, "SHOW TABLES LIKE 'users'");
    echo "users table: " . (mysqli_num_rows($tables) > 0 ? "YES" : "NO") . "<br>";
    
    $users = mysqli_query($conn, "SELECT COUNT(*) as count FROM users");
    $u = mysqli_fetch_assoc($users);
    echo "Users count: " . $u['count'] . "<br>";
    
    mysqli_close($conn);
}

echo "<br>Run setup.php if tables missing. Check MySQL service.";
?>

