<?php
session_start();
require 'db.php'; // Koneksi database

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Ambil username dari session
$username = $_SESSION['username'];

// Query untuk mengambil data pengguna berdasarkan username
$sql = "SELECT username, role FROM data_user WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Periksa apakah data pengguna ditemukan
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $user_name = $user['username'];
    $user_role = $user['role'];
} else {
    // Jika data tidak ditemukan, redirect ke login
    header("Location: login.php");
    exit;
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
    </style>
</head>
<body>

<!-- Header -->
<div class="header">
    <h1>Dashboard User</h1>
    <p>Selamat datang, <?= htmlspecialchars($user_name) ?> (Role: <?= htmlspecialchars($user_role) ?>)</p>
</div>

<!-- Menu Navigasi -->
<div class="menu">
    <a href="exit.php">Logout</a>
    <a href="">chat</a>
</div>

</body>
</html>
