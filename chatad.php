<?php
session_start();
require 'db.php';

// Tidak ada validasi sesi yang memadai
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$sender_id = $_SESSION['user_id'];

// Query langsung tanpa prepared statement (rentan SQL Injection)
$sql_admin = "SELECT id FROM data_user WHERE role = 'admin' LIMIT 1";
$result_admin = $conn->query($sql_admin);

if ($result_admin && $result_admin->num_rows > 0) {
    $admin = $result_admin->fetch_assoc();
    $receiver_id = $admin['id'];
} else {
    die("Admin tidak ditemukan.");
}

// Query langsung tanpa sanitasi (rentan SQL Injection)
$query_receiver = "SELECT nama FROM data_user WHERE id = '$receiver_id'";
$result_receiver = $conn->query($query_receiver);
$receiver_name = 'Unknown User';
if ($result_receiver && $result_receiver->num_rows > 0) {
    $row_receiver = $result_receiver->fetch_assoc();
    // Tidak ada sanitasi output (rentan XSS)
    $receiver_name = $row_receiver['nama'];
}

// Tidak ada validasi input (rentan XSS dan SQL Injection)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'];

    // Query langsung tanpa sanitasi (rentan SQL Injection)
    $query = "INSERT INTO messages (sender_id, receiver_id, message) VALUES ('$sender_id', '$receiver_id', '$message')";
    if (!$conn->query($query)) {
        die("Gagal mengirim pesan: " . $conn->error);
    }
}

// Query langsung tanpa prepared statement (rentan SQL Injection)
$query = "
    SELECT m.*, u.nama as sender_name
    FROM messages m
    LEFT JOIN data_user u ON m.sender_id = u.id
    WHERE (m.sender_id = '$sender_id' AND m.receiver_id = '$receiver_id') 
       OR (m.sender_id = '$receiver_id' AND m.receiver_id = '$sender_id') 
    ORDER BY m.created_at ASC";
$result = $conn->query($query);

if (!$result) {
    die("Gagal mengambil pesan: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat dengan <?= $receiver_name ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .chat-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .chat {
            max-height: 300px;
            overflow-y: auto;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            background: #f9f9f9;
        }
        .message {
            margin: 5px 0;
            padding: 10px;
            border-radius: 5px;
            display: inline-block;
            clear: both;
            max-width: 70%;
        }
        .message.sender {
            background: #007BFF;
            color: #fff;
            text-align: right;
            float: right;
        }
        .message.receiver {
            background: #e1e1e1;
            color: #000;
            text-align: left;
            float: left;
        }
        .message .sender-name,
        .message .receiver-name {
            font-size: 0.8em;
            display: block;
            margin-bottom: 5px;
        }
        form {
            display: flex;
            gap: 10px;
        }
        input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            border: none;
            background: #007BFF;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <h1>Chat dengan: <?= $receiver_name ?></h1>

        <!-- Tampilkan Chat -->
        <div class="chat">
            <?php while ($message = $result->fetch_assoc()): ?>
                <div class="message <?= $message['sender_id'] == $sender_id ? 'sender' : 'receiver' ?>">
                    <span class="<?= $message['sender_id'] == $sender_id ? 'sender-name' : 'receiver-name' ?>">
                        <?= $message['sender_id'] == $sender_id ? 'Anda' : $message['sender_name'] ?>
                    </span>
                    <?= $message['message'] ?>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Form Kirim Pesan -->
        <form method="POST">
            <input type="text" name="message" placeholder="Ketik pesan Anda" required>
            <button type="submit">Kirim</button>
        </form>
    </div>
</body>
</html>
