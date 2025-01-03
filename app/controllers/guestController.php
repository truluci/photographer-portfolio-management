<?php
session_start();

// Check if the user is logged in and has the 'guest' role
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'guest') {
//     header("Location: login.php?error=Unauthorized access.");
//     exit;
// }

// get currnent directory
$dir = __DIR__;
require_once $dir . "/../../config/database.php";

try {
    // Fetch approved photos from the database
    $sql = "SELECT p.*, u.username FROM portfolios p 
            JOIN users u ON p.user_id = u.id
            WHERE p.is_approved = 1";
    $stmt = $pdo->query($sql);
    $photos = $stmt->fetchAll();
} catch (Exception $e) {
    die("Error fetching photos: " . $e->getMessage());
}
?>