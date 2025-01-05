<?php
    require "../../controllers/guestController.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest - View Photos</title>
    <link rel="stylesheet" href="../../../public/css/guest.css">
</head>
<body>
    <div class="top-bar">
        <h1>Photos</h1>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="../logout.php" class="btn logout-btn">Logout</a>
        <?php endif; ?>
    </div>

    <!-- Search Bar -->
    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Search photos by title or description..." />
    </div>

    <div class="photos">
        <?php foreach ($photos as $photo): ?>
            <div>
            <img src="../../../public/<?php echo htmlspecialchars($photo['image_path']); ?>" alt="<?php echo htmlspecialchars($photo['title']); ?>" width="250" height="200">
                <p>Title: <?php echo htmlspecialchars($photo['title']); ?></p>
                <p>Description: <?php echo htmlspecialchars($photo['description']); ?></p>
                <p>Uploaded by: <?php echo htmlspecialchars($photo['username']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
<script src="../../../public/js/search.js" defer></script>
</html>