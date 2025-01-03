<?php
if (!empty($_POST)) {
    // Extract form data
    $user_username = $_POST['username'] ?? '';
    $user_password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Include the database connection
    require "../../config/database.php";

    // Validate form data
    if (empty($user_username) || empty($user_password) || empty($confirm_password)) {
        header("Location: ../../public/register.php?error=All fields are required.");
        exit;
    }

    if ($user_password !== $confirm_password) {
        header("Location: ../../public/register.php?error=Passwords do not match.");
        exit;
    }

    try {
        // Hash the password
        $hash = password_hash($user_password, PASSWORD_BCRYPT);

        // Insert data into the database
        // echo $user_username;
        // echo $user_password;
        // echo $confirm_password;
        $role = 'guest';
        $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql); // Use `$pdo` for the database connection
        $stmt->execute([$user_username, $hash, $role]);

        // Redirect to the login page on success
        header("Location: ../../public/login.php");
        exit;
    } catch (Exception $e) {
        // Handle any errors
        header("Location: ../../public/register.php?error=" . urlencode("Error: " . $e->getMessage()));
        exit;
    }
}
