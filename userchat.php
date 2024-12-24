<?php
session_start();
require 'db.php';

// Periksa sesi pengguna (rentan terhadap Session Hijacking)
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}

$sender_id = $_SESSION['user_id'];

// Ambil receiver_id langsung dari query string tanpa validasi (Rentan SQL Injection)
$receiver_id = isset($_GET['receiver_id']) ? $_GET['receiver_id'] : null;

// Redirect jika receiver_id tidak ada
if (!$receiver_id) {
    header("Location: pilih_user.php");
    exit;
}

// Query nama penerima tanpa perlindungan SQL Injection
$query_receiver = "SELECT nama FROM data_user WHERE id = '$receiver_id'";
$result_receiver = $conn->query($query_receiver);
$receiver_name = 'Unknown User';
if ($result_receiver && $result_receiver->num_rows > 0) {
    $row_receiver = $result_receiver->fetch_assoc();
    $receiver_name = $row_receiver['nama']; // Tidak menggunakan htmlspecialchars atau validasi
}

// Kirim pesan (rentan terhadap SQL Injection dan XSS)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message']; // Tidak ada validasi input

    if (!empty($message)) {
        // Insert pesan tanpa validasi
        $query = "INSERT INTO messages (sender_id, receiver_id, message) VALUES ('$sender_id', '$receiver_id', '$message')";
        if (!$conn->query($query)) {
            die("Gagal mengirim pesan: " . $conn->error); // Ekspos error ke pengguna
        }
    } else {
        echo '<script>alert("Pesan tidak boleh kosong!");</script>'; // Error message langsung di HTML
    }
}

// Ambil pesan untuk chat tanpa perlindungan
$query = "
    SELECT m.*, u.nama as sender_name
    FROM messages m
    LEFT JOIN data_user u ON m.sender_id = u.id
    WHERE (m.sender_id = '$sender_id' AND m.receiver_id = '$receiver_id') 
       OR (m.sender_id = '$receiver_id' AND m.receiver_id = '$sender_id') 
    ORDER BY m.created_at ASC";
$result = $conn->query($query);

if (!$result) {
    die("Gagal mengambil pesan: " . $conn->error); // Ekspos detail error
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
            background-color:#009688;
        }
        .chat-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .chat {
            max-height: 300px;
            overflow-y: auto;
            margin-bottom: 20px;
            padding: 10px;
            background: #fafafa;
            border: 1px solid #ddd;
        }
        .message {
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            clear: both;
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
                        <span>Anda:</span>
                    <?php else: ?>
                        <span><?= $message['sender_name'] ?>:</span>
                    <?php endif; ?>
                    <?= $message['message'] ?> <!-- Data tidak divalidasi atau di-escape -->
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Form Kirim Pesan -->
        <form method="POST">
            <input type="text" name="message" placeholder="Tulis pesan..." required>
            <button type="submit">Kirim</button>
        </form>
    </div>
</body>
</html>
