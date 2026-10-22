<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$id = intval($_GET['id'] ?? 0);

if ($id > 0) {
    $query = "DELETE FROM books WHERE id = $id";
    mysqli_query($koneksi, $query);
}

$redirect = (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'dashboard.php') !== false) ? 'dashboard.php?status=success' : 'buku.php?status=success';
header("Location: " . $redirect);
exit();
?>
