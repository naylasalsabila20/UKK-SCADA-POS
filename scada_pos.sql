-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Feb 2024 pada 15.22
-- Versi server: 10.4.25-MariaDB
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scada_pos`
--

DELIMITER $$
--
-- Prosedur
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `cari_kategori` (IN `idNya` INT)   SELECT * FROM kategori WHERE id_kategori=idNya$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cari_member` (IN `idNya` VARCHAR(30))   SELECT* from member WHERE id_member=idNya$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cari_pengguna` (IN `emailNya` VARCHAR(150))   SELECT * from pengguna where email=emailNya$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cari_satuan` (IN `idNya` INT)   SELECT * FROM satuan WHERE id_satuan=idNya$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cetak_produk` ()   SELECT 
    produk.id_produk,
    produk.kode_produk,
    produk.nama_produk,
    kategori.nama_kategori,
    satuan.nama_satuan,
    produk.harga_beli,
    produk.harga_jual,
    produk.stok
FROM 
    produk
JOIN 
    satuan ON satuan.id_satuan = produk.id_satuan
JOIN 
    kategori ON kategori.id_kategori = produk.id_kategori
ORDER BY 
    kategori.nama_kategori DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `data_produk` ()   SELECT * from produk$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getDailySel` ()   SELECT  SUM(total) AS total_harian
