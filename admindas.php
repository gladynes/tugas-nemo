<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

$sql = "SELECT * FROM data_user WHERE role != 'admin'";
$result = $conn->query($sql);

if (!$result) {
    die("Query error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .header { background-color: #708090; color: white; padding: 10px 20px; text-align: center; }
        .menu { background-color: #28a745; color: white; padding: 10px; text-align: center; }
        .menu a { text-decoration: none; color: white; background-color: #007BFF; padding: 10px 20px; margin-right: 10px; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 10px; text-align: left; }
        .chat-link {
            display: inline-block;
            padding: 5px 10px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Dashboard Admin</h1>
        <p>Selamat datang, <?= htmlspecialchars($_SESSION['username']) ?> (Role: <?= htmlspecialchars($_SESSION['role']) ?>)</p>
    </div>
    <div class="menu">
        <a href="adminduser.php">Pindah ke Dashboard User</a>
        <a href="exit.php">Logout</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Alamat</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['alamat']) ?></td>
                        <td><?= htmlspecialchars($row['role']) ?></td>
                       <td>
                         <a href="adminkeuser.php?receiver_id=<?= htmlspecialchars($row['id']) ?>" class="chat-link">Chat</a>
                     </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Tidak ada data pengguna</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>