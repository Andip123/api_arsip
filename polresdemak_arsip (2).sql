-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Jan 2025 pada 20.27
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
-- Database: `polresdemak_arsip`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `nama`, `email`, `password`) VALUES
(1, 'Admin 1', 'admin1@example.com', 'password123'),
(2, 'Admin 2', 'admin2@example.com', 'password123'),
(4, 'Admin User', 'admin@gmail.com', '$2y$10$V8ZM3QgSEIwGwd2lzy4rBe.XsbSkZuJNLiMArzZXzRKVQAuNIz6gi'),
(5, 'andi', 'andi@gmail.com', '$2y$10$GtSKZCx4miPt2U07GcBpTeVtLcUpqystWknNyWleQ9fspaOxfAdK6');

-- --------------------------------------------------------

--
-- Struktur dari tabel `create_account`
--

CREATE TABLE `create_account` (
  `iid` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('Admin','User') NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `create_account`
--

INSERT INTO `create_account` (`iid`, `nama`, `email`, `role`, `password`, `created_at`, `updated_at`) VALUES
(1, 'User 1', 'user1@example.com', 'User', 'password123', '2025-01-02 13:53:24', '2025-01-02 13:53:24'),
(2, 'User 2', 'user2@example.com', 'User', 'password123', '2025-01-02 13:53:24', '2025-01-02 13:53:24'),
(3, 'Admin 3', 'admin3@example.com', 'Admin', 'password123', '2025-01-02 13:53:24', '2025-01-02 13:53:24'),
(5, 'Hilmi', 'hilmi@gmail.com', 'User', '$2y$10$V3cnGtkEtJc9HJyLPI2xteIZa4r6eDthtoWuJttEl9I6shzx90uzy', '2025-01-11 13:14:38', '2025-01-11 13:14:38'),
(6, 'andi', 'andi@gmail.com', 'User', '$2y$10$oUuQppsEjnmesFvV3Huc2.jfk7MDj8G1THzkSTFn4opOzomFR.Hbq', '2025-01-11 13:17:43', '2025-01-11 13:17:43'),
(15, 'andi', 'andiprabandaru@gmail.com', 'User', '$2y$10$E7f7ExM.izjt6Lk/FQapjO8EfVo2FKRPPachr0ByW4lxEHU3xi6cO', '2025-01-11 21:23:24', '2025-01-11 21:23:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `divisi`
--

CREATE TABLE `divisi` (
  `id` int(11) NOT NULL,
  `kode_divisi` varchar(10) NOT NULL,
  `nama_divisi` varchar(100) NOT NULL,
  `alamat_kantor` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `divisi`
--

INSERT INTO `divisi` (`id`, `kode_divisi`, `nama_divisi`, `alamat_kantor`) VALUES
(1, 'D01', 'Divisi IT', 'Jl. IT No.1'),
(2, 'D02', 'Divisi Keuangan', 'Jl. Keuangan No.2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id`, `nama`, `deskripsi`) VALUES
(1, 'Kategori 1', 'Deskripsi untuk Kategori 1'),
(2, 'Kategori 2', 'Deskripsi untuk Kategori 2'),
(3, 'Kategori 1', 'Deskripsi untuk Kategori 1'),
(4, 'Kategori 2', 'Deskripsi untuk Kategori 2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai`
--

CREATE TABLE `pegawai` (
  `id` int(11) NOT NULL,
  `nrp_pegawai` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nomor_hp` varchar(15) NOT NULL,
  `kode_bagian` varchar(10) NOT NULL,
  `pangkat` varchar(50) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pegawai`
--

INSERT INTO `pegawai` (`id`, `nrp_pegawai`, `nama`, `email`, `nomor_hp`, `kode_bagian`, `pangkat`, `jabatan`, `deskripsi`) VALUES
(1, '12345', 'John Doe', 'john.doe@example.com', '08123456789', 'D01', 'Staff', 'IT Support', 'Pegawai IT'),
(2, '67890', 'Jane Smith', 'jane.smith@example.com', '08198765432', 'D02', 'Supervisor', 'Keuangan', 'Pegawai Keuangan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_keluar`
--

CREATE TABLE `surat_keluar` (
  `id` int(11) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `nrp_pegawai` varchar(20) NOT NULL,
  `penerima` varchar(255) NOT NULL,
  `softfile` varchar(255) NOT NULL,
  `jenis_surat` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `surat_keluar`
--

INSERT INTO `surat_keluar` (`id`, `tanggal_surat`, `nrp_pegawai`, `penerima`, `softfile`, `jenis_surat`) VALUES
(1, '2024-01-05', '12345', 'PT DEF', 'softfile1.pdf', 'Resmi'),
(2, '2024-01-10', '67890', 'PT GHI', 'softfile2.pdf', 'Internal'),
(3, '2024-01-05', '12345', 'PT DEF', 'softfile1.pdf', 'Resmi'),
(4, '2024-01-10', '67890', 'PT GHI', 'softfile2.pdf', 'Internal');

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_keterangan_tugas`
--

CREATE TABLE `surat_keterangan_tugas` (
  `id` int(11) NOT NULL,
  `tanggal_sk` date NOT NULL,
  `nrp_pegawai` varchar(20) NOT NULL,
  `deskripsi` text NOT NULL,
  `softfile` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `surat_keterangan_tugas`
--

INSERT INTO `surat_keterangan_tugas` (`id`, `tanggal_sk`, `nrp_pegawai`, `deskripsi`, `softfile`) VALUES
(1, '2024-02-01', '12345', 'Tugas ke PT ABC', 'softfile_sk1.pdf'),
(2, '2024-02-02', '67890', 'Tugas ke PT XYZ', 'softfile_sk2.pdf'),
(3, '2024-02-01', '12345', 'Tugas ke PT ABC', 'softfile_sk1.pdf'),
(4, '2024-02-02', '67890', 'Tugas ke PT XYZ', 'softfile_sk2.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_masuk`
--

CREATE TABLE `surat_masuk` (
  `id` int(11) NOT NULL,
  `penerima_id` int(11) NOT NULL,
  `kode_surat` varchar(50) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `asal_surat` varchar(255) NOT NULL,
  `softfile` varchar(255) NOT NULL,
  `jenis_surat` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `surat_masuk`
--

INSERT INTO `surat_masuk` (`id`, `penerima_id`, `kode_surat`, `tanggal_masuk`, `asal_surat`, `softfile`, `jenis_surat`) VALUES
(1, 1, 'SM-001', '2024-01-01', 'PT ABC', 'softfile.pdf', 'Resmi'),
(2, 2, 'SM-002', '2024-01-02', 'PT XYZ', 'softfile.pdf', 'Internal'),
(3, 1, 'SM-001', '2024-01-01', 'PT ABC', 'softfile.pdf', 'Resmi'),
(4, 2, 'SM-002', '2024-01-02', 'PT XYZ', 'softfile.pdf', 'Internal');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `create_account`
--
ALTER TABLE `create_account`
  ADD PRIMARY KEY (`iid`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_divisi` (`kode_divisi`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nrp_pegawai` (`nrp_pegawai`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `kode_bagian` (`kode_bagian`);

--
-- Indeks untuk tabel `surat_keluar`
--
ALTER TABLE `surat_keluar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nrp_pegawai` (`nrp_pegawai`);

--
-- Indeks untuk tabel `surat_keterangan_tugas`
--
ALTER TABLE `surat_keterangan_tugas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nrp_pegawai` (`nrp_pegawai`);

--
-- Indeks untuk tabel `surat_masuk`
--
ALTER TABLE `surat_masuk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penerima_id` (`penerima_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `create_account`
--
ALTER TABLE `create_account`
  MODIFY `iid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `surat_keluar`
--
ALTER TABLE `surat_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `surat_keterangan_tugas`
--
ALTER TABLE `surat_keterangan_tugas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `surat_masuk`
--
ALTER TABLE `surat_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `create_account` (`iid`);

--
-- Ketidakleluasaan untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `pegawai_ibfk_1` FOREIGN KEY (`kode_bagian`) REFERENCES `divisi` (`kode_divisi`);

--
-- Ketidakleluasaan untuk tabel `surat_keluar`
--
ALTER TABLE `surat_keluar`
  ADD CONSTRAINT `surat_keluar_ibfk_1` FOREIGN KEY (`nrp_pegawai`) REFERENCES `pegawai` (`nrp_pegawai`);

--
-- Ketidakleluasaan untuk tabel `surat_keterangan_tugas`
--
ALTER TABLE `surat_keterangan_tugas`
  ADD CONSTRAINT `surat_keterangan_tugas_ibfk_1` FOREIGN KEY (`nrp_pegawai`) REFERENCES `pegawai` (`nrp_pegawai`);

--
-- Ketidakleluasaan untuk tabel `surat_masuk`
--
ALTER TABLE `surat_masuk`
  ADD CONSTRAINT `surat_masuk_ibfk_1` FOREIGN KEY (`penerima_id`) REFERENCES `pegawai` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
