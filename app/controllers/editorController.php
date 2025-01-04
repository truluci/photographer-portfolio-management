<?php
session_start();

// Ensure user is an editor
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'editor') {
    header("Location: ../../public/login.php?error=Unauthorized access.");
    exit;
}

$dir = __DIR__;
require_once $dir . "/../../config/database.php";

// Handle Photo Update
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_photo'])) {
    $photo_id = $_POST['photo_id'];
    $new_title = trim($_POST['new_title']);
    $new_description = trim($_POST['new_description']);

    try {
        $sql = "UPDATE portfolios SET title = ?, description = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$new_title, $new_description, $photo_id]);

        header("Location: ../../app/views/editor/editor.php?success=Photo updated successfully.");
        exit;
    } catch (Exception $e) {
        die("Error updating photo: " . $e->getMessage());
    }
}

// Handle Photo Deletion
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_photo'])) {
    $photo_id = $_POST['photo_id'];

    try {
        // Get file path before deleting
        $sql = "SELECT image_path FROM portfolios WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$photo_id]);
        $photo = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($photo) {
            // Delete file from server
            $file_path = "../../public/" . $photo['image_path'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }

            // Delete from database
            $sql = "DELETE FROM portfolios WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$photo_id]);

            header("Location: ../../app/views/editor/editor.php?success=Photo deleted successfully.");
            exit;
        }
    } catch (Exception $e) {
        die("Error deleting photo: " . $e->getMessage());
    }
}

// Fetch all photos for editors
try {
    $sql = "SELECT p.*, u.username FROM portfolios p 
            JOIN users u ON p.user_id = u.id";
    $stmt = $pdo->query($sql);
    $photos = $stmt->fetchAll();
} catch (Exception $e) {
    die("Error fetching photos: " . $e->getMessage());
}
?>
