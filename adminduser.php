<?php
session_start();
require 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];

$sql = "SELECT username, role, nama, alamat, email, id FROM data_user WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

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

// Query untuk mendapatkan ID admin
$sql_admin = "SELECT id FROM data_user WHERE role = 'admin' LIMIT 1";
$result_admin = $conn->query($sql_admin);

if ($result_admin && $result_admin->num_rows > 0) {
    $admin = $result_admin->fetch_assoc();
    $admin_id = $admin['id'];
} else {
    // Handle jika admin tidak ditemukan (opsional, bisa redirect atau tampilkan pesan error)
    $admin_id = null;
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
    <h1>Dashboard User</h1>
    <p>Selamat datang, <?= htmlspecialchars($user_name) ?> (Role: <?= htmlspecialchars($user_role) ?>)</p>
</div>

<div class="menu">
   <a href="exit.php">Logout</a>
    <?php if ($admin_id !== null): ?>
         <a href="chatad.php" class="chat-link">Chat Admin</a>
    <?php else: ?>
         <span>Admin not available</span>
    <?php endif; ?>
    <a href="chatuser.php" class="chat-link">Chat User</a>
    <a href="admindas.php">dasbord admin </a>
</div>

<div class="profile">
    <h2>Profil Anda</h2>
    <table>
        <tr>
            <th>Nama</th>
            <td><?= htmlspecialchars($user_nama) ?></td>
        </tr>
        <tr>
            <th>Username</th>
            <td><?= htmlspecialchars($user_name) ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= htmlspecialchars($user_email) ?></td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td><?= htmlspecialchars($user_alamat) ?></td>
        </tr>
    </table>
</div>

</body>
</html>