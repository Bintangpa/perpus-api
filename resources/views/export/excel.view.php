<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta charset="utf-8">
    <style>
        table { border-collapse: collapse; width: 100%; }
        th { background-color: #4f46e5; color: white; border: 1px solid #000; padding: 8px; text-align: center; }
        td { border: 1px solid #000; padding: 6px; }
        .center { text-align: center; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">LAPORAN DATA BUKU PERPUSTAKAAN</h2>
    <table>
        <thead>
            <tr>
                <th>NO / ID</th>
                <th>KODE BUKU</th>
                <th>JUDUL BUKU</th>
                <th>PENULIS</th>
                <th>KATEGORI</th>
                <th>TAHUN TERBIT</th>
                <th>PENERBIT</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if ($result && mysqli_num_rows($result) > 0):
                while ($row = mysqli_fetch_assoc($result)): 
            ?>
                <tr>
                    <td class="center"><?= $row['id']; ?></td>
                    <td class="center"><?= htmlspecialchars($row['kode_buku']); ?></td>
                    <td><?= htmlspecialchars($row['judul']); ?></td>
                    <td><?= htmlspecialchars($row['penulis']); ?></td>
                    <td><?= htmlspecialchars($row['kategori']); ?></td>
                    <td class="center"><?= htmlspecialchars($row['tahun_terbit']); ?></td>
                    <td><?= htmlspecialchars($row['penerbit']); ?></td>
                </tr>
            <?php 
                endwhile;
            endif;
            ?>
        </tbody>
    </table>
</body>
</html>
