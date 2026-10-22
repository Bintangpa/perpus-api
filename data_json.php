<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

include 'koneksi.php';

$query = "SELECT * FROM books ORDER BY id ASC";
$result = mysqli_query($koneksi, $query);

$data = array();

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = array(
            "id" => (string)$row['id'],
            "kode_buku" => (string)$row['kode_buku'],
            "judul" => (string)$row['judul'],
            "penulis" => (string)$row['penulis'],
            "kategori" => (string)$row['kategori'],
            "tahun_terbit" => (string)$row['tahun_terbit'],
            "penerbit" => (string)$row['penerbit']
        );
    }
}

echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>
