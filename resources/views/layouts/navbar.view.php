<nav class="navbar">
    <div class="navbar-brand">
        <span>📚</span> Dashboard Admin Perpustakaan
    </div>
    <div class="navbar-menu">
        <span style="font-size: 14px; font-weight: 500;">Halo, <strong><?= htmlspecialchars($_SESSION['admin']); ?></strong></span>
        <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
</nav>
