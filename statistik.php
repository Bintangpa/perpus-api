<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// STATISTIK DATA DARI DATABASE
$query_total = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM books");
$total_buku = mysqli_fetch_assoc($query_total)['total'] ?? 0;

$query_kategori = mysqli_query($koneksi, "SELECT COUNT(DISTINCT kategori) as total FROM books");
$total_kategori = mysqli_fetch_assoc($query_kategori)['total'] ?? 0;

$query_penulis = mysqli_query($koneksi, "SELECT COUNT(DISTINCT penulis) as total FROM books");
$total_penulis = mysqli_fetch_assoc($query_penulis)['total'] ?? 0;

$query_terbaru = mysqli_query($koneksi, "SELECT MAX(tahun_terbit) as terbaru FROM books");
$tahun_terbaru = mysqli_fetch_assoc($query_terbaru)['terbaru'] ?? '-';

$active_page = 'statistik';

// Memanggil tampilan khusus statistik & grafik
include __DIR__ . '/resources/views/dashboard/statistik.view.php';
?>
