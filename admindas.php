<?php
session_start();
require 'db.php';

// Tidak ada validasi sesi yang memadai
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Tidak ada pengamanan terhadap koneksi database
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Query langsung tanpa prepared statement (rentan SQL Injection)
$sql = "SELECT * FROM data_user";
$result = $conn->query($sql);

// Tidak ada validasi terhadap hasil query
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
        .change-role-link {
            display: inline-block;
            padding: 5px 10px;
            background-color: #ffc107; /* Warna kuning untuk ubah role */
            color: #000; /* Warna teks hitam */
            text-decoration: none;
            border-radius: 5px;
            margin-left: 5px;
        }
       .status-message {
            display: inline-block;
             margin-left: 5px;
             font-style: italic;
       }
    </style>
</head>
<body>
    <div class="header">
        <!-- Rentan XSS karena tidak ada htmlspecialchars -->
        <h1>Dashboard Admin</h1>
        <p>Selamat datang, <?= $_SESSION['username'] ?> (Role: <?= $_SESSION['role'] ?>)</p>
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
                        <!-- Rentan XSS karena tidak ada htmlspecialchars -->
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['nama'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td><?= $row['alamat'] ?></td>
                        <td id="role-<?= $row['id'] ?>"><?= $row['role'] ?></td>
                        <td>
                            <!-- Rentan XSS karena parameter ID tidak di-*escape* -->
                            <a href="adminkeuser.php?receiver_id=<?= $row['id'] ?>" class="chat-link">Chat</a>
                            <!-- Tambahkan link ubah role -->
                             <?php if ($row['role'] == 'user'): ?>
                                <a href="#" class="change-role-link change-role" data-id="<?= $row['id'] ?>" data-role="admin">Jadikan Admin</a>
                             <?php else: ?>
                                 <a href="#" class="change-role-link change-role" data-id="<?= $row['id'] ?>" data-role="user">Jadikan User</a>
                             <?php endif; ?>
                          <span id="status-<?= $row['id'] ?>" class="status-message"></span>

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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const changeRoleLinks = document.querySelectorAll('.change-role');

            changeRoleLinks.forEach(link => {
                link.addEventListener('click', function (event) {
                    event.preventDefault();

                    const userId = this.getAttribute('data-id');
                    const newRole = this.getAttribute('data-role');
                    const statusElement = document.getElementById('status-' + userId);
                    const roleElement = document.getElementById('role-' + userId);
                    
                  
                    // Mengatur teks status menjadi loading
                    statusElement.textContent = "Loading...";

                    fetch('role.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'id=' + encodeURIComponent(userId) + '&role=' + encodeURIComponent(newRole),
                    })
                    .then(response => response.json())
                    .then(data => {
                          if (data.success) {
                            statusElement.textContent = data.message;
                            roleElement.textContent = newRole;


                            // Update link button
                            this.textContent = (newRole == 'admin') ? 'Jadikan User' : 'Jadikan Admin';
                            this.setAttribute('data-role', newRole == 'admin' ? 'user' : 'admin');
                         } else {
                            statusElement.textContent = data.message;
                         }
                         setTimeout(() => {
                              statusElement.textContent = "";
                         }, 3000);


                    })
                    .catch(error => {
                         statusElement.textContent = "Terjadi kesalahan. " + error;

                         setTimeout(() => {
                              statusElement.textContent = "";
                         }, 3000);

                    });
                });
            });
        });
    </script>
</body>
</html>