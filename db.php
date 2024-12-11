<?php
// Informasi koneksi database
$servername = "localhost"; // Alamat server (bisa juga IP server atau nama domain)
$username = "nemo";        // Username database
$password = "GladyVv!!";            // Password database
$dbname = "web1"; // Nama database yang ingin diakses

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

?>