FROM penjualan
WHERE DATE(tgl_penjualan) = CURDATE()$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetMemberList` ()   BEGIN
  SELECT
    id_member,
    nama,
   SUBSTRING(no_telp, 4) AS modified_no_telp,
    alamat
  FROM
    member;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `hapus_kategori` (IN `idNya` INT)   DELETE FROM kategori WHERE id_kategori=idNya$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `hapus_member` (IN `idNya` VARCHAR(30))   DELETE FROM member WHERE id_member=idNya$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `hapus_pengguna` (IN `emailNya` VARCHAR(150))   DELETE FROM pengguna WHERE email=emailNya$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `hapus_produk` (IN `idNya` INT)   DELETE FROM produk WHERE id_produk=idNya$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `hapus_satuan` (IN `idNya` INT)   DELETE FROM satuan WHERE id_satuan=idNya$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `hitung_keuntungan` ()   BEGIN
    DECLARE total_penjualan int;
    DECLARE total_belanja int;
    DECLARE total_keuntungan int;

    -- Menghitung total penjualan
    SELECT SUM(total) INTO total_penjualan FROM penjualan WHERE DATE(tgl_penjualan) = CURDATE();

    -- Menghitung total belanja
    SELECT SUM(dp.qty * p.harga_beli) INTO total_belanja
    FROM detail_penjualan dp
    INNER JOIN produk p ON dp.id_produk = p.id_produk
    INNER JOIN penjualan j ON dp.id_penjualan = j.id_penjualan
    WHERE DATE(j.tgl_penjualan) = CURDATE();

    -- Menghitung total keuntungan
    SET total_keuntungan = total_penjualan - total_belanja;

    -- Menampilkan hasil
    SELECT total_penjualan, total_belanja, total_keuntungan;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `laporan_penjualan_keuntungan_perbulan` (IN `tahun_param` INT)   BEGIN
    DECLARE bulan INT DEFAULT 1;
    DECLARE tahun INT DEFAULT tahun_param;
    DECLARE total_penjualan INT;
    DECLARE total_keuntungan INT;

    -- Loop untuk setiap bulan dalam satu tahun
    WHILE bulan <= 12 DO
        -- Menghitung total penjualan per bulan
        SELECT IFNULL(SUM(total), 0) INTO total_penjualan
        FROM penjualan
        WHERE YEAR(tgl_penjualan) = tahun AND MONTH(tgl_penjualan) = bulan;

        -- Menghitung total keuntungan per bulan
        SELECT IFNULL(SUM((dp.qty * p.harga_jual) - (dp.qty * p.harga_beli)), 0) INTO total_keuntungan
        FROM penjualan j
        INNER JOIN detail_penjualan dp ON j.id_penjualan = dp.id_penjualan
        INNER JOIN produk p ON dp.id_produk = p.id_produk
        WHERE YEAR(j.tgl_penjualan) = tahun AND MONTH(j.tgl_penjualan) = bulan;

        -- Menampilkan hasil per bulan
        SELECT bulan, tahun, total_penjualan AS total_penjualan, total_keuntungan AS total_keuntungan;

        SET bulan = bulan + 1;
    END WHILE;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `lihatProdukJual` ()   SELECT * from produk WHERE stok > 0$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `lihat_pengguna` (IN `md5Value` VARCHAR(50))   BEGIN
    SELECT *, HEX(AES_DECRYPT(UNHEX(md5Value), 'password')) AS passtext 
    FROM pengguna;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `lihat_produk` ()   SELECT produk.id_produk,produk.kode_produk,produk.nama_produk,kategori.nama_kategori,satuan.nama_satuan,
produk.harga_beli,produk.harga_jual,
produk.stok
FROM produk
JOIN satuan on satuan.id_satuan=produk.id_satuan
join kategori on kategori.id_kategori=produk.id_kategori
ORDER BY produk.stok ASC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `lihat_produk2` ()   SELECT produk.id_produk,produk.kode_produk,produk.nama_produk,kategori.nama_kategori,satuan.nama_satuan,
produk.harga_beli,produk.harga_jual,
produk.stok
FROM produk
JOIN satuan on satuan.id_satuan=produk.id_satuan
join kategori on kategori.id_kategori=produk.id_kategori
WHERE stok > 0$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `list_detail_harian` ()   SELECT penjualan.no_transaksi,produk.nama_produk,detail_penjualan.qty,
detail_penjualan.total_harga
FROM detail_penjualan
JOIN penjualan on penjualan.id_penjualan=detail_penjualan.id_penjualan
JOIN produk on produk.id_produk=detail_penjualan.id_produk
WHERE DATE(penjualan.tgl_penjualan) = CURDATE()$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `list_kategori` ()   SELECT * from kategori$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `list_member` ()   SELECT * from member$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `list_pengguna` ()   SELECT * from pengguna$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `list_satuan` ()   SELECT * FROM satuan$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `StokBarang` ()   BEGIN
    -- Deklarasi variabel untuk menyimpan hasil perhitungan
    DECLARE total_low_stock INT;

    -- Menghitung total stok produk yang memiliki stok 0 atau kurang dari 10
    SELECT COUNT(*) INTO total_low_stock
    FROM produk
    WHERE stok <= 10;

    -- Mengembalikan hasil perhitungan
    SELECT total_low_stock AS total_low_stock;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_detail` (IN `idpenjualanNya` INT, IN `idprodukNya` INT, IN `qtyNya` INT, IN `totalNya` INT)   INSERT INTO detail_penjualan(id_penjualan,id_produk,qty,total)
