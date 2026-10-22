<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// BINDING PARAMETER SEARCH & FILTER
$where = array();
$filter_info = array();

if (!empty($_GET['search'])) {
    $search = mysqli_real_escape_string($koneksi, trim($_GET['search']));
    $where[] = "(kode_buku LIKE '%$search%' OR judul LIKE '%$search%' OR penulis LIKE '%$search%' OR kategori LIKE '%$search%' OR penerbit LIKE '%$search%' OR tahun_terbit LIKE '%$search%')";
    $filter_info[] = "Kata Kunci: \"" . htmlspecialchars($_GET['search']) . "\"";
}
if (!empty($_GET['kategori'])) {
    $kategori = mysqli_real_escape_string($koneksi, trim($_GET['kategori']));
    $where[] = "kategori = '$kategori'";
    $filter_info[] = "Kategori: \"" . htmlspecialchars($_GET['kategori']) . "\"";
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

$filter_text = count($filter_info) > 0 ? implode(" | ", $filter_info) : "Semua Data Buku";

// Memanggil tampilan export PDF dari resources/views/export/pdf.view.php
include __DIR__ . '/resources/views/export/pdf.view.php';
?>
