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

// HITUNG KODE BUKU OTOMATIS TERBARU
$query_max_kode = mysqli_query($koneksi, "SELECT kode_buku FROM books WHERE kode_buku REGEXP '^BK[0-9]+$' ORDER BY LENGTH(kode_buku) DESC, kode_buku DESC LIMIT 1");
if ($row_max = mysqli_fetch_assoc($query_max_kode)) {
    $last_code = $row_max['kode_buku'];
    $num = (int) filter_var($last_code, FILTER_SANITIZE_NUMBER_INT);
    $next_num = $num + 1;
    $next_kode_buku = 'BK' . str_pad($next_num, 3, '0', STR_PAD_LEFT);
} else {
    $next_kode_buku = 'BK001';
}

$active_page = 'buku';

include __DIR__ . '/resources/views/buku/index.view.php';
?>
