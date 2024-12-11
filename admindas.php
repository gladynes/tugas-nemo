<?php
require 'db.php';

// Query untuk mengambil data dari tabel
$sql = "SELECT * FROM data_user"; // Ganti dengan nama tabel Anda
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color:#708090;
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
        th {
            background-color: #f4f4f4;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <h1>Dashboard Admin</h1>
    </div>

    <!-- Menu Navigasi -->
    <div class="menu">
        <a href="userdas.php">Pindah ke Dashboard User</a>
        <a href="exit.php">Logout</a>
        <a href="">chat</a>
    </div>

    <!-- Tabel Data User -->
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>alamat</th>
                <th>role</th>
               
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
                           
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Tidak ada data</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

   

</body>
</html>
