<?php
session_start();
include 'koneksi.php';

if (isset($_SESSION['admin'])) {
    header("Location: dashboard.php");
    exit();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!empty($username) && !empty($password)) {
        $username_clean = mysqli_real_escape_string($koneksi, $username);
        $query = "SELECT * FROM admins WHERE username = '$username_clean' LIMIT 1";
        $result = mysqli_query($koneksi, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $admin = mysqli_fetch_assoc($result);
            $db_password = $admin['password'];

            if (password_verify($password, $db_password) || $password === $db_password) {
                $_SESSION['admin'] = $admin['username'];
                $_SESSION['admin_id'] = $admin['id'];
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "Username tidak ditemukan!";
        }
    } else {
        $error = "Silakan isi Username dan Password!";
    }
}

// Memanggil tampilan frontend dari resources/views/auth/login.view.php
include __DIR__ . '/resources/views/auth/login.view.php';
?>
