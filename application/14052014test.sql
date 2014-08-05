# Host: localhost  (Version: 5.6.12-log)
# Date: 2014-05-14 12:44:52
# Generator: MySQL-Front 5.3  (Build 4.120)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "tbl_ders"
#

DROP TABLE IF EXISTS `tbl_ders`;
CREATE TABLE `tbl_ders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ders_adi` varchar(255) DEFAULT NULL,
  `kredi` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

#
# Data for table "tbl_ders"
#

/*!40000 ALTER TABLE `tbl_ders` DISABLE KEYS */;
INSERT INTO `tbl_ders` VALUES (1,'Matematik',3),(2,'Fizik',4),(3,'Türkçe',4),(4,'Geometri',2),(5,'Kimya',3),(6,'Tarih',1),(8,'Biyoloji',2);
/*!40000 ALTER TABLE `tbl_ders` ENABLE KEYS */;

#
# Structure for table "tbl_haber"
#

DROP TABLE IF EXISTS `tbl_haber`;
CREATE TABLE `tbl_haber` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `baslik` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `ozet` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `foto` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `icerik` text CHARACTER SET utf8,
  `durum` varchar(1) CHARACTER SET utf8 DEFAULT '1',
  `ders_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

#
# Data for table "tbl_haber"
#

/*!40000 ALTER TABLE `tbl_haber` DISABLE KEYS */;
INSERT INTO `tbl_haber` VALUES (1,'Şampiyon Galatasaray !','Türkiye Bayanlar Basketbol Ligi Şampiyonu','gs.Jpeg','Galatasaray ezeli rakibi fenevbahçeyi farklı yenerek Türkiye Bayanlar Basketbol Liginde Şampiyon oldu.','1',NULL),(2,'Şampiyon Galatasaray !','Türkiye Bayanlar Basketbol Ligi Şampiyonu','onur.jpg','Galatasaray ezeli rakibi fenevbahçeyi farklı yenerek Türkiye Bayanlar Basketbol Liginde Şampiyon oldu.','1',NULL),(3,'Şampiyon Galatasaray !','Türkiye Bayanlar Basketbol Ligi Şampiyonu','gs.Jpeg','Galatasaray ezeli rakibi fenevbahçeyi farklı yenerek Türkiye Bayanlar Basketbol Liginde Şampiyon oldu.','1',NULL),(4,'jhkjh','',NULL,'','1',0),(5,'hkljl','şkşlk',NULL,'fghf','1',1),(6,'','',NULL,'','1',0),(7,'','','36175_462630347667_241250_n.jpg','','1',0);
/*!40000 ALTER TABLE `tbl_haber` ENABLE KEYS */;

#
# Structure for table "tbl_haber_ders"
#

DROP TABLE IF EXISTS `tbl_haber_ders`;
CREATE TABLE `tbl_haber_ders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `haber_id` int(11) DEFAULT NULL,
  `ders_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

#
# Data for table "tbl_haber_ders"
#

INSERT INTO `tbl_haber_ders` VALUES (3,3,1);

#
# Structure for table "tbl_kayit"
#

DROP TABLE IF EXISTS `tbl_kayit`;
CREATE TABLE `tbl_kayit` (
  `Id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `adi` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `soyadi` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tel` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `foto` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `durum` varchar(1) DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

#
# Data for table "tbl_kayit"
#

/*!40000 ALTER TABLE `tbl_kayit` DISABLE KEYS */;
INSERT INTO `tbl_kayit` VALUES (15,'Onur','SAHIN','05321574489','1399359736.jpg','onur@ubit.com.tr','1'),(16,'Ömer','BAKIRCI','02124837222',NULL,'omer@ubit.com.tr','0');
/*!40000 ALTER TABLE `tbl_kayit` ENABLE KEYS */;

#
# Structure for table "tbl_kayit_ders"
#

DROP TABLE IF EXISTS `tbl_kayit_ders`;
CREATE TABLE `tbl_kayit_ders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kayit_id` int(11) DEFAULT NULL,
  `ders_id` int(11) DEFAULT NULL,
  `ders_notu` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kayit_id` (`kayit_id`,`ders_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

#
# Data for table "tbl_kayit_ders"
#

/*!40000 ALTER TABLE `tbl_kayit_ders` DISABLE KEYS */;
INSERT INTO `tbl_kayit_ders` VALUES (8,NULL,NULL,NULL),(9,15,2,'BB'),(10,15,3,'CC'),(11,NULL,NULL,NULL),(12,15,8,'80'),(13,15,6,'DD'),(14,15,4,'CC');
/*!40000 ALTER TABLE `tbl_kayit_ders` ENABLE KEYS */;

#
# Structure for table "tbl_kullanici"
#

DROP TABLE IF EXISTS `tbl_kullanici`;
CREATE TABLE `tbl_kullanici` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `kullanici_adi` varchar(255) DEFAULT NULL,
  `grup_kodu` varchar(1) DEFAULT NULL,
  `parola` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

#
# Data for table "tbl_kullanici"
#

/*!40000 ALTER TABLE `tbl_kullanici` DISABLE KEYS */;
INSERT INTO `tbl_kullanici` VALUES (1,'hcivelek','E','12345'),(2,'erdem','A','345');
/*!40000 ALTER TABLE `tbl_kullanici` ENABLE KEYS */;

#
# Structure for table "tbl_menu"
#

DROP TABLE IF EXISTS `tbl_menu`;
CREATE TABLE `tbl_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `link` varchar(255) DEFAULT NULL,
  `menu_adi` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for table "tbl_menu"
#

/*!40000 ALTER TABLE `tbl_menu` DISABLE KEYS */;
INSERT INTO `tbl_menu` VALUES (1,'/','Anasayfa'),(2,'/index/duzenle','Yeni Ö?renci Kayd?'),(3,'/haber/duzenle','Yeni Duyuru Ekle');
/*!40000 ALTER TABLE `tbl_menu` ENABLE KEYS */;

#
# Structure for table "tbl_odev"
#

DROP TABLE IF EXISTS `tbl_odev`;
CREATE TABLE `tbl_odev` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `konu` varchar(255) DEFAULT NULL,
  `teslim_tarih` varchar(255) DEFAULT NULL,
  `giris_tarih` varchar(255) DEFAULT NULL,
  `ders_adi` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

#
# Data for table "tbl_odev"
#

INSERT INTO `tbl_odev` VALUES (8,'Dalgalar','13.06.2014','13.05.2014','Fizik'),(10,'Dogal Sayilar','19.06.2014','11.05.2014','Matematik');

DROP VIEW IF EXISTS `vi_haber_ders`;
CREATE VIEW `vi_haber_ders` AS 
  select `hd`.`id` AS `id`,`hd`.`haber_id` AS `haber_id`,`hd`.`ders_id` AS `ders_id`,`h`.`baslik` AS `baslik`,`h`.`ozet` AS `ozet`,`h`.`foto` AS `foto`,`h`.`icerik` AS `icerik`,`h`.`durum` AS `durum`,`d`.`ders_adi` AS `ders_adi`,`d`.`kredi` AS `kredi` from ((`test`.`tbl_haber_ders` `hd` left join `test`.`tbl_haber` `h` on((`h`.`id` = `hd`.`haber_id`))) left join `test`.`tbl_ders` `d` on((`d`.`id` = `hd`.`ders_id`)));

DROP VIEW IF EXISTS `vi_kayit_ders`;
CREATE VIEW `vi_kayit_ders` AS 
  select `kd`.`id` AS `id`,`kd`.`kayit_id` AS `kayit_id`,`kd`.`ders_id` AS `ders_id`,`kd`.`ders_notu` AS `ders_notu`,`k`.`adi` AS `adi`,`k`.`soyadi` AS `soyadi`,`d`.`ders_adi` AS `ders_adi`,`d`.`kredi` AS `kredi` from ((`test`.`tbl_kayit_ders` `kd` left join `test`.`tbl_kayit` `k` on((`k`.`Id` = `kd`.`kayit_id`))) left join `test`.`tbl_ders` `d` on((`d`.`id` = `kd`.`ders_id`)));
