<?php
    require "../../controllers/photographerController.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photographer Dashboard</title>
    <link rel="stylesheet" href="../../../public/css/photographer.css">
</head>
<body>
    <!-- Top bar with title and post button -->
    <div class="top-bar">
        <h1>Photos</h1>
        <div class="buttons">
            <button class="btn post-btn" onclick="toggleUploadForm()">📸 Post a Photo</button>
            <a href="../logout.php" class="btn logout-btn">Logout</a>
        </div>
    </div>

    <!-- Upload Form (Initially Hidden) -->
    <div class="upload-form hidden">
        <h2>Upload a New Photo</h2>
        <?php if (!empty($_GET['error'])): ?>
            <p class="error"><?= htmlspecialchars($_GET['error']) ?></p>
        <?php endif; ?>
        <?php if (!empty($_GET['success'])): ?>
            <p class="success"><?= htmlspecialchars($_GET['success']) ?></p>
        <?php endif; ?>

        <form action="../../controllers/photographerController.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="photo">Upload Image:</label>
                <input type="file" id="photo" name="photo" accept="image/*" required>
            </div>
            <button type="submit" class="btn">Upload</button>
        </form>
    </div>
    
    <!-- Search Bar -->
    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Search photos by title or description..." />
    </div>

    <!-- Display All Approved Photos -->
    <div class="photos">
        <?php foreach ($all_photos as $photo): ?>
            <div>
                <img src="../../../public/<?php echo htmlspecialchars($photo['image_path']); ?>" alt="<?php echo htmlspecialchars($photo['title']); ?>" width="250" height="200">
                <p>Title: <?php echo htmlspecialchars($photo['title']); ?></p>
                <p>Description: <?php echo htmlspecialchars($photo['description']); ?></p>
                <p>Uploaded by: <?php echo htmlspecialchars($photo['username']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Display All Pending Photos -->
    <div class="pending-photos hidden">
        <h2>Pending Photos</h2>
        <?php foreach ($pending_photos as $photo): ?>
            <div>
                <img src="../../../public/<?php echo htmlspecialchars($photo['image_path']); ?>" alt="<?php echo htmlspecialchars($photo['title']); ?>" width="250" height="200">
                <p>Title: <?php echo htmlspecialchars($photo['title']); ?></p>
                <p>Description: <?php echo htmlspecialchars($photo['description']); ?></p>
                <p>Uploaded by: <?php echo htmlspecialchars($photo['username']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        function toggleUploadForm() {
            document.querySelector(".upload-form").classList.toggle("hidden");
            document.querySelector(".pending-photos").classList.toggle("hidden");
        }
    </script>
</body>
<script src="../../../public/js/search.js" defer></script>
</html>
