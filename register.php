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
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate username
    if (empty($username)) {
        $message = "Username is required.";
        $toastClass = "#dc3545"; // Danger color
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Validate email format
        $message = "Invalid email format.";
        $toastClass = "#dc3545"; // Danger color
    } elseif (strlen($password) < 6) {
        // Validate password strength
        $message = "Password must be at least 6 characters long.";
        $toastClass = "#dc3545"; // Danger color
    } else {
        // Proceed with registration logic
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        
        if ($stmt->rowCount() > 0) {
            $message = "User  already exists.";
            $toastClass = "#dc3545"; // Danger color
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            // Insert new user with downloads initialized to 0 and book_name to empty
            $stmt = $pdo->prepare("INSERT INTO users (username, password, email, downloads, book_name) VALUES (?, ?, ?, 0, '')");
            if ($stmt->execute([$username, $hashedPassword, $email])) {
                // Immediately log in the user
                $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
                $stmt->execute([$username, $email]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($user) {
                    session_start();
                    $_SESSION['user_id'] = $user['id']; // Assuming 'id' is the primary key
                    $_SESSION['username'] = $user['username'];
                    $message = "User  registered and logged in successfully.";
                    $toastClass = "#28a745"; // Success color
                }
            } else {
                $message = "Registration failed.";
                $toastClass = "#dc3545"; // Danger color
            }
        }
    }
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode(['message' => $message, 'toastClass' => $toastClass]);
exit; // Ensure no further code is executed
?>