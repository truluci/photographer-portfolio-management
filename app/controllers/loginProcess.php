<?php
if (!empty($_POST)) {
    // Extract form data
    $user_username = $_POST['username'] ?? '';
    $user_password = $_POST['password'] ?? '';
    
    // Include the database connection
    require "../../config/database.php";
    
    // Validate form data
    if (empty($user_username) || empty($user_password)) {
        header("Location: ../../public/login.php?error=All fields are required.");
        exit;
    }
    
    try {
        // Fetch the user from the database
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $pdo->prepare($sql); // Use `$pdo` for the database connection
        $stmt->execute([$user_username]);
        $user = $stmt->fetch();
        
        // Verify the password
        if ($user && password_verify($user_password, $user['password'])) {
            // Start the session
            session_start();
            
            // Store the user data in the session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            // Redirect to the user role's dashboard
            header("Location: ../../app/views/{$user['role']}/{$user['role']}.php");
            exit;
        } else {
            // Redirect to the login page on failure
            header("Location: ../../public/login.php?error=Invalid username or password.");
            exit;
        }
    } catch (Exception $e) {
        // Handle any errors
        header("Location: ../../public/login.php?error=" . urlencode("Error: " . $e->getMessage()));
        exit;
    }
}
?>