-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Nov 2024 pada 08.32
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `umko_maruf_skripsi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` int(11) NOT NULL,
  `kode_mahasiswa` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `npm` varchar(15) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `telp_mhs` varchar(15) NOT NULL,
  `alamat_mhs` text NOT NULL,
  `judul_ta` varchar(256) NOT NULL,
  `nama_pa` varchar(60) NOT NULL,
  `nama_dospem` varchar(60) NOT NULL,
  `nama_pembahas1` varchar(60) NOT NULL,
  `nama_pembahas2` varchar(60) NOT NULL,
  `nama_pembahas3` varchar(60) NOT NULL,
  `status_sidang` int(11) NOT NULL,
  `syarat_sempro` varchar(128) NOT NULL,
  `syarat_semhas` varchar(128) NOT NULL,
  `syarat_sidang` varchar(128) NOT NULL,
  `date_created_mhs` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `kode_user` varchar(50) NOT NULL,
  `name` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telp` int(11) NOT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `kode_user`, `name`, `email`, `telp`, `image`, `password`, `role_id`, `is_active`, `date_created`) VALUES
(1, 'ID12024010', 'Khoirul Husen', 'hoirulhusen08@gmail.com', 0, 'default.jpg', '$2y$10$JpxIupbXUg4K0O1A0qboWe9nif7NFd/NupNa4zub.vd4x2v5nYg7y', 1, 1, 1712589712),
(3, 'ID12024017', 'Administrator', 'admin@gmail.com', 0, '500-x-500-Blue.png', '$2y$10$1TT/nBWOqjmQjZeyNFVJheGP9JVYykXKKdApLQAkAV5bhu4tuNk/2', 1, 1, 1712666172);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users_role`
--

CREATE TABLE `users_role` (
  `id` int(11) NOT NULL,
  `role` varchar(25) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users_role`
--

INSERT INTO `users_role` (`id`, `role`) VALUES
(1, 'Admin'),
(2, 'Mahasiswa'),
(3, 'PA'),
(9, 'Kaprodi'),
(10, 'Dekan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_access_menus`
--

CREATE TABLE `user_access_menus` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(20, 2, 8),
(25, 1, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_menus`
--

CREATE TABLE `user_menus` (
  `id` int(11) NOT NULL,
  `menu` varchar(25) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_menus`
--

INSERT INTO `user_menus` (`id`, `menu`) VALUES
(1, 'Admin'),
(2, 'User'),
(3, 'Menu'),
(4, 'Task');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_sub_menus`
--

CREATE TABLE `user_sub_menus` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(25) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(7, 1, 'Pengaturan Web', 'admin/settings', 'nav-icon fas fa-cog', 1),
(8, 4, 'Manajemen SK', 'manajemenSK', 'nav-icon fas fa-book', 1),
(9, 4, 'Validasi Syarat', 'validasiSyarat', 'nav-icon fas fa-list', 1),
(10, 4, 'Manajemen Jadwal', 'manajemenJadwal', 'nav-icon fas fa-calendar', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_token`
--

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `token` varchar(128) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_token`
--

INSERT INTO `user_token` (`id`, `email`, `token`, `date_created`) VALUES
(4, 'muhammadalfarizi041@gmail.com', 'iq22QdVCP2K7J65MvNf9r0bEYBLAyOtB4HlM1JtjP6I=', 1716218010);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users_role`
--
ALTER TABLE `users_role`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_access_menus`
--
ALTER TABLE `user_access_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_menus`
--
ALTER TABLE `user_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_sub_menus`
--
ALTER TABLE `user_sub_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `users_role`
--
ALTER TABLE `users_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `user_access_menus`
--
ALTER TABLE `user_access_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `user_menus`
--
ALTER TABLE `user_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `user_sub_menus`
--
ALTER TABLE `user_sub_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
