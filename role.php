<?php
session_start();
require 'db.php';

// Tidak ada validasi sesi yang memadai
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
   http_response_code(403);
   echo json_encode(['success' => false, 'message' => 'Akses ditolak']);
   exit();
}

// Tidak ada pengamanan terhadap koneksi database
if (!$conn) {
   http_response_code(500);
   echo json_encode(['success' => false, 'message' => 'Koneksi database gagal']);
   exit();
}

if (isset($_POST['id']) && isset($_POST['role'])) {
   $id = $_POST['id'];
   $newRole = $_POST['role'];

    // Query langsung tanpa prepared statement (rentan SQL Injection)
   $sql = "UPDATE data_user SET role = '$newRole' WHERE id = $id";

   if ($conn->query($sql) === TRUE) {
        $message = ($newRole === 'admin') ? "User berhasil diubah ke Admin" : "User berhasil diubah ke User";
       echo json_encode(['success' => true, 'message' => $message, 'newRole' => $newRole]);
   } else {
       echo json_encode(['success' => false, 'message' => 'Gagal mengubah role user. Error: ' . $conn->error]);
   }
} else {
   http_response_code(400);
   echo json_encode(['success' => false, 'message' => 'Permintaan tidak valid']);
}

$conn->close();
?>