<?php
require 'config.php'; // Include your config file

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$message = "";
$toastClass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validate username and password
    if (empty($username) || empty($password)) {
        $message = "Both fields are required.";
        $toastClass = "#dc3545"; // Danger color
    } else {
        // Check if user exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $username]); // Check both username and email
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Successful login
            session_start();
            $_SESSION['user_id'] = $user['id']; // Assuming 'id' is the primary key
            $_SESSION['username'] = $user['username'];
            
            // Return JSON response for successful login
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Login successful']);
            exit; // Ensure no further code is executed after the redirect
        } else {
            $message = "Invalid username or password.";
            $toastClass = "#dc3545"; // Danger color
        }
    }
}

// Return JSON response for errors
header('Content-Type: application/json');
echo json_encode(['message' => $message, 'toastClass' => $toastClass]);
exit; // Ensure no further code is executed
?>