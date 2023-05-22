<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'streamify';
    
// Connect to database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'connection failed: ' . $e->getMessage();
}
?>
