<?php

use Illuminate\Support\Facades\Route;

// Route untuk file CSS
Route::get('/style.css', function () {
    $path = base_path('style.css');
    if (file_exists($path)) {
        return response()->file($path, ['Content-Type' => 'text/css']);
    }
    return response('', 404);
});

// 1. Route Halaman Utama (Langsung Arahkan ke Login / Index)
Route::get('/', function () {
    require base_path('index.php');
});

// 2. Route Login & Logout
Route::any('/login', function () { require base_path('login.php'); });
Route::any('/login.php', function () { require base_path('login.php'); });
Route::any('/logout', function () { require base_path('logout.php'); });
Route::any('/logout.php', function () { require base_path('logout.php'); });

// 3. Route Dashboard (/dashboard dan /dashboard.php)
Route::any('/dashboard', function () { require base_path('dashboard.php'); });
Route::any('/dashboard.php', function () { require base_path('dashboard.php'); });

// Route Data Buku (/buku dan /buku.php)
Route::any('/buku', function () { require base_path('buku.php'); });
Route::any('/buku.php', function () { require base_path('buku.php'); });

// 4. Route Statistik (/statistik dan /statistik.php)
Route::any('/statistik', function () { require base_path('statistik.php'); });
Route::any('/statistik.php', function () { require base_path('statistik.php'); });

// 5. Route Export Page (/export dan /export.php)
Route::any('/export', function () { require base_path('export.php'); });
Route::any('/export.php', function () { require base_path('export.php'); });

// 6. Route API JSON
Route::any('/data_json', function () { require base_path('data_json.php'); });
Route::any('/data_json.php', function () { require base_path('data_json.php'); });

// 7. Route CRUD & Action Export Files
Route::any('/tambah.php', function () { require base_path('tambah.php'); });
Route::any('/edit.php', function () { require base_path('edit.php'); });
Route::any('/hapus.php', function () { require base_path('hapus.php'); });
Route::any('/export_excel.php', function () { require base_path('export_excel.php'); });
Route::any('/export_pdf.php', function () { require base_path('export_pdf.php'); });
