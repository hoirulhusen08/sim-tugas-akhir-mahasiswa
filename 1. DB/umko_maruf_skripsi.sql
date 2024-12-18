-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Des 2024 pada 10.50
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
-- Struktur dari tabel `dosen`
--

CREATE TABLE `dosen` (
  `id` int(11) NOT NULL,
  `kode_dosen` varchar(50) NOT NULL,
  `nama` varchar(60) NOT NULL,
  `nbm` varchar(15) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `alamat_dosen` text NOT NULL,
  `telp_dosen` varchar(15) NOT NULL,
  `status_dospem` int(11) NOT NULL,
  `status_pembahas` int(11) NOT NULL,
  `date_created_dosen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `dosen`
--

INSERT INTO `dosen` (`id`, `kode_dosen`, `nama`, `nbm`, `tgl_lahir`, `alamat_dosen`, `telp_dosen`, `status_dospem`, `status_pembahas`, `date_created_dosen`) VALUES
(1, '', 'Dosen 1 (Dekan)', '8169321', '0000-00-00', '', '', 0, 0, 0),
(2, '', 'Dosen', '20071012', '0000-00-00', '', '', 0, 0, 0);

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

--
-- Dumping data untuk tabel `mahasiswa`
--

INSERT INTO `mahasiswa` (`id`, `kode_mahasiswa`, `nama`, `npm`, `tgl_lahir`, `telp_mhs`, `alamat_mhs`, `judul_ta`, `nama_pa`, `nama_dospem`, `nama_pembahas1`, `nama_pembahas2`, `nama_pembahas3`, `status_sidang`, `syarat_sempro`, `syarat_semhas`, `syarat_sidang`, `date_created_mhs`) VALUES
(2, '', 'Khoirul Husen', '20071011', '0000-00-00', '', '', '', '2', '', '', '', '', 0, '', '', '', 0),
(3, '', 'Yulia', '21071092', '0000-00-00', '', '', '', '2', '', '', '', '', 0, '', '', '', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `kode_user` varchar(50) NOT NULL,
  `id_mhs` int(11) DEFAULT NULL,
  `id_dosen` int(11) DEFAULT NULL,
  `jenis_pengguna` varchar(30) NOT NULL,
  `name` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `kode_user`, `id_mhs`, `id_dosen`, `jenis_pengguna`, `name`, `email`, `image`, `password`, `role_id`, `is_active`, `date_created`) VALUES
(1, 'ID12024017', 0, 0, '', 'Administrator', 'admin@gmail.com', '500-x-500-Blue.png', '$2y$10$1TT/nBWOqjmQjZeyNFVJheGP9JVYykXKKdApLQAkAV5bhu4tuNk/2', 1, 1, 1712666172),
(11, 'ID-14-11-2024-1', 2, NULL, 'Mahasiswa', 'Khoirul Husen', 'dosen@gmail.com', 'default.jpg', '$2y$10$TsLk5J.YxFSSZJTn.1kqmOZpurOoK/UOUTb6dmtnx1Gae59tIviFC', 2, 1, 1731586811),
(12, 'ID-14-11-2024-11', NULL, 1, 'Dosen', 'Dekan', 'dekan@gmail.com', 'default.jpg', '$2y$10$LpPbz5l.JsDwVzf2Hl9jJ.MVay6KoSMuAavPC5pBQ7OwTcu18y8RK', 5, 1, 1731586913),
(13, 'ID-15-11-2024-12', NULL, 2, 'Dosen', 'Dosen', '', 'default.jpg', '', 6, 1, 1731692488),
(14, 'ID-06-12-2024-13', 3, NULL, 'Mahasiswa', 'Yulia', 'yuliasari1092@gmail.com', 'default.jpg', '$2y$10$fNjlj76X82oTw/IsQ5GXCuMvp0XLi3j/aU4pAFolOP8BymWVUlLs6', 2, 1, 1733469832);

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
(4, 'Kaprodi'),
(5, 'Dekan'),
(6, 'Dosen');

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
(25, 1, 4),
(26, 11, 2),
(27, 10, 2),
(28, 9, 2);

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
(4, 'muhammadalfarizi041@gmail.com', 'iq22QdVCP2K7J65MvNf9r0bEYBLAyOtB4HlM1JtjP6I=', 1716218010),
(6, 'yuliasari1092@gmail.com', '03A89Ls2gqhZ1v9lr8w8KidzMe7MQLIrXNxXW0Q1JN0=', 1733470183);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_mhs` (`id_mhs`,`id_dosen`);

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
-- AUTO_INCREMENT untuk tabel `dosen`
--
ALTER TABLE `dosen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `users_role`
--
ALTER TABLE `users_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `user_access_menus`
--
ALTER TABLE `user_access_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
