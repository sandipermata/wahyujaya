/*
SQLyog Ultimate v10.42 
MySQL - 5.5.5-10.4.6-MariaDB : Database - db_traffic
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_traffic` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `db_traffic`;

/*Table structure for table `inbox` */

DROP TABLE IF EXISTS `inbox`;

CREATE TABLE `inbox` (
  `id_inbox` int(10) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `data` text NOT NULL,
  PRIMARY KEY (`id_inbox`)
) ENGINE=MyISAM AUTO_INCREMENT=3461 DEFAULT CHARSET=latin1;

/*Table structure for table `inbox_archieve` */

DROP TABLE IF EXISTS `inbox_archieve`;

CREATE TABLE `inbox_archieve` (
  `id_inbox` int(10) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `data` text NOT NULL,
  `last_sync` datetime NOT NULL,
  PRIMARY KEY (`id_inbox`)
) ENGINE=MyISAM AUTO_INCREMENT=3461 DEFAULT CHARSET=latin1;

/*Table structure for table `inbox_back` */

DROP TABLE IF EXISTS `inbox_back`;

CREATE TABLE `inbox_back` (
  `id_inbox` int(10) NOT NULL DEFAULT 0,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `inbox_ews` */

DROP TABLE IF EXISTS `inbox_ews`;

CREATE TABLE `inbox_ews` (
  `id_inbox` int(10) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `data` text NOT NULL,
  PRIMARY KEY (`id_inbox`)
) ENGINE=MyISAM AUTO_INCREMENT=963 DEFAULT CHARSET=latin1;

/*Table structure for table `tb_admin` */

DROP TABLE IF EXISTS `tb_admin`;

CREATE TABLE `tb_admin` (
  `adm_code` char(13) NOT NULL,
  `adm_pass` char(32) DEFAULT NULL,
  `adm_name` char(32) DEFAULT NULL,
  `adm_level` char(13) DEFAULT NULL,
  `adm_image` char(32) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_by` char(32) DEFAULT NULL,
  `updated_date` date DEFAULT NULL,
  `updated_by` char(32) DEFAULT NULL,
  PRIMARY KEY (`adm_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tb_admin_access` */

DROP TABLE IF EXISTS `tb_admin_access`;

CREATE TABLE `tb_admin_access` (
  `acc_id` int(11) NOT NULL AUTO_INCREMENT,
  `acc_adm_code` char(13) DEFAULT NULL,
  `acc_access` char(13) DEFAULT NULL,
  `acc_active` enum('Y','N') DEFAULT 'Y',
  `created_date` date DEFAULT NULL,
  `created_by` char(32) DEFAULT NULL,
  `updated_date` date DEFAULT NULL,
  `updated_by` char(32) DEFAULT NULL,
  PRIMARY KEY (`acc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=latin1;

/*Table structure for table `tb_city` */

DROP TABLE IF EXISTS `tb_city`;

CREATE TABLE `tb_city` (
  `prov_provcode` char(2) NOT NULL,
  `city_code` char(5) NOT NULL,
  `city_level` enum('KAB','KOTA') NOT NULL DEFAULT 'KAB',
  `city_name` char(32) NOT NULL,
  `city_name_convert` char(200) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_by` char(32) DEFAULT NULL,
  `updated_date` date DEFAULT NULL,
  `updated_by` char(32) DEFAULT NULL,
  PRIMARY KEY (`prov_provcode`,`city_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `tb_detail_maintenance` */

DROP TABLE IF EXISTS `tb_detail_maintenance`;

CREATE TABLE `tb_detail_maintenance` (
  `mnt_id` int(11) NOT NULL AUTO_INCREMENT,
  `mnt_year` date DEFAULT NULL COMMENT 'tahun perawatan',
  `mnt_user` char(32) DEFAULT NULL COMMENT 'user yang melakukan perawata',
  `mnt_type` char(32) DEFAULT NULL COMMENT 'jenis pemeliharaan',
  `mnt_sn_code` char(32) DEFAULT NULL,
  `mnt_remarks` char(255) DEFAULT NULL COMMENT 'catatan pemeliharaan',
  `mnt_category` char(32) DEFAULT NULL,
  PRIMARY KEY (`mnt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Table structure for table `tb_district` */

DROP TABLE IF EXISTS `tb_district`;

CREATE TABLE `tb_district` (
  `tlc_code` char(3) NOT NULL,
  `prov_prov_code` char(2) NOT NULL,
  `city_city_code` char(5) NOT NULL,
  `district_code` char(10) NOT NULL,
  `district_name` char(32) NOT NULL DEFAULT '',
  `created_date` date DEFAULT NULL,
  `created_by` char(32) DEFAULT NULL,
  `updated_date` date DEFAULT NULL,
  `updated_by` char(32) DEFAULT NULL,
  PRIMARY KEY (`prov_prov_code`,`city_city_code`,`district_code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `tb_ews` */

DROP TABLE IF EXISTS `tb_ews`;

CREATE TABLE `tb_ews` (
  `ews_id` int(11) NOT NULL AUTO_INCREMENT,
  `ews_ip` char(32) DEFAULT NULL,
  `ews_sn_alias` char(32) DEFAULT NULL,
  `ews_gsm_no` char(32) DEFAULT NULL,
  `ews_prov` char(32) DEFAULT NULL,
  `ews_kab` char(32) DEFAULT NULL,
  `ews_kec` char(32) DEFAULT NULL,
  `ews_kel` char(32) DEFAULT NULL,
  `ews_area` char(255) DEFAULT NULL,
  `ews_pole` char(32) DEFAULT NULL,
  `ews_loc_lat` char(32) DEFAULT NULL,
  `ews_loc_lon` char(32) DEFAULT NULL,
  `ews_loc_desc` char(64) DEFAULT NULL,
  `ews_loc_sensor_L` char(32) DEFAULT NULL,
  `ews_loc_sensor_C` char(32) DEFAULT NULL,
  `ews_loc_sensor_R` char(32) DEFAULT NULL,
  `ews_duration` decimal(12,2) DEFAULT NULL,
  `ews_status` char(32) DEFAULT NULL,
  `ews_km` char(100) DEFAULT NULL,
  `ews_daop` char(32) DEFAULT NULL,
  `ews_road_width` char(32) DEFAULT NULL,
  `ews_road_class` char(32) DEFAULT NULL,
  `ews_road_type` char(32) DEFAULT NULL,
  `ews_pju` char(32) DEFAULT NULL,
  `ews_rambu` char(255) DEFAULT NULL,
  `ews_marka` char(32) DEFAULT NULL,
  `ews_speed_bump` char(32) DEFAULT NULL,
  `ews_install_year` date DEFAULT NULL,
  `ews_maintenance_year` date DEFAULT NULL,
  `ews_cctv` char(255) DEFAULT NULL,
  `ews_location_image` char(32) DEFAULT NULL,
  `ews_photo_desc` char(255) DEFAULT NULL,
  `ews_street_view` char(255) DEFAULT NULL,
  `ews_description` char(255) DEFAULT NULL,
  `ews_project` char(32) NOT NULL,
  `ews_dir_left` char(32) DEFAULT NULL,
  `ews_dir_right` char(32) DEFAULT NULL,
  `ews_created_date` date DEFAULT NULL,
  `ews_created_by` char(32) DEFAULT NULL,
  `ews_updated_date` date DEFAULT NULL,
  `ews_updated_by` char(32) DEFAULT NULL,
  PRIMARY KEY (`ews_id`)
) ENGINE=InnoDB AUTO_INCREMENT=210 DEFAULT CHARSET=latin1;

/*Table structure for table `tb_icons` */

DROP TABLE IF EXISTS `tb_icons`;

CREATE TABLE `tb_icons` (
  `icon_id` int(11) NOT NULL AUTO_INCREMENT,
  `icon_category` char(32) DEFAULT NULL,
  `icon_type` char(32) DEFAULT NULL,
  `icon_name` char(32) DEFAULT NULL,
  `icon_image` char(64) DEFAULT NULL,
  `icon_created_date` date DEFAULT NULL,
  `icon_created_by` char(32) DEFAULT NULL,
  `icon_updated_date` date DEFAULT NULL,
  `icon_updated_by` char(32) DEFAULT NULL,
  PRIMARY KEY (`icon_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/*Table structure for table `tb_menus` */

DROP TABLE IF EXISTS `tb_menus`;

CREATE TABLE `tb_menus` (
  `menu_code` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` char(32) DEFAULT NULL,
  `menu_link` char(32) DEFAULT NULL,
  `menu_icon` char(32) DEFAULT NULL,
  `menu_parent` char(32) DEFAULT NULL,
  `menu_sequences` int(11) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_by` char(32) DEFAULT NULL,
  `updated_date` date DEFAULT NULL,
  `updated_by` char(32) DEFAULT NULL,
  PRIMARY KEY (`menu_code`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

/*Table structure for table `tb_pju` */

DROP TABLE IF EXISTS `tb_pju`;

CREATE TABLE `tb_pju` (
  `pju_id` int(11) NOT NULL AUTO_INCREMENT,
  `pju_ip` char(32) DEFAULT NULL,
  `pju_area` char(255) DEFAULT NULL,
  `pju_pole` char(32) DEFAULT NULL,
  `pju_loc_lat` char(32) DEFAULT NULL,
  `pju_loc_lon` char(32) DEFAULT NULL,
  `pju_loc_desc` char(64) DEFAULT NULL,
  `pju_duration` decimal(12,2) DEFAULT NULL,
  `pju_battery` decimal(12,2) DEFAULT NULL,
  `pju_status` char(32) DEFAULT NULL,
  `pju_created_date` date DEFAULT NULL,
  `pju_created_by` char(32) DEFAULT NULL,
  `pju_updated_date` date DEFAULT NULL,
  `pju_updated_by` char(32) DEFAULT NULL,
  PRIMARY KEY (`pju_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Table structure for table `tb_project` */

DROP TABLE IF EXISTS `tb_project`;

CREATE TABLE `tb_project` (
  `project_code` varchar(13) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `project_description` text NOT NULL,
  `project_image` varchar(255) NOT NULL,
  `project_title` text NOT NULL,
  `project_sub_title` text NOT NULL,
  `project_isi` text NOT NULL,
  PRIMARY KEY (`project_code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `tb_province` */

DROP TABLE IF EXISTS `tb_province`;

CREATE TABLE `tb_province` (
  `prov_code` char(2) NOT NULL,
  `prov_name` char(64) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `created_by` char(32) DEFAULT NULL,
  `updated_date` date DEFAULT NULL,
  `updated_by` char(32) DEFAULT NULL,
  `prov_image` varchar(255) NOT NULL,
  PRIMARY KEY (`prov_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `tb_rambu` */

DROP TABLE IF EXISTS `tb_rambu`;

CREATE TABLE `tb_rambu` (
  `rambu_id` int(11) NOT NULL AUTO_INCREMENT,
  `rambu_image` char(32) DEFAULT NULL,
  `rambu_desc` char(255) DEFAULT NULL,
  PRIMARY KEY (`rambu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Table structure for table `tb_rpt_ews` */

DROP TABLE IF EXISTS `tb_rpt_ews`;

CREATE TABLE `tb_rpt_ews` (
  `ews_code_id` int(11) NOT NULL AUTO_INCREMENT,
  `ews_rpt_date` datetime NOT NULL,
  `ews_sn` char(32) NOT NULL,
  `ews_code` char(32) NOT NULL,
  `ews_kota` char(32) NOT NULL,
  `ews_tag_pv` char(32) NOT NULL,
  `ews_battery_volt` char(32) DEFAULT NULL,
  `ews_battery_percent` char(32) DEFAULT NULL,
  `ews_pv_percent` char(32) DEFAULT NULL,
  `ews_ipv` char(32) DEFAULT NULL,
  `ews_ibat_charge` char(32) DEFAULT NULL,
  `ews_ibat` char(32) DEFAULT NULL,
  `ews_en_charge` char(32) DEFAULT NULL,
  `ews_chg_ind` char(13) DEFAULT NULL,
  `ews_by_pass` char(13) DEFAULT NULL,
  `ews_i_led` char(13) DEFAULT NULL,
  `ews_led_status` char(13) DEFAULT NULL,
  `ews_c_led_driver` char(13) DEFAULT NULL,
  `ews_pwm_led_driver` char(13) DEFAULT NULL,
  `ews_sirine_level` char(32) DEFAULT NULL,
  `ews_sirine_mute` char(13) DEFAULT NULL,
  `ews_jml_pulse_sensor_L` char(32) DEFAULT NULL,
  `ews_jml_pulse_sensor_C` char(32) DEFAULT NULL,
  `ews_jml_pulse_sensor_R` char(32) DEFAULT NULL,
  `ews_status_sensor_L` char(13) DEFAULT NULL,
  `ews_status_sensor_C` char(13) DEFAULT NULL,
  `ews_status_sensor_R` char(13) DEFAULT NULL,
  `ews_suhu_confan` char(32) DEFAULT NULL,
  `ews_date_time` char(32) DEFAULT NULL,
  `ews_lat` char(20) DEFAULT NULL,
  `ews_lon` char(20) DEFAULT NULL,
  `ews_modem_signal` char(13) DEFAULT NULL,
  `ews_counter_reset` char(13) DEFAULT NULL,
  `ews_batt_cycle` char(13) DEFAULT NULL,
  `ews_status_cuaca` char(13) DEFAULT NULL,
  `ews_data_irradiance` char(13) DEFAULT NULL,
  `ews_arus_sirine` char(13) DEFAULT NULL,
  `ews_teg_out_sirine` char(13) DEFAULT NULL,
  `ews_status_toa` char(13) DEFAULT NULL,
  `ews_arah` char(32) DEFAULT NULL,
  `ews_status_chg_batt` char(32) DEFAULT NULL,
  `ews_kecepatan` char(32) DEFAULT NULL,
  PRIMARY KEY (`ews_code_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5569 DEFAULT CHARSET=latin1;

/*Table structure for table `tb_rpt_traffic` */

DROP TABLE IF EXISTS `tb_rpt_traffic`;

CREATE TABLE `tb_rpt_traffic` (
  `tl_id` int(11) NOT NULL AUTO_INCREMENT,
  `tl_rpt_date` datetime DEFAULT NULL,
  `tl_sn` char(32) DEFAULT NULL,
  `tl_password` char(32) DEFAULT NULL,
  `tl_ip` char(32) DEFAULT NULL,
  `tl_sinyal_wifi` char(32) DEFAULT NULL,
  `tl_jam_controller` char(32) DEFAULT NULL,
  `tl_kode_pola` char(13) DEFAULT '1234',
  `tl_1_RYG` char(64) DEFAULT NULL,
  `tl_2_RYG` char(64) DEFAULT NULL,
  `tl_3_RYG` char(64) DEFAULT NULL,
  `tl_4_RYG` char(64) DEFAULT NULL,
  `tl_timer_pendek` decimal(12,0) DEFAULT NULL,
  `tl_timer_panjang` decimal(12,0) DEFAULT NULL,
  `tl_timer_flash` decimal(12,0) DEFAULT NULL,
  `tl_arus_ac` char(13) DEFAULT NULL,
  `tl_suhu_panel` char(13) DEFAULT NULL,
  `tl_life_cycle` char(13) DEFAULT NULL,
  `tl_kode_unik` char(32) DEFAULT NULL,
  `tl_teg_ac` char(32) DEFAULT NULL,
  `tl_daya` char(32) DEFAULT NULL,
  `tl_lembab` char(32) DEFAULT NULL,
  `tl_teg_bat_back` char(32) DEFAULT NULL,
  PRIMARY KEY (`tl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2080 DEFAULT CHARSET=latin1;

/*Table structure for table `tb_traffic_d` */

DROP TABLE IF EXISTS `tb_traffic_d`;

CREATE TABLE `tb_traffic_d` (
  `tfc_id` int(11) NOT NULL AUTO_INCREMENT,
  `tfc_sn_d` char(32) DEFAULT NULL,
  `tfc_pole` char(13) DEFAULT NULL,
  `tfc_loc_lat` char(32) DEFAULT NULL,
  `tfc_loc_lon` char(32) DEFAULT NULL,
  `tfc_loc_desc` text DEFAULT NULL,
  `tfc_G` decimal(12,0) DEFAULT NULL,
  `tfc_G1` decimal(12,0) DEFAULT NULL,
  `tfc_R` decimal(12,0) DEFAULT NULL,
  `tfc_status` char(32) DEFAULT NULL,
  `tfc_device_sts` char(13) NOT NULL,
  `tfc_g_image` char(32) DEFAULT NULL,
  `tfc_r_image` char(32) DEFAULT NULL,
  `tfc_created_date` date DEFAULT NULL,
  `tfc_created_by` char(32) DEFAULT NULL,
  `tfc_updated_date` date DEFAULT NULL,
  `tfc_updated_by` char(32) DEFAULT NULL,
  PRIMARY KEY (`tfc_id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

/*Table structure for table `tb_traffic_h` */

DROP TABLE IF EXISTS `tb_traffic_h`;

CREATE TABLE `tb_traffic_h` (
  `tfc_sn` char(32) DEFAULT NULL,
  `tfc_ip` char(32) NOT NULL,
  `tfc_prov` char(13) NOT NULL,
  `tfc_kab` char(13) NOT NULL,
  `tfc_kec` char(32) NOT NULL,
  `tfc_desa` char(32) DEFAULT NULL,
  `tfc_jalan` char(255) DEFAULT NULL,
  `tfc_area` char(64) NOT NULL,
  `tfc_loc_lat` char(32) DEFAULT NULL,
  `tfc_loc_lon` char(32) DEFAULT NULL,
  `tfc_cross_type` char(32) NOT NULL,
  `tfc_road_class` char(64) NOT NULL,
  `tfc_road_type` char(32) DEFAULT NULL,
  `tfc_rambu` char(64) DEFAULT NULL,
  `tfc_marka` char(64) DEFAULT NULL,
  `tfc_install_date` date DEFAULT NULL,
  `tfc_maintenance_date` date NOT NULL,
  `tfc_flash_image` char(255) NOT NULL,
  `tfc_loc_image` char(255) DEFAULT NULL,
  `tfc_photo_desc` char(255) DEFAULT NULL,
  `tfc_cctv` char(255) DEFAULT NULL,
  `tfc_street_view` char(255) NOT NULL,
  `tfc_status` char(32) NOT NULL,
  `tfc_device_sts` char(32) DEFAULT NULL,
  `tfc_project` char(13) DEFAULT NULL,
  `tfc_description` char(255) DEFAULT NULL,
  `tfc_created_date` date DEFAULT NULL,
  `tfc_created_by` char(32) DEFAULT NULL,
  `tfc_updated_date` date DEFAULT NULL,
  `tfc_updated_by` char(32) DEFAULT NULL,
  PRIMARY KEY (`tfc_ip`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `tb_traffic_old` */

DROP TABLE IF EXISTS `tb_traffic_old`;

CREATE TABLE `tb_traffic_old` (
  `tfc_id` int(11) NOT NULL AUTO_INCREMENT,
  `tfc_sn` char(32) DEFAULT NULL,
  `tfc_ip` char(32) DEFAULT NULL,
  `tfc_prov` char(32) DEFAULT NULL,
  `tfc_kab` char(32) DEFAULT NULL,
  `tfc_kec` char(32) DEFAULT NULL,
  `tfc_jalan` char(255) DEFAULT NULL,
  `tfc_area` char(255) DEFAULT NULL,
  `tfc_pole` char(13) DEFAULT NULL,
  `tfc_loc_lat` char(32) DEFAULT NULL,
  `tfc_loc_lon` char(32) DEFAULT NULL,
  `tfc_loc_desc` char(255) DEFAULT NULL,
  `tfc_G` decimal(12,2) DEFAULT NULL,
  `tfc_G1` decimal(12,2) DEFAULT NULL,
  `tfc_R` decimal(12,2) DEFAULT NULL,
  `tfc_cross_type` char(32) DEFAULT NULL,
  `tfc_road_class` char(32) DEFAULT NULL,
  `tfc_rambu` char(255) DEFAULT NULL,
  `tfc_marka` char(13) DEFAULT NULL,
  `tfc_install_date` date DEFAULT NULL,
  `tfc_maintenance_date` date DEFAULT NULL,
  `tfc_location_image` char(255) DEFAULT NULL,
  `tfc_street_view` char(255) DEFAULT NULL,
  `tfc_status` char(32) DEFAULT NULL,
  `tfc_device_sts` char(32) DEFAULT NULL,
  `tfc_project` char(13) DEFAULT NULL,
  `tfc_created_date` date DEFAULT NULL,
  `tfc_created_by` char(32) DEFAULT NULL,
  `tfc_updated_date` date DEFAULT NULL,
  `tfc_updated_by` char(32) DEFAULT NULL,
  PRIMARY KEY (`tfc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Table structure for table `tb_versiapps` */

DROP TABLE IF EXISTS `tb_versiapps`;

CREATE TABLE `tb_versiapps` (
  `appId` int(11) NOT NULL AUTO_INCREMENT,
  `appName` char(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `appVersion` int(11) DEFAULT NULL,
  `appVersionName` char(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `appDesc` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `appDate` date DEFAULT NULL,
  PRIMARY KEY (`appId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `tb_warning` */

DROP TABLE IF EXISTS `tb_warning`;

CREATE TABLE `tb_warning` (
  `wrn_id` int(11) NOT NULL AUTO_INCREMENT,
  `wrn_ip` char(32) DEFAULT NULL,
  `wrn_pole` char(32) DEFAULT NULL,
  `wrn_loc_lat` char(32) DEFAULT NULL,
  `wrn_loc_lon` char(32) DEFAULT NULL,
  `wrn_loc_desc` char(64) DEFAULT NULL,
  `wrn_duration` decimal(12,2) DEFAULT NULL,
  `wrn_status` char(32) DEFAULT NULL,
  `wrn_created_date` date DEFAULT NULL,
  `wrn_created_by` char(32) DEFAULT NULL,
  `wrn_updated_date` date DEFAULT NULL,
  `wrn_updated_by` char(32) DEFAULT NULL,
  PRIMARY KEY (`wrn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Table structure for table `v_last_ews_rpt` */

DROP TABLE IF EXISTS `v_last_ews_rpt`;

/*!50001 DROP VIEW IF EXISTS `v_last_ews_rpt` */;
/*!50001 DROP TABLE IF EXISTS `v_last_ews_rpt` */;

/*!50001 CREATE TABLE  `v_last_ews_rpt`(
 `vdate` datetime ,
 `ews_code_id` int(11) ,
 `ews_rpt_date` datetime ,
 `ews_sn` char(32) ,
 `ews_code` char(32) ,
 `ews_kota` char(32) ,
 `ews_tag_pv` char(32) ,
 `ews_battery_volt` char(32) ,
 `ews_battery_percent` char(32) ,
 `ews_pv_percent` char(32) ,
 `ews_ipv` char(32) ,
 `ews_ibat_charge` char(32) ,
 `ews_ibat` char(32) ,
 `ews_en_charge` char(32) ,
 `ews_chg_ind` char(13) ,
 `ews_by_pass` char(13) ,
 `ews_i_led` char(13) ,
 `ews_led_status` char(13) ,
 `ews_c_led_driver` char(13) ,
 `ews_pwm_led_driver` char(13) ,
 `ews_sirine_level` char(32) ,
 `ews_sirine_mute` char(13) ,
 `ews_jml_pulse_sensor_L` char(32) ,
 `ews_jml_pulse_sensor_C` char(32) ,
 `ews_jml_pulse_sensor_R` char(32) ,
 `ews_status_sensor_L` char(13) ,
 `ews_status_sensor_C` char(13) ,
 `ews_status_sensor_R` char(13) ,
 `ews_suhu_confan` char(32) ,
 `ews_date_time` char(32) ,
 `ews_lat` char(20) ,
 `ews_lon` char(20) ,
 `ews_modem_signal` char(13) ,
 `ews_counter_reset` char(13) ,
 `ews_batt_cycle` char(13) ,
 `ews_status_cuaca` char(13) ,
 `ews_data_irradiance` char(13) ,
 `ews_arus_sirine` char(13) ,
 `ews_teg_out_sirine` char(13) ,
 `ews_status_toa` char(13) ,
 `ews_arah` char(32) ,
 `ews_status_chg_batt` char(32) ,
 `ews_kecepatan` char(32) 
)*/;

/*Table structure for table `v_last_tfc_rpt` */

DROP TABLE IF EXISTS `v_last_tfc_rpt`;

/*!50001 DROP VIEW IF EXISTS `v_last_tfc_rpt` */;
/*!50001 DROP TABLE IF EXISTS `v_last_tfc_rpt` */;

/*!50001 CREATE TABLE  `v_last_tfc_rpt`(
 `vdate` datetime ,
 `tl_id` int(11) ,
 `tl_rpt_date` datetime ,
 `tl_sn` char(32) ,
 `tl_password` char(32) ,
 `tl_ip` char(32) ,
 `tl_sinyal_wifi` char(32) ,
 `tl_jam_controller` char(32) ,
 `tl_kode_pola` char(13) ,
 `tl_1_RYG` char(64) ,
 `tl_2_RYG` char(64) ,
 `tl_3_RYG` char(64) ,
 `tl_4_RYG` char(64) ,
 `tl_timer_pendek` decimal(12,0) ,
 `tl_timer_panjang` decimal(12,0) ,
 `tl_timer_flash` decimal(12,0) ,
 `tl_arus_ac` char(13) ,
 `tl_suhu_panel` char(13) ,
 `tl_life_cycle` char(13) ,
 `tl_kode_unik` char(32) ,
 `tl_teg_ac` char(32) ,
 `tl_daya` char(32) ,
 `tl_lembab` char(32) 
)*/;

/*Table structure for table `v_maxews_rpt` */

DROP TABLE IF EXISTS `v_maxews_rpt`;

/*!50001 DROP VIEW IF EXISTS `v_maxews_rpt` */;
/*!50001 DROP TABLE IF EXISTS `v_maxews_rpt` */;

/*!50001 CREATE TABLE  `v_maxews_rpt`(
 `vdate` datetime 
)*/;

/*Table structure for table `v_maxtfc_rpt` */

DROP TABLE IF EXISTS `v_maxtfc_rpt`;

/*!50001 DROP VIEW IF EXISTS `v_maxtfc_rpt` */;
/*!50001 DROP TABLE IF EXISTS `v_maxtfc_rpt` */;

/*!50001 CREATE TABLE  `v_maxtfc_rpt`(
 `vdate` datetime 
)*/;

/*View structure for view v_last_ews_rpt */

/*!50001 DROP TABLE IF EXISTS `v_last_ews_rpt` */;
/*!50001 DROP VIEW IF EXISTS `v_last_ews_rpt` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_last_ews_rpt` AS select `v_maxews_rpt`.`vdate` AS `vdate`,`tb_rpt_ews`.`ews_code_id` AS `ews_code_id`,`tb_rpt_ews`.`ews_rpt_date` AS `ews_rpt_date`,`tb_rpt_ews`.`ews_sn` AS `ews_sn`,`tb_rpt_ews`.`ews_code` AS `ews_code`,`tb_rpt_ews`.`ews_kota` AS `ews_kota`,`tb_rpt_ews`.`ews_tag_pv` AS `ews_tag_pv`,`tb_rpt_ews`.`ews_battery_volt` AS `ews_battery_volt`,`tb_rpt_ews`.`ews_battery_percent` AS `ews_battery_percent`,`tb_rpt_ews`.`ews_pv_percent` AS `ews_pv_percent`,`tb_rpt_ews`.`ews_ipv` AS `ews_ipv`,`tb_rpt_ews`.`ews_ibat_charge` AS `ews_ibat_charge`,`tb_rpt_ews`.`ews_ibat` AS `ews_ibat`,`tb_rpt_ews`.`ews_en_charge` AS `ews_en_charge`,`tb_rpt_ews`.`ews_chg_ind` AS `ews_chg_ind`,`tb_rpt_ews`.`ews_by_pass` AS `ews_by_pass`,`tb_rpt_ews`.`ews_i_led` AS `ews_i_led`,`tb_rpt_ews`.`ews_led_status` AS `ews_led_status`,`tb_rpt_ews`.`ews_c_led_driver` AS `ews_c_led_driver`,`tb_rpt_ews`.`ews_pwm_led_driver` AS `ews_pwm_led_driver`,`tb_rpt_ews`.`ews_sirine_level` AS `ews_sirine_level`,`tb_rpt_ews`.`ews_sirine_mute` AS `ews_sirine_mute`,`tb_rpt_ews`.`ews_jml_pulse_sensor_L` AS `ews_jml_pulse_sensor_L`,`tb_rpt_ews`.`ews_jml_pulse_sensor_C` AS `ews_jml_pulse_sensor_C`,`tb_rpt_ews`.`ews_jml_pulse_sensor_R` AS `ews_jml_pulse_sensor_R`,`tb_rpt_ews`.`ews_status_sensor_L` AS `ews_status_sensor_L`,`tb_rpt_ews`.`ews_status_sensor_C` AS `ews_status_sensor_C`,`tb_rpt_ews`.`ews_status_sensor_R` AS `ews_status_sensor_R`,`tb_rpt_ews`.`ews_suhu_confan` AS `ews_suhu_confan`,`tb_rpt_ews`.`ews_date_time` AS `ews_date_time`,`tb_rpt_ews`.`ews_lat` AS `ews_lat`,`tb_rpt_ews`.`ews_lon` AS `ews_lon`,`tb_rpt_ews`.`ews_modem_signal` AS `ews_modem_signal`,`tb_rpt_ews`.`ews_counter_reset` AS `ews_counter_reset`,`tb_rpt_ews`.`ews_batt_cycle` AS `ews_batt_cycle`,`tb_rpt_ews`.`ews_status_cuaca` AS `ews_status_cuaca`,`tb_rpt_ews`.`ews_data_irradiance` AS `ews_data_irradiance`,`tb_rpt_ews`.`ews_arus_sirine` AS `ews_arus_sirine`,`tb_rpt_ews`.`ews_teg_out_sirine` AS `ews_teg_out_sirine`,`tb_rpt_ews`.`ews_status_toa` AS `ews_status_toa`,`tb_rpt_ews`.`ews_arah` AS `ews_arah`,`tb_rpt_ews`.`ews_status_chg_batt` AS `ews_status_chg_batt`,`tb_rpt_ews`.`ews_kecepatan` AS `ews_kecepatan` from (`v_maxews_rpt` left join `tb_rpt_ews` on(`tb_rpt_ews`.`ews_rpt_date` = `v_maxews_rpt`.`vdate`)) */;

/*View structure for view v_last_tfc_rpt */

/*!50001 DROP TABLE IF EXISTS `v_last_tfc_rpt` */;
/*!50001 DROP VIEW IF EXISTS `v_last_tfc_rpt` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_last_tfc_rpt` AS select `v_maxtfc_rpt`.`vdate` AS `vdate`,`tb_rpt_traffic`.`tl_id` AS `tl_id`,`tb_rpt_traffic`.`tl_rpt_date` AS `tl_rpt_date`,`tb_rpt_traffic`.`tl_sn` AS `tl_sn`,`tb_rpt_traffic`.`tl_password` AS `tl_password`,`tb_rpt_traffic`.`tl_ip` AS `tl_ip`,`tb_rpt_traffic`.`tl_sinyal_wifi` AS `tl_sinyal_wifi`,`tb_rpt_traffic`.`tl_jam_controller` AS `tl_jam_controller`,`tb_rpt_traffic`.`tl_kode_pola` AS `tl_kode_pola`,`tb_rpt_traffic`.`tl_1_RYG` AS `tl_1_RYG`,`tb_rpt_traffic`.`tl_2_RYG` AS `tl_2_RYG`,`tb_rpt_traffic`.`tl_3_RYG` AS `tl_3_RYG`,`tb_rpt_traffic`.`tl_4_RYG` AS `tl_4_RYG`,`tb_rpt_traffic`.`tl_timer_pendek` AS `tl_timer_pendek`,`tb_rpt_traffic`.`tl_timer_panjang` AS `tl_timer_panjang`,`tb_rpt_traffic`.`tl_timer_flash` AS `tl_timer_flash`,`tb_rpt_traffic`.`tl_arus_ac` AS `tl_arus_ac`,`tb_rpt_traffic`.`tl_suhu_panel` AS `tl_suhu_panel`,`tb_rpt_traffic`.`tl_life_cycle` AS `tl_life_cycle`,`tb_rpt_traffic`.`tl_kode_unik` AS `tl_kode_unik`,`tb_rpt_traffic`.`tl_teg_ac` AS `tl_teg_ac`,`tb_rpt_traffic`.`tl_daya` AS `tl_daya`,`tb_rpt_traffic`.`tl_lembab` AS `tl_lembab` from (`v_maxtfc_rpt` left join `tb_rpt_traffic` on(`tb_rpt_traffic`.`tl_rpt_date` = `v_maxtfc_rpt`.`vdate`)) */;

/*View structure for view v_maxews_rpt */

/*!50001 DROP TABLE IF EXISTS `v_maxews_rpt` */;
/*!50001 DROP VIEW IF EXISTS `v_maxews_rpt` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_maxews_rpt` AS select max(`tb_rpt_ews`.`ews_rpt_date`) AS `vdate` from `tb_rpt_ews` group by `tb_rpt_ews`.`ews_sn` */;

/*View structure for view v_maxtfc_rpt */

/*!50001 DROP TABLE IF EXISTS `v_maxtfc_rpt` */;
/*!50001 DROP VIEW IF EXISTS `v_maxtfc_rpt` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_maxtfc_rpt` AS select max(`tb_rpt_traffic`.`tl_rpt_date`) AS `vdate` from `tb_rpt_traffic` group by `tb_rpt_traffic`.`tl_ip` */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
