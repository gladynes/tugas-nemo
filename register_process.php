<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = trim($_POST['nama']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $alamat = trim($_POST['alamat']);
    $password = $_POST['password'];

    // Validasi input
    if (empty($nama) || empty($username) || empty($email) || empty($alamat) || empty($password)) {
          $_SESSION['error'] = "Semua kolom wajib diisi.";
        header("Location: register.php");
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $_SESSION['error'] = "Format email tidak valid.";
        header("Location: register.php");
        exit();
    }


    // Cek username atau email sudah ada
    $sql_check = "SELECT * FROM data_user WHERE username = ? OR email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ss", $username, $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    if ($result_check->num_rows > 0) {
          $_SESSION['error'] = "Username atau Email sudah digunakan.";
        header("Location: register.php");
        exit();
    }

    // Input Data ke database (tanpa enkripsi)
    $sql_insert = "INSERT INTO data_user (nama, username, email, password, alamat, role) VALUES (?, ?, ?, ?, ?, 'user')";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("sssss", $nama, $username, $email, $password, $alamat);


     if ($stmt_insert->execute()) {
        header("Location: login.php");
          exit;
     } else {
           $_SESSION['error'] = "Terjadi kesalahan saat registrasi. Silahkan coba lagi.";
          header("Location: register.php");
           exit;
      }


    $stmt_check->close();
    $stmt_insert->close();
    $conn->close();
}
?>