-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 14 Okt 2024 pada 07.35
-- Versi server: 8.3.0
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `umko_rezi_skripsi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_user` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telp` int NOT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int NOT NULL,
  `is_active` int NOT NULL,
  `date_created` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `kode_user`, `name`, `email`, `telp`, `image`, `password`, `role_id`, `is_active`, `date_created`) VALUES
(1, 'ID12024010', 'Khoirul Husen', 'hoirulhusen08@gmail.com', 0, 'default.jpg', '$2y$10$nr.foXCJokGCEejP5xh1xuD4mP0hSIN9C1ttIsGKFWLCvcaSTyup2', 1, 1, 1712589712),
(2, 'ID12024011', 'Muhammad Alfarizi', 'mahasiswa@gmail.com', 0, 'default.jpg', '$2y$10$EYHL90J3KjMLmTa1Jt6uLuoZfjaBc3TCVpnjumYpfw1B51dpDddvG', 2, 1, 1712589882),
(3, 'ID12024017', 'Administrator', 'admin@gmail.com', 0, '500-x-500-Blue.png', '$2y$10$1TT/nBWOqjmQjZeyNFVJheGP9JVYykXKKdApLQAkAV5bhu4tuNk/2', 1, 1, 1712666172),
(6, 'ID-19-05-2024-3', 'Asep Juan', 'juanasep59@gmail.com', 0, '500-x-500.png', '$2y$10$A.oCluMm3PVy1GgQC.BKieRV4BOxcZPvAaRSZ.mH6Lb/QnLetr.Ku', 2, 1, 1716137685),
(10, 'ID-20-05-2024-6', 'Muhammad Alfarizi', 'muhammadalfarizi041@gmail.com', 0, 'default.jpg', '$2y$10$DON26RvdJNRgJMRYiohVAOzM5eD1HIsAWTE8vg9W.sqqxyfFkl5em', 2, 0, 1716218010);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users_role`
--

DROP TABLE IF EXISTS `users_role`;
CREATE TABLE IF NOT EXISTS `users_role` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users_role`
--

INSERT INTO `users_role` (`id`, `role`) VALUES
(1, 'Administrator'),
(2, 'Nasabah'),
(3, 'Staff');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_access_menus`
--

DROP TABLE IF EXISTS `user_access_menus`;
CREATE TABLE IF NOT EXISTS `user_access_menus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role_id` int NOT NULL,
  `menu_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_access_menus`
--

INSERT INTO `user_access_menus` (`id`, `role_id`, `menu_id`) VALUES
(1, 1, 1),
(14, 1, 2),
(3, 2, 2),
(4, 1, 3),
(16, 5, 7),
(8, 3, 5),
(9, 3, 2),
(10, 4, 2),
(11, 5, 2),
(12, 6, 2),
(13, 7, 2),
(15, 4, 6),
(17, 6, 8),
(18, 7, 9),
(19, 3, 10),
(20, 2, 8);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_menus`
--

DROP TABLE IF EXISTS `user_menus`;
CREATE TABLE IF NOT EXISTS `user_menus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `menu` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_menus`
--

INSERT INTO `user_menus` (`id`, `menu`) VALUES
(1, 'Admin'),
(2, 'User'),
(3, 'Menu'),
(4, 'Staff');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_sub_menus`
--

DROP TABLE IF EXISTS `user_sub_menus`;
CREATE TABLE IF NOT EXISTS `user_sub_menus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `menu_id` int NOT NULL,
  `title` varchar(25) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_sub_menus`
--

INSERT INTO `user_sub_menus` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, 1, 'Dashboard', 'admin', 'nav-icon fas fa-tachometer-alt', 1),
(2, 2, 'Profil Saya', 'user', 'nav-icon fas fa-user', 1),
(3, 3, 'Manajemen Menu', 'menu', 'nav-icon fas fa-solid fa-folder', 1),
(4, 3, 'Manajemen Submenu', 'menu/submenu', 'nav-icon fas fa-solid fa-folder-open', 1),
(5, 1, 'Peran', 'admin/role', 'nav-icon fas fa-solid fa-address-card', 1),
(6, 1, 'Manajemen Pengguna', 'admin/manageAllUser', 'nav-icon fas fa-users', 1),
(7, 1, 'Pengaturan Web', 'admin/settings', 'nav-icon fas fa-cog', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_token`
--

DROP TABLE IF EXISTS `user_token`;
CREATE TABLE IF NOT EXISTS `user_token` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `token` varchar(128) NOT NULL,
  `date_created` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_token`
--

INSERT INTO `user_token` (`id`, `email`, `token`, `date_created`) VALUES
(4, 'muhammadalfarizi041@gmail.com', 'iq22QdVCP2K7J65MvNf9r0bEYBLAyOtB4HlM1JtjP6I=', 1716218010);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
