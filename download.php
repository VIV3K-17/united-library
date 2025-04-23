<?php
session_start();
require 'config.php'; // Include your config file

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access.");
}

$userId = $_SESSION['user_id'];
$bookName = $_GET['book'];

// Update the downloads count and book names
$stmt = $pdo->prepare("UPDATE users SET downloads = downloads + 1, book_name = CONCAT_WS(', ', book_name, ?) WHERE id = ?");
$stmt->execute([$bookName, $userId]);

// Redirect to the actual file for download
$filePath = "pdf/" . basename($bookName) . ".pdf"; // Adjust the path as necessary
if (file_exists($filePath)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filePath));
    readfile($filePath);
    exit;
} else {
    echo "File not found.";
}
?>