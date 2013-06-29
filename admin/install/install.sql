-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Jul 24, 2012 at 04:29 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.6

-- 
-- Database: `devjoom`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `#__sirs_departement`
-- 

CREATE TABLE `#__sirs_departement` (
  `id` int(3) NOT NULL auto_increment,
  `kode` varchar(5) NOT NULL,
  `nama_dept` varchar(50) NOT NULL,
  `checked_out` tinyint(4) NOT NULL,
  `checked_out_time` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;


-- --------------------------------------------------------

-- 
-- Table structure for table `#__sirs_jabatan`
-- 

CREATE TABLE `#__sirs_jabatan` (
  `id` int(3) NOT NULL auto_increment,
  `jabatan` varchar(20) NOT NULL,
  `checked_out` tinyint(4) NOT NULL,
  `checked_out_time` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;


-- --------------------------------------------------------

-- 
-- Table structure for table `#__sirs_jadwal`
-- 

CREATE TABLE `#__sirs_jadwal` (
  `id` int(11) NOT NULL auto_increment,
  `dokter_id` int(11) NOT NULL,
  `hari` int(2) NOT NULL,
  `sjam` varchar(6) NOT NULL,
  `fjam` varchar(6) NOT NULL,
  `klinik_id` int(11) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;


-- --------------------------------------------------------

-- 
-- Table structure for table `#__sirs_klinik`
-- 

CREATE TABLE `#__sirs_klinik` (
  `id` int(3) NOT NULL auto_increment,
  `klinik` varchar(30) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `#__sirs_pasien`
-- 

CREATE TABLE `#__sirs_pasien` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `sex` varchar(25) NOT NULL,
  `ttl` varchar(100) NOT NULL,
  `hp` varchar(15) NOT NULL,
  `alamat` text NOT NULL,
  `medical_record` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `#__sirs_profesi`
-- 

CREATE TABLE `#__sirs_profesi` (
  `id` int(11) NOT NULL auto_increment,
  `profesi` varchar(50) NOT NULL,
  `title` varchar(8) NOT NULL,
  `checked_out` tinyint(4) NOT NULL,
  `checked_out_time` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;


-- --------------------------------------------------------

-- 
-- Table structure for table `#__sirs_reg_pasien`
-- 

CREATE TABLE `#__sirs_reg_pasien` (
  `id` int(8) NOT NULL auto_increment,
  `no_reg` varchar(10) NOT NULL,
  `user_id` int(8) NOT NULL,
  `dokter_id` int(11) NOT NULL,
  `klinik_id` int(8) NOT NULL,
  `booking` datetime NOT NULL,
  `tanggal` date NOT NULL,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;


-- --------------------------------------------------------

-- 
-- Table structure for table `#__sirs_staff`
-- 

CREATE TABLE `#__sirs_staff` (
  `id` int(3) NOT NULL auto_increment,
  `nama` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `profil` text NOT NULL,
  `nip` varchar(10) NOT NULL,
  `hp` varchar(15) NOT NULL,
  `dept_id` int(3) NOT NULL,
  `jabatan_id` int(3) NOT NULL,
  `profesi_id` int(3) NOT NULL,
  `foto` text NOT NULL,
  `checked_out` tinyint(4) NOT NULL,
  `checked_out_time` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

