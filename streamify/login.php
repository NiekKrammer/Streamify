<?php
// Connect to database
require_once('dbconnect.php');

// Start a session
session_start();

// Check if the login form has been submitted
if (isset($_POST['submit'])) {
    // Retrieve the username and password entered by the user
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Prepare a SELECT statement to retrieve the user's data from the users table
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username=:username");
        // Execute the statement with the username parameter
        $stmt->execute(['username' => $username]);
        // Fetch the first row of the result set into an associative array
        $user = $stmt->fetch();

        // Check if the user exists and the password matches the hashed password stored in the database
        if ($user && password_verify($password, $user['password'])) {
            // Set session variables for the user's ID, username, and email
            $_SESSION['user_id'] = $user['userID'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $role = $user['role'];
            // Redirect the user to different pages based on the user's role
            if ($role == 1) {
                header("Location: homepageAdmin.php");
                exit;
            } elseif ($role == 0) {
                header("Location: homepage.php");
                exit;
            } else {
                header("Location: index.html");
                exit;
            }
        } else {
            header("Location: index.html?login_failed=true");
            exit;
        }

    } catch (PDOException $e) {
        // Display an error message if there is an exception thrown during the execution of the script
        echo 'Connection failed: ' . $e->getMessage();
    }
}
?>