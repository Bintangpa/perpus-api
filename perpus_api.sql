-- =========================================================
-- Database: perpus_api
-- Aplikasi Data Buku Perpustakaan (Ujian Praktik ASTS Ganjil XII RPL)
-- Struktur sesuai Jobsheet bagian G & H
-- =========================================================

CREATE DATABASE IF NOT EXISTS `perpus_api`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `perpus_api`;

-- ---------------------------------------------------------
-- Tabel: books
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `books`;

CREATE TABLE `books` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode_buku` VARCHAR(20) NOT NULL,
  `judul` VARCHAR(150) NOT NULL,
  `penulis` VARCHAR(100) NOT NULL,
  `kategori` VARCHAR(50) NOT NULL,
  `tahun_terbit` YEAR NOT NULL,
  `penerbit` VARCHAR(100) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `books_kode_buku_unique` (`kode_buku`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Tabel: admins
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `admins`;

CREATE TABLE `admins` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_username_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Data: books (10 data, kategori Novel & Teknologi)
-- ---------------------------------------------------------
INSERT INTO `books`
  (`kode_buku`, `judul`, `penulis`, `kategori`, `tahun_terbit`, `penerbit`, `created_at`, `updated_at`)
VALUES
  ('BK001', 'Laskar Pelangi',            'Andrea Hirata',      'Novel',     2005, 'Bentang Pustaka', NOW(), NOW()),
  ('BK002', 'Bumi',                       'Tere Liye',          'Novel',     2014, 'Gramedia',        NOW(), NOW()),
  ('BK003', 'Pemrograman PHP',            'Abdul Kadir',        'Teknologi', 2020, 'Andi',            NOW(), NOW()),
  ('BK004', 'Belajar HTML dan CSS',       'Jubilee Enterprise', 'Teknologi', 2021, 'Elex Media',      NOW(), NOW()),
  ('BK005', 'Dasar-Dasar JavaScript',     'Wahana Komputer',    'Teknologi', 2022, 'Andi',            NOW(), NOW()),
  ('BK006', 'Negeri 5 Menara',            'Ahmad Fuadi',        'Novel',     2009, 'Gramedia',        NOW(), NOW()),
  ('BK007', 'Perahu Kertas',              'Dee Lestari',        'Novel',     2010, 'Bentang Pustaka', NOW(), NOW()),
  ('BK008', 'Basis Data MySQL',           'Yuniar Supardi',     'Teknologi', 2019, 'Elex Media',      NOW(), NOW()),
  ('BK009', 'Pengantar Algoritma',        'Rinaldi Munir',      'Teknologi', 2023, 'Informatika',     NOW(), NOW()),
  ('BK010', 'Bumi Manusia',               'Pramoedya A.T.',     'Novel',     1980, 'Hasta Mitra',     NOW(), NOW());

-- ---------------------------------------------------------
-- Data: admins (1 akun, password ter-hash dengan bcrypt)
-- Username : admin
-- Password : admin123   (plain text ini HANYA untuk keperluan login,
--                         yang tersimpan di database adalah hash-nya)
-- ---------------------------------------------------------
INSERT INTO `admins`
  (`username`, `password`, `created_at`, `updated_at`)
VALUES
  ('admin', '$2b$10$zfhaDx/hB1/E1qgIWAf3geVvbTnWN0E609UXzGq6wbtXhNy79QuUq', NOW(), NOW());
