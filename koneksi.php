<?php
$host = "127.0.0.1";
$user = "root";
$pass = "";
$db   = "perpus_api";

$koneksi = @mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    // Fallback ke localhost jika 127.0.0.1 gagal
    $koneksi = mysqli_connect("localhost", $user, $pass, $db);
}

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
