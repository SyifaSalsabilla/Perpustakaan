-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 23 Jun 2023 pada 08.53
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggota`
--

CREATE TABLE `anggota` (
  `id` int NOT NULL,
  `nomor` int NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `alamat` text,
  `no_hp` varchar(20) DEFAULT NULL,
  `tanggal_terdaftar` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `anggota`
--

INSERT INTO `anggota` (`id`, `nomor`, `nama`, `jenis_kelamin`, `alamat`, `no_hp`, `tanggal_terdaftar`) VALUES
(2, 11, 'User 21', 'Laki-laki', 'Jakarta', '08222616611', '2023-06-23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id` int NOT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `kode_kategori` varchar(255) DEFAULT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `pengarang` varchar(255) DEFAULT NULL,
  `penerbit` varchar(255) DEFAULT NULL,
  `tahun` int DEFAULT NULL,
  `tanggal_input` date DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `file_cover` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id`, `kode`, `kode_kategori`, `judul`, `pengarang`, `penerbit`, `tahun`, `tanggal_input`, `harga`, `file_cover`) VALUES
(35, 'B001', 'KTG001', 'Harry Potter and the Sorcerer\'s Stone', 'J.K. Rowling', 'Bloomsbury Publishing', 1997, '2022-01-01', '150000.00', 'uploads/download.jpeg'),
(36, 'B002', 'KTG001', 'The Hobbit', 'J.R.R. Tolkien', 'Allen & Unwin', 1937, '2022-02-15', '125000.00', 'uploads/download (1).jpeg'),
(37, 'B003', 'KTG002', 'Sapiens: A Brief History of Humankind', 'Yuval Noah Harari', 'Harper', 2011, '2022-03-10', '175000.00', 'uploads/51Sn8PEXwcL.jpg'),
(38, 'B004', 'KTG002', 'The Power of Now', 'Eckhart Tolle', 'New World Library', 1997, '2022-04-22', '135000.00', 'uploads/download (2).jpeg'),
(39, 'B005', 'KTG003', 'Steve Jobs', 'Walter Isaacson', 'Simon & Schuster', 2011, '2022-05-05', '155000.00', 'uploads/steve-job-131010c.jpg'),
(40, 'B006', 'KTG003', 'The Diary of a Young Girl', 'Anne Frank', 'Contact Publishing', 1947, '2022-06-18', '145000.00', 'uploads/download (3).jpeg'),
(41, 'B007', 'KTG004', 'A Brief History of Time', 'Stephen Hawking', 'Bantam Books', 1988, '2022-07-21', '165000.00', 'uploads/afefecf4c015ab6d7f0d5fac390379a5.jpeg'),
(42, 'B008', 'KTG004', 'The Elegant Universe', 'Brian Greene', 'W. W. Norton & Company', 1999, '2022-08-08', '185000.00', 'uploads/download (4).jpeg'),
(43, 'B009', 'KTG005', 'Sapiens: A Brief History of Humankind', 'Yuval Noah Harari', 'Harper', 2011, '2022-09-14', '175000.00', 'uploads/0_77c04ad4-153a-47af-b192-e9cb57ac5e0c_335_500.jpg'),
(44, 'B010', 'KTG005', 'Guns, Germs, and Steel', 'Jared Diamond', 'W. W. Norton & Company', 1997, '2022-10-29', '155000.00', 'uploads/51LVx6UrW5L._AC_UF1000,1000_QL80_.jpg'),
(47, 'B0077', 'KTG001', 'Buku 1', 'People', 'Gramedia', 2022, '2023-06-19', '200000.00', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id` int NOT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id`, `kode`, `kategori`) VALUES
(8, 'KTG001', 'Fiksi'),
(9, 'KTG002', 'Non-Fiksi'),
(10, 'KTG003', 'Biografi'),
(11, 'KTG004', 'Sains'),
(12, 'KTG005', 'Sejarah');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`),
  ADD KEY `kode_kategori` (`kode_kategori`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`kode_kategori`) REFERENCES `kategori` (`kode`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
