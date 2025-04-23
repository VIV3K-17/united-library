<?php
session_start();
require 'config.php'; // Include your database connection

if (!isset($_SESSION['admin_logged_in'])) {
    die("Unauthorized access.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $downloads = $_POST['downloads'];
    $book_name = $_POST['book_name'];

    $stmt = $pdo->prepare("UPDATE users SET downloads = ?, book_name = ? WHERE id = ?");
    if ($stmt->execute([$downloads, $book_name, $id])) {
        echo json_encode(['message' => 'User  updated successfully.']);
    } else {
        echo json_encode(['message' => 'Failed to update user.']);
    }
} else {
    echo json_encode(['message' => 'Invalid request method.']);
}
?>