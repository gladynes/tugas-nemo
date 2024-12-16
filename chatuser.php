<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'user')) {
    header("Location: login.php");
    exit;
}

$sender_id = $_SESSION['user_id'];

// Query untuk mendapatkan daftar user lain (selain user yang login)
$sql_users = "SELECT id, nama FROM data_user WHERE id != ? AND role != 'admin' ";
$stmt_users = $conn->prepare($sql_users);
$stmt_users->bind_param("i", $sender_id);
$stmt_users->execute();
$result_users = $stmt_users->get_result();

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
            background-color: #f4f4f4;
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
            background-color: #007BFF;
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
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><a href="chat.php?receiver_id=<?= htmlspecialchars($row['id']) ?>" class="chat-link">Chat</a></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2">Tidak ada user lain</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>