VALUES (idpenjualanNya,idprodukNya,qtyNya,totalNya)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_kategori` (IN `namaNya` VARCHAR(150))   BEGIN
INSERT INTO kategori (nama_kategori) VALUES (namaNya);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_member` (IN `p_nama` VARCHAR(150), IN `p_no_telp` VARCHAR(15), IN `p_alamat` TEXT)   BEGIN
    DECLARE new_id VARCHAR(13);
    DECLARE seq_number INT;
    
    -- Ambil urutan angka terakhir dari tabel (gunakan tabel yang sesuai)
    SELECT IFNULL(MAX(CAST(SUBSTRING(id_member, 6) AS UNSIGNED)), 0) + 1 INTO seq_number FROM member;

    -- Format ID dengan prefix "SCMEM" dan leading zeros
    SET new_id = CONCAT('SCMEM', LPAD(seq_number, 8, '0'));
    SET p_no_telp = CONCAT('+62', p_no_telp);
    INSERT INTO member (id_member, nama, no_telp, alamat) VALUES (new_id, p_nama, p_no_telp, p_alamat);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_pengguna` (IN `emailNya` VARCHAR(150), IN `namaNya` VARCHAR(150), IN `passwordNya` VARCHAR(50), IN `levelNya` ENUM('admin','kasir'))   INSERT INTO pengguna (email,nama,password,level)
VALUES (emailNya,namaNya,md5(passwordNya),levelNya)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_penjualan` (IN `fakturNya` VARCHAR(50), IN `tglNya` DATETIME, IN `emailNya` VARCHAR(150), IN `totalNya` INT)   INSERT INTO penjualan(no_faktur,tgl_penjualan,email,total)
VALUES (fakturNya,tglNya,emaiNya,totalNya)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_produk` (IN `kode_produk_input` VARCHAR(25), IN `nama_produk_input` VARCHAR(150), IN `id_satuan_input` INT, IN `id_kategori_input` INT, IN `harga_beli_input` INT, IN `harga_jual_input` INT, IN `stok_input` INT)   BEGIN
    -- Menghilangkan titik dari nilai harga jual
    SET harga_jual_input = REPLACE(harga_jual_input, '.', '');

    -- Menghilangkan titik dari nilai harga beli
    SET harga_beli_input = REPLACE(harga_beli_input, '.', '');

    -- Lakukan INSERT ke dalam tabel produk
    INSERT INTO produk (kode_produk, nama_produk, id_satuan, id_kategori, harga_beli, harga_jual, stok)
    VALUES (kode_produk_input, nama_produk_input, id_satuan_input, id_kategori_input, harga_beli_input, harga_jual_input, stok_input);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_produk2` (IN `kodeNya` VARCHAR(25), IN `namaNya` VARCHAR(150), IN `SatuanNya` INT, IN `KategoriNya` INT, IN `HargaBeli` INT, IN `HargaJual` INT, IN `Stok` INT)   INSERT INTO produk (kode_produk,nama_produk,id_satuan,id_kategori,harga_beli,harga_jual,stok)
VALUES (kodeNya,namaNya,SatuanNya,KategoriNya,HargaBeli,HargaJual,Stok)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_satuan` (IN `namaNya` VARCHAR(150))   BEGIN
INSERT INTO satuan (nama_satuan) VALUES (namaNya);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `TotalTransaksi` ()   SELECT COUNT(id_penjualan) AS total_penjualan
FROM penjualan
WHERE DATE(tgl_penjualan) = CURDATE()$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_kategori` (IN `idNya` INT, IN `namaNya` VARCHAR(150))   BEGIN
UPDATE kategori SET nama_kategori=namaNya
WHERE id_kategori=idNya;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_member` (IN `idNya` VARCHAR(30), IN `noNya` VARCHAR(15), IN `alamatNya` TEXT)   BEGIN
 SET noNya = CONCAT('+62', noNya);
UPDATE member SET no_telp=noNya, alamat=alamatNya 
WHERE id_member=idNya;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_password` (IN `emailNya` VARCHAR(150), IN `passwordNya` VARCHAR(50))   update pengguna set password=MD5(passwordNya) where email=emailNya$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_pengguna` (IN `emailNya` VARCHAR(150), IN `namaNya` VARCHAR(150), IN `levelNya` ENUM('admin','kasir'))   BEGIN
    UPDATE pengguna 
    SET nama = namaNya, 
            level = levelNya 
    WHERE email = emailNya;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_produk` (IN `idNya` INT, IN `kodeNya` VARCHAR(25), IN `namaNya` VARCHAR(50), IN `satuanNya` INT, IN `kategoriNya` INT)   UPDATE produk set kode_produk=kodeNya,
