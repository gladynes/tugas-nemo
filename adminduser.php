<?php
session_start();
require 'db.php';

// Tidak ada validasi sesi yang memadai
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];

// Query langsung tanpa prepared statement (rentan SQL Injection)
$sql = "SELECT username, role, nama, alamat, email, id FROM data_user WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $user_name = $user['username'];
    $user_role = $user['role'];
    $user_nama = $user['nama'];
    $user_alamat = $user['alamat'];
    $user_email = $user['email'];
    $user_id = $user['id'];
} else {
    header("Location: login.php");
    exit;
}

// Query untuk mendapatkan ID admin tanpa validasi hasil
$sql_admin = "SELECT id FROM data_user WHERE role = 'admin' LIMIT 1";
$result_admin = $conn->query($sql_admin);

if ($result_admin && $result_admin->num_rows > 0) {
    $admin = $result_admin->fetch_assoc();
    $admin_id = $admin['id'];
} else {
    $admin_id = null; // Tidak ada validasi jika admin tidak ditemukan
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .header {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }
        .menu {
            background-color: #28a745;
            color: white;
            padding: 10px;
            text-align: center;
        }
        .menu a {
            text-decoration: none;
            color: white;
            background-color: #007BFF;
            padding: 10px 20px;
            margin-right: 10px;
            border-radius: 5px;
        }
        .menu a:hover {
            background-color: #0056b3;
        }
        .profile {
            max-width: 800px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .profile h2 {
            text-align: center;
        }
        .profile table {
            width: 100%;
            border-collapse: collapse;
        }
        .profile table th, .profile table td {
            text-align: left;
            padding: 8px 10px;
            border-bottom: 1px solid #ddd;
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

<div class="header">
    <!-- Rentan XSS karena tidak ada htmlspecialchars -->
    <h1>Dashboard User</h1>
    <p>Selamat datang, <?= $user_name ?> (Role: <?= $user_role ?>)</p>
</div>

<div class="menu">
    <a href="exit.php">Logout</a>
    <?php if ($admin_id !== null): ?>
        <!-- Rentan XSS jika $admin_id tidak di-*escape* -->
        <a href="chatad.php" class="chat-link">Chat Admin</a>
    <?php else: ?>
        <span>Admin not available</span>
    <?php endif; ?>
    <a href="chatuser.php" class="chat-link">Chat User</a>
    <a href="admindas.php">Dasbor Admin</a>
</div>

<div class="profile">
    <h2>Profil Anda</h2>
    <table>
        <tr>
            <th>Nama</th>
            <td><?= $user_nama ?></td>
        </tr>
        <tr>
            <th>Username</th>
            <td><?= $user_name ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= $user_email ?></td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td><?= $user_alamat ?></td>
        </tr>
    </table>
</div>

</body>
</html>
