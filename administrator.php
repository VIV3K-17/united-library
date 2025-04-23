<?php
// Include the config file to use the PDO connection
include 'config.php';

// Fetch user data using PDO
try {
    $stmt = $pdo->query("SELECT username, email, downloads, book_name FROM users");
} catch (PDOException $e) {
    die("Could not fetch user data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>User Metadata Table</h1>
    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Downloads</th>
                <th>Book Name</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): 
                // Format data
                $username = ucwords(strtolower(trim($row['username'])));
                $email = strtolower(trim($row['email']));
                $downloads = is_numeric($row['downloads']) ? $row['downloads'] : 0;
                $book_name = ucwords(strtolower(trim($row['book_name'])));
            ?>
            <tr>
                <td><?= htmlspecialchars($username) ?></td>
                <td><?= htmlspecialchars($email) ?></td>
                <td><?= $downloads ?></td>
                <td><?= htmlspecialchars($book_name) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>

<?php
// Close the PDO connection (optional since it will be closed at the end of the script)
$pdo = null;
?>