nama_produk=namaNya,
id_satuan=satuanNya,
id_kategori=kategoriNya
where id_produk=idNya$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_satuan` (IN `idNya` INT, IN `namaNya` VARCHAR(150))   BEGIN
UPDATE satuan SET nama_satuan=namaNya
WHERE id_satuan=idNya;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_stok` (IN `id_produk_input` INT(25), IN `harga_beli_input` INT, IN `harga_jual_input` INT, IN `stok_input` INT)   BEGIN
    -- Menghilangkan titik dari nilai harga jual
    SET harga_jual_input = REPLACE(harga_jual_input, '.', '');

    -- Menghilangkan titik dari nilai harga beli
    SET harga_beli_input = REPLACE(harga_beli_input, '.', '');

    -- Lakukan UPDATE ke dalam tabel produk berdasarkan kode_produk
    UPDATE produk 
    SET 
     
           harga_beli = harga_beli_input,
                harga_jual = harga_jual_input,
        stok = stok_input
    WHERE
        id_produk = id_produk_input;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `id_detail` int(11) NOT NULL,
  `id_penjualan` bigint(20) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `detail_penjualan`
--

INSERT INTO `detail_penjualan` (`id_detail`, `id_penjualan`, `id_produk`, `qty`, `total_harga`) VALUES
(1, 1, 8, 3, 600000),
(2, 1, 8, 3, 600000),
(3, 1, 10, 3, 900000),
(4, 1, 8, 4, 800000),
(5, 2, 8, 8, 1600000),
(6, 3, 1, 12, 310800),
(7, 3, 10, 2, 600000),
(8, 4, 6, 7, 24500),
(9, 4, 13, 1, 17000),
(10, 4, 12, 5, 400000),
(11, 4, 8, 5, 1000000),
(12, 4, 13, 2, 34000),
(13, 5, 8, 8, 1600000),
(14, 5, 9, 1, 67000),
(15, 5, 9, 8, 536000),
(16, 6, 8, 2, 400000),
(17, 7, 8, 2, 400000),
(18, 8, 8, 2, 400000),
(19, 9, 2, 2, 139000),
(20, 9, 8, 2, 400000),
(21, 10, 9, 2, 134000),
(22, 11, 8, 2, 400000),
(23, 12, 8, 1, 200000),
(24, 13, 15, 8, 16000),
(25, 13, 13, 8, 136000),
(26, 13, 14, 5, 75000),
(27, 13, 1, 5, 129500),
(28, 13, 9, 8, 536000),
(29, 14, 10, 1, 300000),
(30, 15, 9, 8, 536000),
(31, 16, 9, 1, 67000),
(32, 17, 10, 490, 147000000);

--
-- Trigger `detail_penjualan`
--
DELIMITER $$
CREATE TRIGGER `kurangiStok` AFTER INSERT ON `detail_penjualan` FOR EACH ROW UPDATE produk SET produk.stok = produk.stok - NEW.qty
WHERE produk.id_produk = NEW.id_produk
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nambahTotalHarga` AFTER INSERT ON `detail_penjualan` FOR EACH ROW UPDATE penjualan SET penjualan.total = penjualan.total + NEW.total_harga
WHERE penjualan.id_penjualan= NEW.id_penjualan
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'SNACK'),
(7, 'OBAT OBATAN'),
(8, 'PERMEN'),
(10, 'BUMBU DAPUR'),
(11, 'SEMBAKO'),
(12, 'SABUN'),
(13, 'SHAMPO'),
(14, 'ROKOK'),
(15, 'MIE');

-- --------------------------------------------------------

--
-- Struktur dari tabel `member`
--

CREATE TABLE `member` (
  `id_member` varchar(30) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `alamat` text NOT NULL,
  `poin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `email` varchar(150) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `password` varchar(50) NOT NULL,
  `level` enum('admin','kasir') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`email`, `nama`, `password`, `level`) VALUES
