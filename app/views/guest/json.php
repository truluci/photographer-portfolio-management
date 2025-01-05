<?php
    $dir = __DIR__;
    require_once $dir . "/../../../config/database.php";
    
    header("Content-Type: application/json");

    try {
        // Fetch approved photos
        $sql = "SELECT p.id, p.title, p.description, p.image_path, u.username 
                FROM portfolios p 
                JOIN users u ON p.user_id = u.id
                WHERE p.is_approved = 1";
        $stmt = $pdo->query($sql);
        $photos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($photos, JSON_PRETTY_PRINT);
    } catch (Exception $e) {
        echo json_encode(["error" => "Failed to fetch photos: " . $e->getMessage()]);
    }
?>
