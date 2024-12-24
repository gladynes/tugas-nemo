-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Des 2024 pada 02.24
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web1`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_user`
--

CREATE TABLE `data_user` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `alamat` text DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_user`
--

INSERT INTO `data_user` (`id`, `nama`, `username`, `email`, `password`, `alamat`, `role`) VALUES
(1, 'figo', 'figodb', 'figo@gmail.com', 'figo123', 'rumah', 'admin'),
(2, 'mumi', 'mumi', 'mumi@gmail.com', 'mumi123', 'ssa', 'user'),
(3, 'uyu', 'uya', 'uya@gmail.com', 'uya123', 'jalan mama', 'user');

-- --------------------------------------------------------

--
-- Struktur dari tabel `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `timestamp`, `created_at`) VALUES
(1, 1, 2, 'hhh', '2024-12-14 05:19:24', '2024-12-14 12:19:24'),
(2, 1, 2, 'asu', '2024-12-14 14:03:23', '2024-12-14 21:03:23'),
(3, 1, 3, 'dad', '2024-12-15 08:48:42', '2024-12-15 15:48:42'),
(4, 3, 1, 'hhh', '2024-12-15 08:50:03', '2024-12-15 15:50:03'),
(5, 3, 3, 'dad', '2024-12-15 08:50:09', '2024-12-15 15:50:09'),
(6, 1, 1, 'hhh', '2024-12-15 08:51:24', '2024-12-15 15:51:24'),
(7, 1, 1, 'ada', '2024-12-15 08:52:52', '2024-12-15 15:52:52'),
(8, 1, 3, 'adsa', '2024-12-15 08:53:03', '2024-12-15 15:53:03'),
(9, 2, 1, 'adsa', '2024-12-15 08:57:35', '2024-12-15 15:57:35'),
(10, 2, 2, 'ini figo admin', '2024-12-15 08:58:16', '2024-12-15 15:58:16'),
(11, 2, 1, 'adsa', '2024-12-15 08:58:22', '2024-12-15 15:58:22'),
(12, 1, 2, 'halo saya admin', '2024-12-18 18:21:38', '2024-12-19 01:21:38'),
(13, 2, 1, 'halo apa ini  figo', '2024-12-18 19:15:02', '2024-12-19 02:15:02'),
(14, 2, 3, 'halo', '2024-12-18 19:20:55', '2024-12-19 02:20:55'),
(15, 2, 3, 'halo', '2024-12-18 19:21:02', '2024-12-19 02:21:02'),
(16, 2, 3, 'halo', '2024-12-18 19:24:21', '2024-12-19 02:24:21'),
(17, 2, 3, 'ga', '2024-12-18 19:25:08', '2024-12-19 02:25:08'),
(18, 2, 3, 'halo', '2024-12-18 19:45:08', '2024-12-19 02:45:08'),
(19, 2, 3, 'halo', '2024-12-18 19:51:02', '2024-12-19 02:51:02'),
(20, 2, 1, 'xzcxzc', '2024-12-18 19:51:11', '2024-12-19 02:51:11'),
(21, 2, 3, 'fs', '2024-12-18 19:55:36', '2024-12-19 02:55:36'),
(22, 2, 3, 's', '2024-12-18 19:56:57', '2024-12-19 02:56:57'),
(23, 2, 3, 's', '2024-12-18 19:57:44', '2024-12-19 02:57:44'),
(24, 2, 3, 'ad', '2024-12-18 19:59:30', '2024-12-19 02:59:30'),
(25, 2, 3, 'zxcz', '2024-12-18 20:24:24', '2024-12-19 03:24:24'),
(26, 3, 2, 'halo ini mumi kerim ke uya', '2024-12-18 20:54:03', '2024-12-19 03:54:03'),
(27, 3, 2, 'halo ini mumi', '2024-12-18 20:55:41', '2024-12-19 03:55:41'),
(28, 3, 2, 'halo ini mumi kerim ke uya', '2024-12-18 20:55:50', '2024-12-19 03:55:50'),
(29, 3, 2, 'halo ini mumi kerim ke uya', '2024-12-18 20:56:01', '2024-12-19 03:56:01'),
(30, 3, 2, 'ini uya', '2024-12-18 21:15:02', '2024-12-19 04:15:02'),
(31, 2, 3, 'halo ini mumi', '2024-12-18 21:16:03', '2024-12-19 04:16:03'),
(32, 2, 3, 'halo dari mumi', '2024-12-19 11:33:41', '2024-12-19 18:33:41'),
(33, 2, 2, 'halo', '2024-12-19 11:36:04', '2024-12-19 18:36:04'),
(34, 2, 3, 'halo dari mumi', '2024-12-19 12:27:46', '2024-12-19 19:27:46'),
(35, 3, 2, 'halo ini uya', '2024-12-19 12:32:20', '2024-12-19 19:32:20'),
(36, 2, 1, 'lkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk', '2024-12-20 13:24:30', '2024-12-20 20:24:30'),
(37, 2, 1, 'lkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk', '2024-12-20 13:25:58', '2024-12-20 20:25:58'),
(38, 2, 1, 'lkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk', '2024-12-20 13:26:54', '2024-12-20 20:26:54'),
(39, 2, 1, 'gf', '2024-12-22 16:39:44', '2024-12-22 23:39:44'),
(40, 2, 3, 'jjk', '2024-12-23 08:13:05', '2024-12-23 15:13:05'),
(41, 1, 2, 'yyy', '2024-12-23 08:14:54', '2024-12-23 15:14:54'),
(42, 1, 3, 'halo ', '2024-12-23 08:15:17', '2024-12-23 15:15:17'),
(43, 1, 1, 'jnj', '2024-12-23 08:15:51', '2024-12-23 15:15:51');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `data_user`
--
ALTER TABLE `data_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `data_user`
--
ALTER TABLE `data_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `data_user` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `data_user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
