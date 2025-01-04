<?php
require "../../controllers/adminController.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../../../public/css/admin.css">
</head>
<body>
    <div class="top-bar">
        <h1>Admin Dashboard</h1>
        <a href="../logout.php" class="btn logout-btn">Logout</a>
    </div>


    <!-- Users Table -->
    <h2>Manage Users</h2>
    <table>
        <tr>
            <th>Username</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['username']); ?></td>
            <td><?= htmlspecialchars($user['role']); ?></td>
            <td>
                <form action="../../controllers/adminController.php" method="POST">
                    <input type="hidden" name="user_id" value="<?= $user['id']; ?>">
                    <select name="new_role">
                        <option value="photographer" <?= $user['role'] == 'photographer' ? 'selected' : ''; ?>>Photographer</option>
                        <option value="guest" <?= $user['role'] == 'guest' ? 'selected' : ''; ?>>Guest</option>
                        <option value="editor" <?= $user['role'] == 'editor' ? 'selected' : ''; ?>>Editor</option>
                    </select>
                    <button type="submit" name="change_role">Update</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- Pending Photos Table -->
    <h2>Pending Photos</h2>
    <div class="photos">
        <?php foreach ($pending_photos as $photo): ?>
            <div class="photo-card">
                <img src="../../../public/<?= htmlspecialchars($photo['image_path']); ?>" alt="<?= htmlspecialchars($photo['title']); ?>" width="250" height="200">
                <p>Title: <?= htmlspecialchars($photo['title']); ?></p>
                <p>Description: <?= htmlspecialchars($photo['description']); ?></p>
                <p>Uploaded by: <?= htmlspecialchars($photo['username']); ?></p>
                <form action="../../controllers/adminController.php" method="POST">
                    <input type="hidden" name="photo_id" value="<?= $photo['id']; ?>">
                    <button type="submit" name="approve_photo">Approve</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