('admin@gmail.com', 'admin', '202cb962ac59075b964b07152d234b70', 'admin'),
('kasir@gmail.com', 'kasir', '310dcbbf4cce62f762a2aaa148d556bd', 'kasir');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` bigint(20) NOT NULL,
  `no_transaksi` varchar(50) NOT NULL,
  `tgl_penjualan` datetime NOT NULL,
  `email` varchar(150) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `no_transaksi`, `tgl_penjualan`, `email`, `total`) VALUES
(1, 'SCD2402270001', '2024-02-27 11:55:22', 'kasir@gmail.com', 2900000),
(2, 'SCD2402270002', '2024-02-27 12:04:17', 'kasir@gmail.com', 1600000),
(3, 'SCD2402270003', '2024-02-27 12:05:13', 'kasir@gmail.com', 910800),
(4, 'SCD2402270004', '2024-02-27 12:06:46', 'kasir@gmail.com', 1475500),
(5, 'SCD2402270005', '2024-02-27 12:11:54', 'kasir@gmail.com', 2203000),
(6, 'SCD2402270006', '2024-02-27 12:12:30', 'kasir@gmail.com', 400000),
(7, 'SCD2402270007', '2024-02-27 12:12:44', 'kasir@gmail.com', 400000),
(8, 'SCD2402270008', '2024-02-27 12:13:08', 'kasir@gmail.com', 400000),
(9, 'SCD2402270009', '2024-02-27 12:13:26', 'kasir@gmail.com', 539000),
(10, 'SCD2402270010', '2024-02-27 12:13:44', 'kasir@gmail.com', 134000),
(11, 'SCD2402270011', '2024-02-27 12:14:02', 'kasir@gmail.com', 400000),
(12, 'SCD2402280012', '2024-02-28 20:22:55', 'kasir@gmail.com', 200000),
(13, 'SCD2402280013', '2024-02-28 20:23:38', 'kasir@gmail.com', 892500),
(14, 'SCD2402280014', '2024-02-28 20:32:27', 'kasir@gmail.com', 300000),
(15, 'SCD2402280015', '2024-02-28 20:32:40', 'kasir@gmail.com', 536000),
(16, 'SCD2402280016', '2024-02-28 20:32:52', 'kasir@gmail.com', 67000),
(17, 'SCD2402280017', '2024-02-28 20:33:48', 'kasir@gmail.com', 147000000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `kode_produk` varchar(25) NOT NULL,
  `nama_produk` varchar(150) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `id_satuan` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `kode_produk`, `nama_produk`, `harga_beli`, `harga_jual`, `id_satuan`, `id_kategori`, `stok`) VALUES
(1, '8394880003234', 'MAKARIZO ALOE & MELON EXTRACT 170 ML', 20000, 25900, 3, 13, 183),
(2, '9958896122304', 'BERAS RAMOS 5 KG', 60000, 69500, 3, 11, 58),
(5, '29394589069', 'INDOMIE AYAM BAWANG', 2000, 3500, 3, 15, 500),
(6, '774858940590', 'INDOMIE ACEH', 2000, 3500, 3, 15, 493),
(7, '99304959680', 'INDOMIE GORENG ', 50000, 75000, 1, 15, 100),
(8, '49968697895869', 'INDOMIE RENDANG', 100000, 200000, 1, 15, 458),
(9, '989900909', 'INDOMIE AYAM GEPREK', 50000, 67000, 1, 15, 472),
(10, '39490595609', 'INDOMIE KARI AYAM', 200000, 300000, 1, 15, 4),
(11, '99505960597969', 'INDOMIE SAMBAL MATAH', 56000, 70000, 1, 15, 500),
(12, '89990098999897', 'INDOMIE SOTO', 57000, 80000, 1, 15, 495),
(13, '88596079784', 'HEAD & SHOULDERS ANTI KETOMBE 170 ML', 15000, 17000, 3, 13, 89),
(14, '88459966896', 'SUNSLIK HIJAB 170ML', 12000, 15000, 3, 13, 95),
(15, '88997477777', 'CITATO', 1000, 2000, 3, 1, 12);

-- --------------------------------------------------------

--
-- Struktur dari tabel `satuan`
--

CREATE TABLE `satuan` (
  `id_satuan` int(11) NOT NULL,
  `nama_satuan` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `satuan`
--

INSERT INTO `satuan` (`id_satuan`, `nama_satuan`) VALUES
(1, 'pak'),
(3, 'pcs'),
(4, 'kodi'),
(5, 'lusin'),
(6, 'renceng');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_produk` (`id_produk`),
  ADD KEY `id_penjualan` (`id_penjualan`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id_member`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD KEY `email` (`email`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `id_satuan` (`id_satuan`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id_satuan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id_satuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
