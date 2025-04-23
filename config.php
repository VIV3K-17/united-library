<?php
$host = 'localhost';
$dbname = 'login_system';
$username = 'root'; // Default XAMPP MySQL username
$password = 'Qq@12345'; // Default XAMPP MySQL password is empty

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
?>