<?php
session_start();
require 'db.php';

// Tidak ada validasi sesi yang memadai
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$sender_id = $_SESSION['user_id'];

// Tidak ada validasi untuk receiver_id
$receiver_id = $_GET['receiver_id'];

// Query langsung tanpa prepared statement (rentan SQL Injection)
$query_receiver = "SELECT nama FROM data_user WHERE id = '$receiver_id'";
$result_receiver = $conn->query($query_receiver);
$receiver_name = 'Unknown User';
if ($result_receiver && $result_receiver->num_rows > 0) {
    $row_receiver = $result_receiver->fetch_assoc();
    // Tidak ada sanitasi output (rentan XSS)
    $receiver_name = $row_receiver['nama'];
}

// Rentan terhadap XSS karena tidak ada validasi atau escape pada input
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
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .chat-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .chat {
            margin-bottom: 20px;
            max-height: 300px;
            overflow-y: scroll;
            border: 1px solid #ddd;
            padding: 10px;
        }
        .message {
            margin-bottom: 10px;
        }
        .sender {
            text-align: right;
            color: blue;
        }
        .receiver {
            text-align: left;
            color: green;
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
                    <span><?= $message['sender_id'] == $sender_id ? 'Anda' : $message['sender_name'] ?>:</span>
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
