-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 29 Mar 2024, 18:21:32
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `umuttepe_turizm`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `adminKodu` varchar(50) NOT NULL,
  `adminAdi` varchar(35) DEFAULT NULL,
  `adminKullaniciAdi` varchar(30) DEFAULT NULL,
  `adminSifre` varchar(256) DEFAULT NULL,
  `adminFoto` varchar(35) DEFAULT NULL,
  `adminEmail` varchar(35) DEFAULT NULL,
  `adminSeviye` varchar(12) DEFAULT NULL,
  `adminDurum` int(1) DEFAULT NULL,
  `adminOlusturmaTarihi` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Tablo döküm verisi `tbl_admin`
--

INSERT INTO `tbl_admin` (`adminKodu`, `adminAdi`, `adminKullaniciAdi`, `adminSifre`, `adminFoto`, `adminEmail`, `adminSeviye`, `adminDurum`, `adminOlusturmaTarihi`) VALUES
('ADM0001', 'Administrator', 'admin', '$2y$10$nvmCaXC4Ohua5eW4fFAMauISafgwvPsoRXVNnToZpbF4vWfBw.xvu', 'assets/backend/img/default.png', 'adm@gmail.com', '2', 1, '1552276812'),
('ADM0002', 'Second Admin', 'admin2', '$2y$10$ADbNVZYgiDi8SqGl1bB2NOgCufT2sK5v/T3BSZcIpFPVljDSb2S2K', 'assets/backend/img/default.png', 'secadm@gmail.com', '1', 1, '1552819095'),
('ADM0003', 'BS Owner', 'owner', '$2y$10$nvmCaXC4Ohua5eW4fFAMauISafgwvPsoRXVNnToZpbF4vWfBw.xvu', 'assets/backend/img/default.png', 'owner@gmail.com', '1', 1, '1552819095');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tbl_altmenu`
--

CREATE TABLE `tbl_altmenu` (
  `altMenuKodu` int(11) NOT NULL,
  `menuKodu` int(11) DEFAULT NULL,
  `altMenuBasligi` varchar(128) DEFAULT NULL,
  `altMenuUrl` varchar(128) DEFAULT NULL,
  `altMenuAktifmi` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Tablo döküm verisi `tbl_altmenu`
--

INSERT INTO `tbl_altmenu` (`altMenuKodu`, `menuKodu`, `altMenuBasligi`, `altMenuUrl`, `altMenuAktifmi`) VALUES
(0, 1, 'Dashboard', 'backend/home', '1');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tbl_banka`
--

