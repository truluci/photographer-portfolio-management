<?php
    require "../../controllers/guestController.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest - View Photos</title>
</head>
<body>
    <h1>Approved Photos by Our Precious Photopgraphers</h1>
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
</html>