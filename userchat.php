<?php
session_start();
require 'db.php';

// Perubahan: Hanya izinkan role 'user'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}

$sender_id = $_SESSION['user_id'];

// Perubahan: Ambil receiver_id dari query parameter atau default
$receiver_id = isset($_GET['receiver_id']) ? $_GET['receiver_id'] : null;

// Jika receiver_id tidak ada, redirect ke halaman pemilihan user
if (!$receiver_id) {
    header("Location: pilih_user.php");
    exit;
}

// Fetch receiver's name
$query_receiver = "SELECT nama FROM data_user WHERE id = '$receiver_id'";
$result_receiver = $conn->query($query_receiver);
$receiver_name = 'Unknown User';
if ($result_receiver && $result_receiver->num_rows > 0) {
    $row_receiver = $result_receiver->fetch_assoc();
    $receiver_name = htmlspecialchars($row_receiver['nama']);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['message']);

    if (!empty($message)) {
        $message_cleaned = $conn->real_escape_string($message);
        $query = "INSERT INTO messages (sender_id, receiver_id, message) VALUES ('$sender_id', '$receiver_id', '$message_cleaned')";
         if (!$conn->query($query)) {
            die("Gagal mengirim pesan: " . $conn->error);
        }
    } else {
         echo '<script>alert("Pesan tidak boleh kosong!");</script>';
    }
}

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
            background-color: #e0f7f4;
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
            background:#009688;
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
                <?php if ($message['sender_id'] == $sender_id): ?>
                <span class="sender-name">Anda</span>
             <?php else: ?>
               <span class="receiver-name"><?= htmlspecialchars($message['sender_name']) ?></span>
            <?php endif; ?>
                 <?= htmlspecialchars($message['message']) ?>
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