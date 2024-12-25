<?php
function loadEnv($file) {
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Ignore comments
        if (strpos(trim($line), '#') === 0) continue;
        
        // Split the line into key and value
        list($key, $value) = explode('=', $line, 2);
        // Remove any spaces around the key and value
        putenv(trim($key) . '=' . trim($value));
    }
}

loadEnv('../.env');

$host = 'localhost';
$dbname = 'portfolio_management';
$username = 'root';
$password = getenv('DB_PASS');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
