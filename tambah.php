<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode_buku   = trim($_POST['kode_buku'] ?? '');
    $judul       = trim($_POST['judul'] ?? '');
    $penulis     = trim($_POST['penulis'] ?? '');
    $kategori    = trim($_POST['kategori'] ?? '');
    $tahun_terbit= trim($_POST['tahun_terbit'] ?? '');
    $penerbit    = trim($_POST['penerbit'] ?? '');

    if (!empty($kode_buku) && !empty($judul)) {
        $kode_buku    = mysqli_real_escape_string($koneksi, $kode_buku);
        $judul        = mysqli_real_escape_string($koneksi, $judul);
        $penulis      = mysqli_real_escape_string($koneksi, $penulis);
        $kategori     = mysqli_real_escape_string($koneksi, $kategori);
        $tahun_terbit = mysqli_real_escape_string($koneksi, $tahun_terbit);
        $penerbit     = mysqli_real_escape_string($koneksi, $penerbit);

        $query = "INSERT INTO books (kode_buku, judul, penulis, kategori, tahun_terbit, penerbit) 
                  VALUES ('$kode_buku', '$judul', '$penulis', '$kategori', '$tahun_terbit', '$penerbit')";

        if (mysqli_query($koneksi, $query)) {
            $redirect = (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'dashboard.php') !== false) ? 'dashboard.php?status=success' : 'buku.php?status=success';
            header("Location: " . $redirect);
            exit();
        } else {
            die("Error menyimpan data: " . mysqli_error($koneksi));
        }
    }
}

$redirect = (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'dashboard.php') !== false) ? 'dashboard.php' : 'buku.php';
header("Location: " . $redirect);
exit();
?>
