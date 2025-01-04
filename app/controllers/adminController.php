<?php
session_start();

// Ensure user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../public/login.php?error=Unauthorized access.");
    exit;
}

$dir = __DIR__;
require_once $dir . "/../../config/database.php";

// Handle User Role Update
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['change_role'])) {
    $user_id = $_POST['user_id'];
    $new_role = $_POST['new_role'];

    try {
        $sql = "UPDATE users SET role = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$new_role, $user_id]);

        header("Location: ../../app/views/admin/admin.php");
        exit;
    } catch (Exception $e) {
        die("Error updating user role: " . $e->getMessage());
    }
}

// Handle Photo Approval
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['approve_photo'])) {
    $photo_id = $_POST['photo_id'];

    try {
        $sql = "UPDATE portfolios SET is_approved = 1 WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$photo_id]);

        header("Location: ../../app/views/admin/admin.php");
        exit;
    } catch (Exception $e) {
        die("Error approving photo: " . $e->getMessage());
    }
}

// Fetch all users
try {
    $sql = "SELECT id, username, role FROM users";
    $stmt = $pdo->query($sql);
    $users = $stmt->fetchAll();
} catch (Exception $e) {
    die("Error fetching users: " . $e->getMessage());
}

// Fetch all pending photos
try {
    $sql = "SELECT p.*, u.username FROM portfolios p 
            JOIN users u ON p.user_id = u.id
            WHERE p.is_approved = 0";
    $stmt = $pdo->query($sql);
    $pending_photos = $stmt->fetchAll();
} catch (Exception $e) {
    die("Error fetching pending photos: " . $e->getMessage());
}
?>