CREATE TABLE `tbl_banka` (
  `bankaKodu` varchar(50) NOT NULL,
  `bankaMusteri` varchar(50) DEFAULT NULL,
  `bankaAdi` varchar(50) DEFAULT NULL,
  `bankaHesapNo` varchar(50) DEFAULT NULL,
  `bankaFoto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Tablo döküm verisi `tbl_banka`
--

INSERT INTO `tbl_banka` (`bankaKodu`, `bankaMusteri`, `bankaAdi`, `bankaHesapNo`, `bankaFoto`) VALUES
('BNK0001', 'GB', 'Garanti Bankasi', '600000521', 'assets/frontend/img/bank/garanti_bankasi.png'),
('BNK0002', 'ZB', 'Ziraat Bankasi', '107556540', 'assets/frontend/img/bank/ziraat_bankasi.png'),
('BNK0003', 'VB', 'Vakifbank', '800140000', 'assets/frontend/img/bank/vakifbank.png'),
('BNK0004', 'YB', 'Yapikredi Bankasi', '300124589', 'assets/frontend/img/bank/yapikredi_bankasi.png'),
('BNK0005', '?B', '?s Bankasi', '100025001', '/assets/frontend/img/bank/is_bankasi.png'),
('BNK0001', 'GB', 'Garanti Bankasi', '600000521', 'assets/frontend/img/bank/garanti_bankasi.png'),
('BNK0002', 'ZB', 'Ziraat Bankasi', '107556540', 'assets/frontend/img/bank/ziraat_bankasi.png'),
('BNK0003', 'VB', 'Vakifbank', '800140000', 'assets/frontend/img/bank/vakifbank.png'),
('BNK0004', 'YB', 'Yapikredi Bankasi', '300124589', 'assets/frontend/img/bank/yapikredi_bankasi.png'),
('BNK0005', '?B', '?s Bankasi', '100025001', '/assets/frontend/img/bank/is_bankasi.png');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tbl_bilet`
--

CREATE TABLE `tbl_bilet` (
  `biletKodu` varchar(50) NOT NULL,
  `rezervasyonKodu` varchar(50) DEFAULT NULL,
  `biletAdi` varchar(50) DEFAULT NULL,
  `biletKoltuk` varchar(50) DEFAULT NULL,
  `biletYas` varchar(50) DEFAULT NULL,
  `satinAlinanBilet` varchar(50) DEFAULT NULL,
  `biletFiyati` varchar(50) NOT NULL,
  `biletEtiket` varchar(100) DEFAULT NULL,
  `biletDurum` varchar(50) NOT NULL,
  `biletOlusturmaTarihi` date DEFAULT NULL,
  `biletOlusturmaYoneticisi` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Tablo döküm verisi `tbl_bilet`
--

INSERT INTO `tbl_bilet` (`biletKodu`, `rezervasyonKodu`, `biletAdi`, `biletKoltuk`, `biletYas`, `satinAlinanBilet`, `biletFiyati`, `biletEtiket`, `biletDurum`, `biletOlusturmaTarihi`, `biletOlusturmaYoneticisi`) VALUES
('TORD00001J00012022122915', 'ORD00001', 'Elif Aydin', '15', '31 Yas', 'UT013', '68', 'assets/backend/upload/etiket/ORD00001.pdf', '2', '2022-12-28', 'admin'),
('TORD00002J00012022123018', 'ORD00002', 'Anil Günes', '18', '30 Yas', 'UT013', '68', 'assets/backend/upload/etiket/ORD00002.pdf', '2', '2022-12-29', 'owner'),
('TORD00004J00052022123110', 'ORD00004', 'Derya Isik', '10', '32 Yas', 'UT010', '40', 'assets/backend/upload/etiket/ORD00004.pdf', '2', '2022-12-30', 'admin'),
('TORD00005J0003202212318', 'ORD00005', 'Rasim Demir', '8', '32 Yas', 'UT005', '89', 'assets/backend/upload/etiket/ORD00005.pdf', '2', '2022-12-30', 'owner'),
('TORD00005J0003202212319', 'ORD00005', 'Can Demir', '9', '35 Yas', 'UT005', '89', 'assets/backend/upload/etiket/ORD00005.pdf', '2', '2022-12-30', 'owner'),
('TORD00006J00012022123123', 'ORD00006', 'Ceren Bulut', '23', '25 Yas', 'UT013', '68', 'assets/backend/upload/etiket/ORD00006.pdf', '2', '2022-12-30', 'owner'),
('TORD00007J0015202301023', 'ORD00007', 'Dilara Tas', '3', '39 Yas', 'UT007', '40', 'assets/backend/upload/etiket/ORD00007.pdf', '2', '2022-12-30', 'owner'),
('TORD00008J00172023010122', 'ORD00008', 'Ahmet Aslan', '22', '41 Yas', 'UT003', '59', 'assets/backend/upload/etiket/ORD00008.pdf', '2', '2022-12-30', 'owner'),
('TORD00010J00132023010514', 'ORD00010', 'Tugba Sen', '14', '34 Yas', 'UT008', '82', 'assets/backend/upload/etiket/ORD00010.pdf', '2', '2022-12-30', 'owner'),
('TORD00013J00022022123114', 'ORD00013', 'Veysel Atmaca', '14', '31 Yas', 'UT004', '75', 'assets/backend/upload/etiket/ORD00013.pdf', '2', '2022-12-30', 'owner');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tbl_dogrulama`
--

CREATE TABLE `tbl_dogrulama` (
  `dogrulamaKodu` varchar(50) NOT NULL,
  `rezervasyonKodu` varchar(50) DEFAULT NULL,
  `dogrulamaAdi` varchar(50) DEFAULT NULL,
  `dogrulamaBankaAdi` varchar(50) DEFAULT NULL,
  `dogrulamaHesapNo` varchar(50) DEFAULT NULL,
  `dogrulamaToplam` varchar(50) DEFAULT NULL,
  `dogrulamaFoto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Tablo döküm verisi `tbl_dogrulama`
--

INSERT INTO `tbl_dogrulama` (`dogrulamaKodu`, `rezervasyonKodu`, `dogrulamaAdi`, `dogrulamaBankaAdi`, `dogrulamaHesapNo`, `dogrulamaToplam`, `dogrulamaFoto`) VALUES
('KF0001', 'ORD00001', 'Elif Aydin', 'Halkbank', '197777450', '68', '/assets/frontend/upload/payment/sample_image.jpg'),
('KF0002', 'ORD00002', 'Anil Günes', 'Denizbank', '701111458', '68', '/assets/frontend/upload/payment/sample_image.jpg'),
('KF0003', 'ORD00004', 'Derya Isik', 'Halkbank', '1000008569', '40', '/assets/frontend/upload/payment/sample_image.jpg'),
('KF0004', 'ORD00005', 'Rasim Demir', 'Akbank', '001114547', '178', '/assets/frontend/upload/payment/sample_image.jpg'),
('KF0005', 'ORD00006', 'Ceren Bulut', 'Denizbank', '100045855', '68', '/assets/frontend/upload/payment/sample_image.jpg'),
('KF0006', 'ORD00007', 'Dilara Tas', 'Finansbank', '1007452', '40', '/assets/frontend/upload/payment/sample_image.jpg'),
('KF0007', 'ORD00008', 'Ahmet Aslan', 'Akbank', '20145002', '59', '/assets/frontend/upload/payment/sample_image.jpg'),
('KF0008', 'ORD00009', 'Meryem Su', 'Finansbank', '0144520', '64', '/assets/frontend/upload/payment/sample_image.jpg'),
('KF0009', 'ORD00010', 'Tugba Sen', 'Denizbank', '100045802', '82', '/assets/frontend/upload/payment/sample_image.jpg'),
('KF0010', 'ORD00012', 'Serhat Sahin', 'Finansbank', '10102257', '75', '/assets/frontend/upload/payment/sample_image.jpg'),
('KF0011', 'ORD00013', 'Veysel Atmaca', 'Halkbank', '1000478', '75', '/assets/frontend/upload/payment/sample_image.jpg');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tbl_erisimmenusu`
--

CREATE TABLE `tbl_erisimmenusu` (
  `erisimMenusuKodu` int(11) DEFAULT NULL,
  `seviyeKodu` int(11) DEFAULT NULL,
  `menuKodu` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Tablo döküm verisi `tbl_erisimmenusu`
--

INSERT INTO `tbl_erisimmenusu` (`erisimMenusuKodu`, `seviyeKodu`, `menuKodu`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 2),
(1, 1, 1),
(2, 1, 2),
(3, 2, 2),
(1, 1, 1),
(2, 1, 2),
(3, 2, 2),
(1, 1, 1),
(2, 1, 2),
(3, 2, 2);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tbl_menu`
--

CREATE TABLE `tbl_menu` (
  `menuKodu` int(11) NOT NULL,
  `menuAdi` varchar(50) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Tablo döküm verisi `tbl_menu`
--

INSERT INTO `tbl_menu` (`menuKodu`, `menuAdi`) VALUES
(1, 'owner'),
(2, 'administrator');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tbl_musteri`
--

CREATE TABLE `tbl_musteri` (
  `musteriKodu` varchar(50) NOT NULL,
  `musteriKullaniciAdi` varchar(50) NOT NULL,
  `musteriSifre` varchar(200) NOT NULL,
  `musteriNo` varchar(50) NOT NULL,
  `musteriAdi` varchar(100) NOT NULL,
  `musteriAdres` varchar(200) NOT NULL,
  `musteriEmail` varchar(100) NOT NULL,
  `musteriTelefon` varchar(20) NOT NULL,
  `musteriFoto` varchar(200) NOT NULL,
  `musteriDurum` int(1) DEFAULT NULL,
  `musteriOlusturmaTarihi` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Tablo döküm verisi `tbl_musteri`
--

INSERT INTO `tbl_musteri` (`musteriKodu`, `musteriKullaniciAdi`, `musteriSifre`, `musteriNo`, `musteriAdi`, `musteriAdres`, `musteriEmail`, `musteriTelefon`, `musteriFoto`, `musteriDurum`, `musteriOlusturmaTarihi`) VALUES
('CA0002', 'betul', '$2y$10$wzz5.QSqiNfrc2JKuYK5huJHEvry340XZlspPACOJLf0TmU3yu30.', '02564651321564', 'Betül Keskin', 'Keskin Sokak', 'betul@mail.com', '7014445450', 'assets/frontend/img/default.png', 1, '1552202266'),
('CA0001', 'osman', '$2y$10$PO4viVqheGgw7HPeozUih.V6qK4aWKbACLMe9UWOoSaJ8pSdaiISG', '021452125', 'Osman Öz', 'Öz Caddesi', 'osman@mail.com', '0455658500', 'assets/frontend/img/default.png', 1, '1552199781'),
('CA0003', 'pelin', '$2y$10$N6imN8KmAhuw9rH.iJxGLeVaRCG.27UmhHVF7MaICMhYlm.TGJ9iy', '346454215172455', 'Pelin Çay', 'Çay Sokak', 'pelin@mail.com', '9458001455', 'assets/frontend/img/default.png', 1, '1552397128'),
('CA0005', 'recep', '$2y$10$PYDzqnOpzeGSo0ngK40Q1.M77oxnQ7fvhMYpI2q/JoZFS5r.g5FPG', '321963127368762639', 'Recep Tekin', 'Tekin Sokak', 'recep@mail.com', '0147410147', 'assets/frontend/img/default.png', 1, '1554340197'),
('CA0004', 'damla', '$2y$10$hHamfvIRbCNYiAvS289f0uj.T6kUfpfxTUcI210SLRqdTrxj4zyxG', '78456', 'Damla Göl', 'Göl Caddesi', 'damla@mail.com', '021212545', 'assets/frontend/img/default.png', 1, '1554017732'),
('CA0006', 'ayse', '$2y$10$pwr/ZSCVcya8JOV1Xt13qeRzhz.nLsJGWYcWWZJgR5DFLUfjJeaGO', '', 'Ayse DaG', 'DaG Caddesi', 'ayse@mail.com', '0978542255', 'assets/frontend/img/default.png', 1, '1554385261'),
('06UT06', 'hande', '$2y$10$Z7yJqwWa0pCPtGb5sVYf9epvdjT97BD9U4guma.EhKU3JS9H675lG', '', 'Hande Kaya', 'Kaya Sokak', 'hande@mail.com', '0898765345', 'assets/frontend/img/default.png', 1, '1554534514'),
('CA0008', 'demoaccount', '$2y$10$N1GVdIFWQ967xcLsVEb1ROH1ESfMew4mqjHoGSGIJ/0Qsf9oO/xOO', '', 'Demo Hesap', 'Demo Adres', 'demo@mail.com', '7000000020', 'assets/frontend/img/default.png', 1, '1634359787'),
('CA0009', 'behzat', '$2y$10$2HJ6mUfIPHpJ87BKQEv7YuMjT8nX9W8CJFqG5jAnekEJhJMv2MFGy', '', 'Behzat Yilmaz', 'Yilmaz Caddesi', 'behzat@mail.com', '7778885540', 'assets/frontend/img/default.png', 1, '1642506186'),
('CA0010', 'cengiz', '$2y$10$Al3FDFQOSTQEQBvnQc45fe8NHRQ5OtGkgF6LnYplEzJqMEfy2Au0q', '', 'Cengiz Beyaz', 'Beyaz Sokak', 'cengiz@mail.com', '7774445454', 'assets/frontend/img/default.png', 1, '1672227893'),
('CA0011', 'elif', '$2y$10$I5m6NM5hPzyeAS5cT6CBtuD5Xc5xSJytC6GOu.51LsLkdi/7UPZz.', '', 'Elif Aydin', 'Aydin Sokak', 'elifaydin@mail.com', '7774545555', 'assets/frontend/img/default.png', 1, '1672229233'),
('CA0012', 'anil', '$2y$10$sFXYN8pGoGA24LwQrHuBW.uQuOWuVzcNu0yRbqaBgEDJq0OZRThCq', '', 'Anil Günes', 'Günes Caddesi', 'anil@mail.com', '7458885454', 'assets/frontend/img/default.png', 1, '1672235116'),
('CA0013', 'mehmet', '$2y$10$C5Faofquq/6Sckw0ERuLK.6qXSAFQpU1QMDuAU/UWglUN4X6mJYSi', '', 'Mehmet Deniz', 'Deniz Sokak', 'mehmet@mail.com', '7778545699', 'assets/frontend/img/default.png', 1, '1672247531'),
('CA0014', 'derya', '$2y$10$H/24vkHCSs2vLXxiwwUEq.7sUYSeT61wU18PSAbfIHz63HisAFD6K', '', 'Derya Isik', 'Isik Sokak', 'derya@mail.com', '7850001414', 'assets/frontend/img/default.png', 1, '1672333316'),
('CA0015', 'rasim', '$2y$10$WDBh38OmnT.3v2.7sQ/8C./0mGMUIRLsXTzZlJeWGgWBTEQPq6Gou', '', 'Rasim Demir', 'Zeytin Sokak', 'rasim@mail.com', '7854545454', 'assets/frontend/img/default.png', 1, '1672336612'),
('CA0016', 'ceren', '$2y$10$IRBkQQZ4Kw5iKu7bsOwkA.5D3xj9mbCKA0Lvo3myKwmJvKrhZHsIS', '', 'Ceren Bulut', 'Bulut Caddesi', 'ceren@mail.com', '7350001455', 'assets/frontend/img/default.png', 1, '1672388181'),
('CA0017', 'dilara', '$2y$10$R5EOyPHwynjwPkzZEwUKjO/YwAdhsaGVIvUEyvgTygTd19G3qHhkC', '', 'Dilara Tas', 'Tas Sokak', 'dilara@mail.com', '7450001010', 'assets/frontend/img/default.png', 1, '1672401155'),
('CA0018', 'ahmet', '$2y$10$qIBv6Y2PnV4AqV5kG3M6gO4UzfvkFiMAvXcPJT.D1igRkQd8uuMu.', '', 'Ahmet Aslan', 'Aslan Caddesi', 'ahmet@mail.com', '7312580010', 'assets/frontend/img/default.png', 1, '1672401850'),
('CA0019', 'meryem', '$2y$10$KokpNWTZSwXXLDpjqZXWgekm7Oi3E2gKF1Iaui0dsG9a.KD4FMBBC', '', 'Meryem Su', 'selale Sokak', 'meryem@mail.com', '7412555545', 'assets/frontend/img/default.png', 1, '1672402552'),
('CA0020', 'tugba', '$2y$10$qQbkAXlNKDPmAJQQpmxDOOxVpuEZUs/DS.49ukgekOwzXhBwrFS.O', '', 'TuGba sen', 'sen Caddesi', 'tugba@mail.com', '7140002569', 'assets/frontend/img/default.png', 1, '1672402730'),
('CA0021', 'arda', '$2y$10$ovPI98iJNIbf8XKzPzy3.e7pQKf4OooU/QoAEXlwxC3e8N42ZUWNG', '', 'Arda Kurt', 'Kurt Sokak', 'arda@mail.com', '7410140025', 'assets/frontend/img/default.png', 1, '1672414382'),
('CA0022', 'serhat', '$2y$10$FNs3qmXmq.fM/lwmCEdnG.dq8FJ2HNnZAFQ6Z9crWGUZYvJ3E3CBG', '', 'Serhat sahin', 'sahin Sokak', 'serhat@mail.com', '4501450000', 'assets/frontend/img/default.png', 1, '1672414504'),
('CA0023', 'veysel', '$2y$10$oU/PX/oEKmoxbUHJQvtKmOHYktfhyROtQYbwHUJiMVi.nCH49wgfG', '', 'Veysel Atmaca', 'Atmaca Sokak', 'veysel@mail.com', '7014698500', 'assets/frontend/img/default.png', 1, '1672417879');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tbl_musteritoken`
--

CREATE TABLE `tbl_musteritoken` (
  `tokenKodu` int(11) NOT NULL,
  `tokenAdi` varchar(256) DEFAULT NULL,
  `tokenEmail` varchar(50) DEFAULT NULL,
  `tokenOlusturmaTarihi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Tablo döküm verisi `tbl_musteritoken`
--

INSERT INTO `tbl_musteritoken` (`tokenKodu`, `tokenAdi`, `tokenEmail`, `tokenOlusturmaTarihi`) VALUES
(1, '65a01b40a0cc44076458f9d00ce94720', 'demo@mail.com', 1634359787),
(2, 'dd79d52fe9968f73fc66a1d481778655', 'halit@mail.com', 1642506186),
(3, 'cd7b785a63c58898bfed23bab186ee1d', 'gorkem@mail.com', 1672227893),
(4, '616b4176a96b190073514fd3c154c2e0', 'zeynep@mail.com', 1672229234),
(5, '87702b38ef9a5b80a98c077c43073182', 'demo2@mail.com', 1672235116);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tbl_otobus`
--

CREATE TABLE `tbl_otobus` (
  `otobusKodu` varchar(50) NOT NULL,
  `otobusAdi` varchar(50) DEFAULT NULL,
  `otobusPlakasi` varchar(50) DEFAULT NULL,
  `otobusKapasitesi` int(13) DEFAULT NULL,
  `otobusDurumu` int(1) DEFAULT NULL,
  `descOtobus` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Tablo döküm verisi `tbl_otobus`
--

INSERT INTO `tbl_otobus` (`otobusKodu`, `otobusAdi`, `otobusPlakasi`, `otobusKapasitesi`, `otobusDurumu`, `descOtobus`) VALUES
('B001', 'Umuttepe Turizm', '41UT41', 46, 1, '--'),
('B002', 'Umuttepe Turizm', '34UT34', 46, 1, '--'),
('B003', 'Umuttepe Turizm', '07UT07', 46, 1, '--'),
('B004', 'Umuttepe Turizm', '06UT06', 46, 1, '--'),
('B005', 'Umuttepe Turizm', '09UT09', 46, 1, '--'),
('B006', 'Umuttepe Turizm', '48UT48', 46, 1, '--'),
('B007', 'Umuttepe Turizm', '27UT27', 46, 1, NULL),
('B008', 'Umuttepe Turizm', '26UT26', 46, 1, NULL),
('B009', 'Umuttepe Turizm', '61UT61', 46, 1, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tbl_rezervasyon`
--

CREATE TABLE `tbl_rezervasyon` (
  `rezervasyonID` int(11) NOT NULL,
  `rezervasyonKodu` varchar(50) DEFAULT NULL,
  `biletKodu` varchar(50) DEFAULT NULL,
  `saatKodu` varchar(50) DEFAULT NULL,
  `musteriKodu` varchar(50) DEFAULT NULL,
  `bankaKodu` varchar(50) DEFAULT NULL,
  `rezervasyonTerminali` varchar(200) DEFAULT NULL,
  `rezervasyonSahibi` varchar(50) DEFAULT NULL,
  `rezervasyonTarihi` varchar(50) DEFAULT NULL,
  `rezervasyonYapilanTarih` varchar(50) DEFAULT NULL,
  `koltukSahibiAdi` varchar(50) DEFAULT NULL,
  `koltukSahibiYasi` varchar(50) DEFAULT NULL,
  `koltukSahibiNo` varchar(50) DEFAULT NULL,
  `koltukSahibiTakipNo` varchar(50) DEFAULT NULL,
  `koltukSahibiTelNo` varchar(50) DEFAULT NULL,
  `koltukSahibiAdresi` varchar(100) DEFAULT NULL,
  `koltukSahibiEmail` varchar(100) DEFAULT NULL,
  `rezervasyonSonGecerlilik` varchar(50) DEFAULT NULL,
  `rezervasyonQrCode` varchar(100) DEFAULT NULL,
  `rezervasyonDurumu` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Tablo döküm verisi `tbl_rezervasyon`
--

INSERT INTO `tbl_rezervasyon` (`rezervasyonID`, `rezervasyonKodu`, `biletKodu`, `saatKodu`, `musteriKodu`, `bankaKodu`, `rezervasyonTerminali`, `rezervasyonSahibi`, `rezervasyonTarihi`, `rezervasyonYapilanTarih`, `koltukSahibiAdi`, `koltukSahibiYasi`, `koltukSahibiNo`, `koltukSahibiTakipNo`, `koltukSahibiTelNo`, `koltukSahibiAdresi`, `koltukSahibiEmail`, `rezervasyonSonGecerlilik`, `rezervasyonQrCode`, `rezervasyonDurumu`) VALUES
(25, 'ORD00001', 'TORD00001J00012022122915', 'J0001', 'PL0011', 'BNK0004', 'UT013', 'Elif Aydin', 'Çarsamba, 28 Aralik 2022, 20:01', '2022-12-29', 'Elif Aydin', '31', '15', '101111458666', '7774545555', 'Aydin Sokak', 'elifaydin@mail.com', '29-12-2022 20:01:02', 'assets/frontend/upload/qrcode/ORD00001.png', '2'),
(26, 'ORD00002', 'TORD00002J00012022123018', 'J0001', 'PL0012', 'BNK0004', 'UT013', 'Anil Günes', 'Çarsamba, 28 Aralik 2022, 20:49', '2022-12-30', 'Anil Günes', '30', '18', '201145896969', '7458885454', 'Günes Caddesi', 'anilgunes@mail.com', '29-12-2022 20:49:15', 'assets/frontend/upload/qrcode/ORD00002.png', '2'),
(27, 'ORD00003', 'TORD00003J00052022123020', 'J0005', 'PL0013', 'BNK0002', 'UT010', 'Mehmet Deniz', 'Persembe, 29 Aralik 2022, 00:25', '2022-12-30', 'Mehmet Deniz', '26', '20', '6014561UT612', '7778545699', 'Deniz Sokak', 'mehmet@mail.com', '30-12-2022 00:25:58', 'assets/frontend/upload/qrcode/ORD00003.png', '1'),
(28, 'ORD00004', 'TORD00004J00052022123110', 'J0005', 'PL0014', 'BNK0003', 'UT010', 'Derya Isik', 'Cuma, 30 Aralik 2022, 00:06', '2022-12-31', 'Derya Isik', '32', '10', '201010105580', '7850001414', 'Isik Sokak', 'derya@mail.com', '31-12-2022 00:06:42', 'assets/frontend/upload/qrcode/ORD00004.png', '2'),
(29, 'ORD00005', 'TORD00005J0003202212318', 'J0003', 'PL0015', 'BNK0004', 'UT005', 'Rasim Demir', 'Cuma, 30 Aralik 2022, 00:58', '2022-12-31', 'Rasim Demir', '32', '8', '012256669874', '7854545454', 'Zeytin Sokak', 'rasim@mail.com', '31-12-2022 00:58:12', 'assets/frontend/upload/qrcode/ORD00005.png', '2'),
(30, 'ORD00005', 'TORD00005J0003202212319', 'J0003', 'PL0015', 'BNK0004', 'UT005', 'Rasim Demir', 'Cuma, 30 Aralik 2022, 00:58', '2022-12-31', 'Can Demir', '35', '9', '012256669874', '7854545454', 'Zeytin Sokak', 'rasim@mail.com', '31-12-2022 00:58:12', 'assets/frontend/upload/qrcode/ORD00005.png', '2'),
(31, 'ORD00006', 'TORD00006J00012022123123', 'J0001', 'CA0016', 'BNK0002', 'UT013', 'Ceren Bulut', 'Cuma, 30 Aralik 2022, 15:27', '2022-12-31', 'Ceren Bulut', '25', '23', '700014520019', '7350001455', 'Bulut Caddesi', 'ceren@mail.com', '31-12-2022 15:27:55', 'assets/frontend/upload/qrcode/ORD00006.png', '2'),
(32, 'ORD00007', 'TORD00007J0015202301023', 'J0015', 'CA0017', 'BNK0005', 'UT007', 'Dilara Tas', 'Cuma, 30 Aralik 2022, 18:53', '2023-01-02', 'Dilara Tas', '39', '3', '30222245', '7450001010', 'Tas Sokak', 'dilara@mail.com', '31-12-2022 18:53:59', 'assets/frontend/upload/qrcode/ORD00007.png', '2'),
(33, 'ORD00008', 'TORD00008J00172023010122', 'J0017', 'CA0018', 'BNK0001', 'UT003', 'Ahmet Aslan', 'Cuma, 30 Aralik 2022, 19:06', '2023-01-01', 'Ahmet Aslan', '41', '22', '3012552', '7312580010', 'Aslan Caddesi', 'ahmet@mail.com', '31-12-2022 19:06:33', 'assets/frontend/upload/qrcode/ORD00008.png', '2'),
(34, 'ORD00009', 'TORD00009J0010202212315', 'J0010', 'CA0019', 'BNK0001', 'UT009', 'Meryem Su', 'Cuma, 30 Aralik 2022, 19:17', '2022-12-31', 'Meryem Su', '38', '5', '10102258', '7412555545', 'Selale Sokak', 'meryem@mail.com', '31-12-2022 19:17:38', 'assets/frontend/upload/qrcode/ORD00009.png', '1'),
(35, 'ORD00010', 'TORD00010J00132023010514', 'J0013', 'CA0020', 'BNK0003', 'UT008', 'Tugba Sen', 'Cuma, 30 Aralik 2022, 19:20', '2023-01-05', 'Tugba Sen', '34', '14', '1074450', '7140002569', 'Sen Caddesi', 'tugba@mail.com', '31-12-2022 19:20:23', 'assets/frontend/upload/qrcode/ORD00010.png', '2'),
(36, 'ORD00011', 'TORD00011J00162023011211', 'J0016', 'CA0021', 'BNK0005', 'UT007', 'Arda Kurt', 'Cuma, 30 Aralik 2022, 22:34', '2023-01-12', 'Arda Kurt', '25', '11', '2014580', '7410140025', 'Kurt Sokak', 'arda@mail.com', '31-12-2022 22:34:09', 'assets/frontend/upload/qrcode/ORD00011.png', '1'),
(37, 'ORD00012', 'TORD00012J0002202301039', 'J0002', 'CA0022', 'BNK0002', 'UT004', 'Serhat Sahin', 'Cuma, 30 Aralik 2022, 22:35', '2023-01-03', 'Serhat sahin', '39', '9', '12000045', '4501450000', 'Sahin Sokak', 'serhat@mail.com', '31-12-2022 22:35:57', 'assets/frontend/upload/qrcode/ORD00012.png', '1'),
(38, 'ORD00013', 'TORD00013J00022022123114', 'J0002', 'CA0023', 'BNK0004', 'UT004', 'Veysel Atmaca', 'Cuma, 30 Aralik 2022, 23:40', '2022-12-31', 'Veysel Atmaca', '31', '14', '10145007', '7014698500', 'Atmaca Sokak', 'veysel@mail.com', '31-12-2022 23:40:37', 'assets/frontend/upload/qrcode/ORD00013.png', '2'),
(39, 'ORD00014', 'TORD00014J00132023010420', 'J0013', 'CA0023', 'BNK0005', 'UT008', 'Veysel Atmaca', 'Cuma, 30 Aralik 2022, 23:55', '2023-01-04', 'Veysel Atmaca', '42', '20', '10002584', '7014698500', 'Atmaca Sokak', 'veysel@mail.com', '31-12-2022 23:55:26', 'assets/frontend/upload/qrcode/ORD00014.png', '1'),
(40, 'ORD00014', 'TORD00014J00132023010421', 'J0013', 'CA0023', 'BNK0005', 'UT008', 'Veysel Atmaca', 'Cuma, 30 Aralik 2022, 23:55', '2023-01-04', 'Veysel Atmaca', '31', '21', '10002584', '7014698500', 'Atmaca Sokak', 'veysel@mail.com', '31-12-2022 23:55:26', 'assets/frontend/upload/qrcode/ORD00014.png', '1');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tbl_saat`
--

CREATE TABLE `tbl_saat` (
  `saatKodu` varchar(50) NOT NULL,
  `otobusKodu` varchar(50) DEFAULT NULL,
  `sehirKodu` varchar(50) DEFAULT NULL,
  `terminalKodu` varchar(50) DEFAULT NULL,
  `bolgeAdi` varchar(50) DEFAULT NULL,
  `kalkisSaati` time DEFAULT NULL,
  `varisSaati` time DEFAULT NULL,
  `fiyatTarifesi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Tablo döküm verisi `tbl_saat`
--

INSERT INTO `tbl_saat` (`saatKodu`, `otobusKodu`, `sehirKodu`, `terminalKodu`, `bolgeAdi`, `kalkisSaati`, `varisSaati`, `fiyatTarifesi`) VALUES
('J0001', 'B001', 'UT004', 'UT013', 'Izmir', '07:00:00', '11:15:00', '68'),
('J0002', 'B009', 'UT002', 'UT004', 'Kocaeli', '09:00:00', '01:50:00', '75'),
('J0003', 'B002', 'UT006', 'UT005', 'Aydin', '11:30:00', '05:30:00', '89'),
('J0004', 'B001', 'UT013', 'UT001', 'Eskisehir', '09:00:00', '10:30:00', '29'),
('J0005', 'B005', 'UT008', 'UT010', 'Mugla', '08:00:00', '11:45:00', '40'),
('J0006', 'B001', 'UT006', 'UT004', 'Aydin', '08:30:00', '04:15:00', '109'),
('J0007', 'B003', 'UT011', 'UT013', 'Çanakkale', '10:00:00', '11:00:00', '17'),
('J0008', 'B009', 'UT003', 'UT002', 'Istanbul', '08:45:00', '01:55:00', '47'),
('J0009', 'B002', 'UT013', 'UT001', 'Eskisehir', '09:45:00', '11:45:00', '33'),
('J0010', 'B006', 'UT007', 'UT009', 'Antalya', '07:30:00', '02:00:00', '64'),
('J0011', 'B001', 'UT002', 'UT010', 'Kocaeli', '09:00:00', '11:45:00', '28'),
('J0012', 'B005', 'UT011', 'UT006', 'Çanakkale', '08:45:00', '11:50:00', '40'),
('J0013', 'B003', 'UT013', 'UT008', 'Eskisehir', '09:00:00', '04:15:00', '82'),
('J0014', 'B001', 'UT011', 'UT007', 'Çanakkale', '07:30:00', '06:00:00', '119'),
('J0015', 'B005', 'UT013', 'UT007', 'Eskisehir', '10:45:00', '02:45:00', '40'),
('J0016', 'B005', 'UT004', 'UT007', 'Izmir', '09:15:00', '01:00:00', '30'),
('J0017', 'B004', 'UT011', 'UT003', 'Çanakkale', '08:50:00', '01:55:00', '59'),
('J0018', 'B007', 'UT011', 'UT009', 'Çanakkale', '09:00:00', '11:30:00', '27'),
('J0019', 'B009', 'UT013', 'UT009', 'Eskisehir', '08:30:00', '11:50:00', '39'),
('J0020', 'B009', 'UT006', 'UT009', 'Aydin', '10:30:00', '03:10:00', '57'),
('J0021', 'B008', 'UT010', 'UT012', 'Samsun', '08:45:00', '01:00:00', '53'),
('J0022', 'B006', 'UT013', 'UT010', 'Eskisehir', '06:30:00', '09:45:00', '38'),
('J0023', 'B002', 'UT004', 'UT012', 'Izmir', '07:00:00', '11:55:00', '42'),
('J0024', 'B002', 'UT010', 'UT002', 'Samsun', '08:00:00', '10:30:00', '30');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tbl_sehir`
--

CREATE TABLE `tbl_sehir` (
  `sehirKodu` varchar(50) NOT NULL,
  `hedefSehir` varchar(50) NOT NULL,
  `hedefTerminalAdi` varchar(50) NOT NULL,
  `terminalSehri` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Tablo döküm verisi `tbl_sehir`
--

INSERT INTO `tbl_sehir` (`sehirKodu`, `hedefSehir`, `hedefTerminalAdi`, `terminalSehri`) VALUES
('UT001', 'Kocaeli', '', 'Izmit Otobüs Terminali'),
('UT002', 'Istanbul', '', 'Besiktas Otobüs Terminali'),
('UT003', 'Izmir', '', 'Bornova Otobüs Terminali'),
('UT004', 'Ankara', '', 'Çankaya Otobüs Terminali'),
('UT005', 'Aydin', '', 'Söke Otobüs Terminali'),
('UT006', 'Bursa', '', 'Osmangazi Otobüs Terminali'),
('UT007', 'Antalya', '', 'Kepez Otobüs Terminali'),
('UT008', 'Mugla', '', 'Mentese Otobüs Terminali'),
('UT009', 'Trabzon', '', 'Merkez Otobüs Terminali'),
('UT010', 'Samsun', '', 'Ilkadim Otobüs Terminali'),
('UT011', 'Çanakkale', '', 'Bayramiç Otobüs Terminali'),
('UT012', 'Gaziantep', '', 'Nizip Otobüs Terminali'),
('UT013', 'Eskisehir', '', 'Odunpazari Otobüs Terminali');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tbl_seviye`
--

CREATE TABLE `tbl_seviye` (
  `seviyeKodu` int(11) NOT NULL,
  `seviyeAdi` varchar(50) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Tablo döküm verisi `tbl_seviye`
--

INSERT INTO `tbl_seviye` (`seviyeKodu`, `seviyeAdi`) VALUES
(1, 'owner'),
(2, 'administrator');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`adminKodu`);

--
-- Tablo için indeksler `tbl_altmenu`
--
ALTER TABLE `tbl_altmenu`
  ADD PRIMARY KEY (`altMenuKodu`),
  ADD KEY `menuKodu` (`menuKodu`);

--
-- Tablo için indeksler `tbl_bilet`
--
ALTER TABLE `tbl_bilet`
  ADD PRIMARY KEY (`biletKodu`),
  ADD KEY `rezervasyonKodu` (`rezervasyonKodu`);

--
-- Tablo için indeksler `tbl_dogrulama`
--
ALTER TABLE `tbl_dogrulama`
  ADD PRIMARY KEY (`dogrulamaKodu`),
  ADD KEY `rezervasyonKodu` (`rezervasyonKodu`);

--
-- Tablo için indeksler `tbl_menu`
--
ALTER TABLE `tbl_menu`
  ADD PRIMARY KEY (`menuKodu`);

--
-- Tablo için indeksler `tbl_musteri`
--
ALTER TABLE `tbl_musteri`
  ADD PRIMARY KEY (`musteriKodu`);

--
-- Tablo için indeksler `tbl_musteritoken`
--
ALTER TABLE `tbl_musteritoken`
  ADD PRIMARY KEY (`tokenKodu`);

--
-- Tablo için indeksler `tbl_otobus`
--
ALTER TABLE `tbl_otobus`
  ADD PRIMARY KEY (`otobusKodu`);

--
-- Tablo için indeksler `tbl_rezervasyon`
--
ALTER TABLE `tbl_rezervasyon`
  ADD PRIMARY KEY (`rezervasyonID`),
  ADD KEY `saatKodu` (`saatKodu`),
  ADD KEY `musteriKodu` (`musteriKodu`),
  ADD KEY `biletKodu` (`biletKodu`),
  ADD KEY `bankaKodu` (`bankaKodu`);

--
-- Tablo için indeksler `tbl_saat`
--
ALTER TABLE `tbl_saat`
  ADD PRIMARY KEY (`saatKodu`),
  ADD KEY `otobusKodu` (`otobusKodu`),
  ADD KEY `sehirKodu` (`sehirKodu`);

--
-- Tablo için indeksler `tbl_sehir`
--
ALTER TABLE `tbl_sehir`
  ADD PRIMARY KEY (`sehirKodu`);

--
-- Tablo için indeksler `tbl_seviye`
--
ALTER TABLE `tbl_seviye`
  ADD PRIMARY KEY (`seviyeKodu`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `tbl_menu`
--
ALTER TABLE `tbl_menu`
  MODIFY `menuKodu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `tbl_musteritoken`
--
ALTER TABLE `tbl_musteritoken`
  MODIFY `tokenKodu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Tablo için AUTO_INCREMENT değeri `tbl_rezervasyon`
--
ALTER TABLE `tbl_rezervasyon`
  MODIFY `rezervasyonID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
