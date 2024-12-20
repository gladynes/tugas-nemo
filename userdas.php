<?php
session_start();
require 'db.php';

// Tidak ada pengamanan pada sesi
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];

// Query tanpa prepared statement (rentan SQL Injection)
$sql = "SELECT username, role, nama, alamat, email, id FROM data_user WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $user_name = $user['username']; // Tidak ada escaping (rentan XSS)
    $user_role = $user['role'];
    $user_nama = $user['nama'];
    $user_alamat = $user['alamat'];
    $user_email = $user['email'];
    $user_id = $user['id'];
} else {
    header("Location: login.php");
    exit;
}

// Query untuk mendapatkan ID admin (rentan SQL Injection)
$sql_admin = "SELECT id FROM data_user WHERE role = 'admin' LIMIT 1";
$result_admin = $conn->query($sql_admin);

if ($result_admin->num_rows > 0) {
    $admin = $result_admin->fetch_assoc();
    $admin_id = $admin['id']; // Tidak ada validasi tipe data
} else {
    $admin_id = null; // Admin tidak ditemukan
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #e0f7f4;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background-color: #009688;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin-bottom: 10px;
        }

        .menu {
            background-color: #00796b;
            display: flex;
            justify-content: center;
            padding: 15px 0;
        }

        .menu a {
            text-decoration: none;
            color: #fff;
            background-color: #4db6ac;
            padding: 10px 20px;
            margin: 0 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .menu a:hover {
            background-color: #00695c;
        }

        .profile {
            padding: 20px;
        }

        .profile h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #00796b;
        }

        .profile table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .profile table th, .profile table td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .profile table th {
            color: #009688;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Dashboard User</h1>
        <p>Selamat datang, <?= $user_name ?> (Role: <?= $user_role ?>)</p>
    </div>

    <div class="menu">
        <a href="exit.php">Logout</a>
        <?php if ($admin_id !== null): ?>
            <a href="chatad.php">Chat Admin</a>
        <?php else: ?>
            <span style="color: #ffffff;">Admin not available</span>
        <?php endif; ?>
        <a href="chatuser.php">Chat User</a>
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
</div>

</body>
</html>
