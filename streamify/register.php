<?php
// Connect to database
require_once('dbconnect.php');

// Check if the submit button was clicked
if (isset($_POST['submit'])) {
    // Get the values from the form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Check if the username or email already exists in the database
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username=:username OR email=:email");
        $stmt->execute(['username' => $username, 'email' => $email]);
        $user = $stmt->fetch();

        if ($user) {
            // If the username or email already exists, show an error message and redirect back to index.html
            header("Location: index.html?register_failed=true");
            exit;
        } else {
            // If the username and email are available, insert the new user into the database
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
            $stmt->execute(['username' => $username, 'email' => $email, 'password' => $hashed_password]);
            header("Location: index.html?register_succeed=true");
            exit;
        }

    } catch (PDOException $e) {
        // If the connection fails, show an error message
        echo 'Connection failed: ' . $e->getMessage();
    }
}
?>