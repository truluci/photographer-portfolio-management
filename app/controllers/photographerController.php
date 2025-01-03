<?php
session_start();

// Ensure the user is logged in as a photographer
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'photographer') {
    header("Location: ../../public/login.php?error=Unauthorized access.");
    exit;
}

$photographer_id = $_SESSION['user_id'];

$dir = __DIR__;
require_once $dir . "/../../config/database.php";

// Handle Photo Upload
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
        header("Location: ../../public/photographer.php?error=File upload failed.");
        exit;
    }

    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($_FILES['photo']['type'], $allowed_types)) {
        header("Location: ../../public/photographer.php?error=Invalid file type. Only JPG, PNG, and GIF allowed.");
        exit;
    }

    $upload_dir = "../../public/uploads/";
    $file_name = uniqid() . "_" . basename($_FILES['photo']['name']);
    $file_path = $upload_dir . $file_name;

    if (!move_uploaded_file($_FILES['photo']['tmp_name'], $file_path)) {
        header("Location: ../../public/photographer.php?error=Error moving uploaded file.");
        exit;
    }

    try {
        $sql = "INSERT INTO portfolios (user_id, title, description, image_path, is_approved) VALUES (?, ?, ?, ?, 0)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$photographer_id, $title, $description, "uploads/" . $file_name]);

        header("Location: ../../app/views/photographer/photographer.php?success=Photo uploaded successfully.");
        exit;
    } catch (Exception $e) {
        header("Location: ../../public/photographer.php?error=" . urlencode($e->getMessage()));
        exit;
    }
}

// Fetch all approved photos (like guests see)
try {
    $sql = "SELECT p.*, u.username FROM portfolios p 
            JOIN users u ON p.user_id = u.id
            WHERE p.is_approved = 1";
    $stmt = $pdo->query($sql);
    $all_photos = $stmt->fetchAll();
} catch (Exception $e) {
    die("Error fetching photos: " . $e->getMessage());
}

// fetch all pending photos
try {
    $sql = "SELECT p.*, u.username FROM portfolios p 
            JOIN users u ON p.user_id = u.id
            WHERE p.is_approved = 0";
    $stmt = $pdo->query($sql);
    $pending_photos = $stmt->fetchAll();
} catch (Exception $e) {
    die("Error fetching photos: " . $e->getMessage());
}
?>
