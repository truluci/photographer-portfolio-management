<?php
if (!empty($_POST)) {
    // Extract form data
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Include the database connection
    include "../../config/database.php";

    // Validate form data
    if (empty($username) || empty($password) || empty($confirm_password)) {
        header("Location: ../../public/register.php?error=All fields are required.");
        exit;
    }

    // fix: passwords are matching but this is not working
    if ($password !== $confirm_password) {
        header("Location: ../../public/register.php?error=Passwords do not match.");
        exit;
    }

    try {
        // Hash the password
        $hash = password_hash($password, PASSWORD_BCRYPT);

        // Insert data into the database
        $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql); // Use `$pdo` for the database connection
        $stmt->execute([$username, $hash, 'guest']);

        // Redirect to the login page on success
        header("Location: ../../public/login.php");
        exit;
    } catch (Exception $e) {
        // Handle any errors
        header("Location: ../../public/register.php?error=" . urlencode("Error: " . $e->getMessage()));
        exit;
    }
}
