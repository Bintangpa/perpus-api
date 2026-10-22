<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// QUERY REKAP DATA UNTUK HALAMAN EXPORT
$query_total = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM books");
$total_buku = mysqli_fetch_assoc($query_total)['total'] ?? 0;

$active_page = 'export';

// Memanggil tampilan khusus halaman export laporan
include __DIR__ . '/resources/views/export/index.view.php';
?>
