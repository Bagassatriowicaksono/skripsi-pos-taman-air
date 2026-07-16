/*
SQLyog Professional v12.5.1 (64 bit)
MySQL - 10.6.11-MariaDB-log : Database - pos_cafe_codekop
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `customer` */

DROP TABLE IF EXISTS `customer`;

CREATE TABLE `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_customer` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `hp` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `customer` */

insert  into `customer`(`id`,`kode_customer`,`nama`,`alamat`,`hp`,`keterangan`,`created_at`,`deleted_at`) values 
(0,NULL,NULL,NULL,NULL,NULL,NULL,'2023-12-30 20:50:49'),
(3,'C0001','Anang','Bekasi','628971812315','-','2024-02-28 05:24:16',NULL);

/*Table structure for table `kategori` */

DROP TABLE IF EXISTS `kategori`;

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kategori` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `kategori` */

insert  into `kategori`(`id`,`kategori`,`deleted_at`) values 
(1,'Uncategory',NULL);

/*Table structure for table `keranjang` */

DROP TABLE IF EXISTS `keranjang`;

CREATE TABLE `keranjang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_menu` int(11) NOT NULL,
  `kode_menu` varchar(255) DEFAULT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `login_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=234 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `keranjang` */

/*Table structure for table `keuangan_lainnya` */

DROP TABLE IF EXISTS `keuangan_lainnya`;

CREATE TABLE `keuangan_lainnya` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_ledger` varchar(255) DEFAULT NULL,
  `nama_urusan` varchar(255) DEFAULT NULL,
  `jenis` varchar(255) DEFAULT NULL,
  `jumlah_masuk` int(11) NOT NULL,
  `jumlah_keluar` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `date` date DEFAULT NULL,
  `periode` varchar(255) DEFAULT NULL,
  `year` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `keuangan_lainnya` */

/*Table structure for table `keuangan_ledger` */

DROP TABLE IF EXISTS `keuangan_ledger`;

CREATE TABLE `keuangan_ledger` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_ledger` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `jenis` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `keuangan_ledger` */

/*Table structure for table `login` */

DROP TABLE IF EXISTS `login`;

CREATE TABLE `login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `nama_user` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telepon` varchar(255) NOT NULL,
  `foto` text NOT NULL,
  `level` varchar(255) DEFAULT NULL,
  `tgl_bergabung` varchar(255) NOT NULL,
  `deleted_at` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `login` */

insert  into `login`(`id`,`user`,`pass`,`nama_user`,`alamat`,`email`,`telepon`,`foto`,`level`,`tgl_bergabung`,`deleted_at`) values 
(5,'adminkasir','$2y$10$XUrgFfZ6Y1b0UeaYnYLJbu2lU51cR8r8DwWI.ISmtKYfAqntwCXT2','Admin Toko','Bekasi','dummy@gmail.com','081234567890','user_1636966029.png','Admin','2019-09-11','2021-07-27 12:25:48'),
(6,'kasir','$2y$10$XUrgFfZ6Y1b0UeaYnYLJbu2lU51cR8r8DwWI.ISmtKYfAqntwCXT2','Fauzan Falah','Bekasi','dummy2@gmail.com','081234567890','user_1636966560.png','Kasir','2021-10-04',NULL);

/*Table structure for table `menu` */

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_kategori` int(11) NOT NULL,
  `kode_menu` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `harga_pokok` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `stok_minim` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `menu` */

insert  into `menu`(`id`,`id_kategori`,`kode_menu`,`nama`,`harga_pokok`,`harga_jual`,`stok`,`stok_minim`,`keterangan`,`gambar`,`created_at`,`deleted_at`) values 
(1,1,'P0001','Ayam Bakar',8000,15000,86,3,'Percik','-','2021-12-16 19:34:06',NULL),
(3,1,'P001','Teh',2000,3000,29,1,NULL,'-','2022-02-14 04:03:05',NULL);

/*Table structure for table `menu_stok` */

DROP TABLE IF EXISTS `menu_stok`;

CREATE TABLE `menu_stok` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL,
  `stok_awal` int(11) NOT NULL,
  `stok_akhir` int(11) NOT NULL,
  `date` date NOT NULL,
  `periode` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `menu_stok` */

/*Table structure for table `profil_toko` */

DROP TABLE IF EXISTS `profil_toko`;

CREATE TABLE `profil_toko` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_toko` varchar(255) NOT NULL,
  `alamat_toko` text NOT NULL,
  `telepon_toko` varchar(25) DEFAULT NULL,
  `email_toko` varchar(255) DEFAULT NULL,
  `pemilik_toko` varchar(255) DEFAULT NULL,
  `website_toko` varchar(255) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL,
  `os` int(11) DEFAULT NULL,
  `print` int(11) DEFAULT NULL,
  `print_default` int(11) DEFAULT NULL,
  `driver` varchar(255) DEFAULT NULL,
  `footer_struk` varchar(255) DEFAULT NULL,
  `pajak_default` int(11) DEFAULT 0,
  `pajak` int(11) NOT NULL,
  `voucher` int(11) NOT NULL,
  `diskon` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `jam_awal` varchar(25) DEFAULT NULL,
  `jam_akhir` varchar(25) DEFAULT NULL,
  `jam_order` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `profil_toko` */

insert  into `profil_toko`(`id`,`nama_toko`,`alamat_toko`,`telepon_toko`,`email_toko`,`pemilik_toko`,`website_toko`,`tgl_update`,`os`,`print`,`print_default`,`driver`,`footer_struk`,`pajak_default`,`pajak`,`voucher`,`diskon`,`user_id`,`jam_awal`,`jam_akhir`,`jam_order`) values 
(1,'Codekop Cafe','Bekasi','081234567890','halo@gmail.com','Anang','sample.com','2021-03-07 05:25:19',1,1,1,'logo_1652604576.jpeg','TERIMA KASIH\r\nATAS KUNJUNGAN ANDA',11,1,1,1,1,'00:00','00:00','0.00');

/*Table structure for table `transaksi` */

DROP TABLE IF EXISTS `transaksi`;

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_bon` varchar(255) DEFAULT NULL,
  `urut` int(11) DEFAULT 0,
  `kasir_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `atas_nama` varchar(255) DEFAULT NULL,
  `pesanan` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `diskon` int(11) NOT NULL,
  `pajak` int(11) NOT NULL,
  `voucher` int(11) NOT NULL,
  `grandmodal` int(11) NOT NULL,
  `grandtotal` int(11) NOT NULL,
  `total_qty` int(11) NOT NULL,
  `dibayar` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `date` date DEFAULT NULL,
  `periode` varchar(255) DEFAULT NULL,
  `year` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `transaksi` */

/*Table structure for table `transaksi_produk` */

DROP TABLE IF EXISTS `transaksi_produk`;

CREATE TABLE `transaksi_produk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_bon` varchar(255) DEFAULT NULL,
  `kode_menu` varchar(255) DEFAULT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `nama_menu` varchar(255) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `pesan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `date` date DEFAULT NULL,
  `periode` varchar(255) DEFAULT NULL,
  `year` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `transaksi_produk` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
