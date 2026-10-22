<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// BINDING PARAMETER SEARCH & FILTER
$where = array();
if (!empty($_GET['search'])) {
    $search = mysqli_real_escape_string($koneksi, trim($_GET['search']));
    $where[] = "(kode_buku LIKE '%$search%' OR judul LIKE '%$search%' OR penulis LIKE '%$search%' OR kategori LIKE '%$search%' OR penerbit LIKE '%$search%' OR tahun_terbit LIKE '%$search%')";
}
if (!empty($_GET['kategori'])) {
    $kategori = mysqli_real_escape_string($koneksi, trim($_GET['kategori']));
    $where[] = "kategori = '$kategori'";
}

$where_clause = count($where) > 0 ? " WHERE " . implode(" AND ", $where) : "";

$order_by = " ORDER BY id ASC";
if (isset($_GET['sort'])) {
    if ($_GET['sort'] === 'judul_asc') $order_by = " ORDER BY judul ASC";
    else if ($_GET['sort'] === 'judul_desc') $order_by = " ORDER BY judul DESC";
    else if ($_GET['sort'] === 'tahun_desc') $order_by = " ORDER BY tahun_terbit DESC";
    else if ($_GET['sort'] === 'tahun_asc') $order_by = " ORDER BY tahun_terbit ASC";
}

$query = "SELECT * FROM books" . $where_clause . $order_by;
$result = mysqli_query($koneksi, $query);

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=data_buku_filtered.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Memanggil tampilan export excel dari resources/views/export/excel.view.php
include __DIR__ . '/resources/views/export/excel.view.php';
?>
