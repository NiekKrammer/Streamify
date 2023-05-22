<?php
// Connect to database
require_once('dbconnect.php');

try {
    // Get form data
    $username = $_POST['username'];
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['new_password'];

    // Prepare and execute SQL statement
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row && password_verify($oldPassword, $row['password'])) {
        // Username and old password match in the database, update the password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateStmt = $pdo->prepare("UPDATE users SET password = :hashedPassword WHERE username = :username");
        $updateStmt->bindParam(':hashedPassword', $hashedPassword);
        $updateStmt->bindParam(':username', $username);
        $updateStmt->execute();
        header("Location: index.html?password_reset=true");
        exit;
    } else {
        header("Location: forgotpassword.html?password_reset_false=true");
        exit;
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>