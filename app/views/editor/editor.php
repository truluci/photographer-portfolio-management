<?php
require "../../controllers/editorController.php";

// Ensure the user is an editor
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'editor') {
    header("Location: ../../public/login.php?error=Unauthorized access.");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor Panel</title>
    <link rel="stylesheet" href="../../../public/css/editor.css">
</head>
<body>
    <div class="top-bar">
        <h1>Editor Dashboard</h1>
        <a href="../logout.php" class="btn logout-btn">Logout</a>
    </div>

    <h2>Manage Photos</h2>
    <div class="photos">
        <?php foreach ($photos as $photo): ?>
            <div class="photo-card">
                <img src="../../../public/<?= htmlspecialchars($photo['image_path']); ?>" alt="<?= htmlspecialchars($photo['title']); ?>" width="250" height="200">
                <p>Title: <?= htmlspecialchars($photo['title']); ?></p>
                <p>Description: <?= htmlspecialchars($photo['description']); ?></p>
                <p>Uploaded by: <?= htmlspecialchars($photo['username']); ?></p>
                
                <!-- Update Form -->
                <form action="../../controllers/editorController.php" method="POST">
                    <input type="hidden" name="photo_id" value="<?= $photo['id']; ?>">
                    <input type="text" name="new_title" placeholder="New Title" required>
                    <textarea name="new_description" placeholder="New Description" required></textarea>
                    <button type="submit" name="update_photo">Update</button>
                </form>

                <!-- Delete Form -->
                <form action="../../controllers/editorController.php" method="POST">
                    <input type="hidden" name="photo_id" value="<?= $photo['id']; ?>">
                    <button type="submit" name="delete_photo" class="delete-btn">Delete</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
