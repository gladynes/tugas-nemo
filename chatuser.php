<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'user')) {
    header("Location: login.php");
    exit;
}

// Query untuk mendapatkan daftar semua user kecuali user yang sedang login
$sql_users = "SELECT id, nama FROM data_user WHERE id != ?";
$stmt_users = $conn->prepare($sql_users);

if (!$stmt_users) {
    die("Error preparing SQL query: " . $conn->error);
}

// Bind parameter untuk mengecualikan user yang sedang login
$stmt_users->bind_param("i", $_SESSION['user_id']);

if (!$stmt_users->execute()) {
    die("Error executing SQL query: " . $stmt_users->error);
}

$result_users = $stmt_users->get_result();

if (!$result_users) {
    die("Error getting result: " . $stmt_users->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Antar User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #009688;
        }
        .chat-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }
        .chat-link {
            display: inline-block;
            padding: 5px 10px;
            background-color: #009688;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <h1>Chat Antar User</h1>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result_users->num_rows > 0): ?>
                <?php while ($row = $result_users->fetch_assoc()): ?>
                <tr>
                    <td><?= ($row['nama']) ?></td>
                    <td>
                        <a href="userchat.php?receiver_id=<?=($row['id']) ?>" class="chat-link">Chat</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2">Tidak ada user</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
