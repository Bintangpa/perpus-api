<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Perpustakaan API</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="login-body">
    <div class="login-wrapper">
        
        <!-- BANNER KIRI (DESAIN REFERENSI) -->
        <div class="login-banner">
            <div class="banner-logo">
                <i class="fa-solid fa-book-bookmark"></i>
            </div>
            <div class="banner-text">
                <p style="text-transform: uppercase; font-size: 12px; font-weight: 700; letter-spacing: 1px; margin-bottom: 8px; opacity: 0.9;">PERPUSTAKAAN API</p>
                <h3>Kelola Data Buku Perpustakaan dengan Praktis & Terintegrasi</h3>
                <p>Akses sistem manajemen buku, statistik perpustakaan, JSON API, dan ekspor laporan Excel & PDF dalam satu tempat.</p>
            </div>
        </div>

        <!-- FORM KANAN -->
        <div class="login-form-container">
            <div class="form-header">
                <div class="form-header-logo">
                    <i class="fa-solid fa-asterisk"></i>
                </div>
                <h2>Masuk ke Akun Admin</h2>
                <p>Masukkan username dan password admin untuk mengakses dashboard</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span><?= htmlspecialchars($error); ?></span>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="username">Username Admin</label>
                    <div class="input-wrapper">
                        <input type="text" id="username" name="username" placeholder="Masukkan username admin" required autofocus autocomplete="off">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                        <button type="button" class="toggle-password" onclick="togglePasswordVisibility()">
                            <i class="fa-solid fa-eye" id="toggleEyeIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block" style="margin-top: 10px;">
                    <i class="fa-solid fa-right-to-bracket"></i> LOGIN ADMIN
                </button>
            </form>

            <div style="margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--border-color); text-align: center; font-size: 12px; color: var(--text-muted);">
                <i class="fa-solid fa-circle-info" style="color: var(--primary); margin-right: 4px;"></i> Akun Default: <strong>admin</strong> | Password: <strong>admin123</strong>
            </div>
        </div>

    </div>

    <script>
        function togglePasswordVisibility() {
            const pwdInput = document.getElementById('password');
            const icon = document.getElementById('toggleEyeIcon');
            if (pwdInput.type === 'password') {
                pwdInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                pwdInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
