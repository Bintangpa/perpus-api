<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>laporan_data_buku.pdf</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 20mm;
        }
        body {
            font-family: Arial, sans-serif;
            color: #000;
            background: #fff;
            padding: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0 0 5px 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .header p {
            margin: 2px 0;
            font-size: 12px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }
        .center {
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom: 20px; text-align: right;">
        <button onclick="window.print()" style="padding: 8px 16px; background: #4f46e5; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">🖨️ Cetak / Simpan PDF</button>
    </div>

    <div class="header">
        <h2>LAPORAN DATA BUKU PERPUSTAKAAN</h2>
        <p>Filter: <strong><?= $filter_text; ?></strong></p>
        <p>Sistem Informasi Perpustakaan API - Tanggal Cetak: <?= date('d/m/Y'); ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 50px;">NO</th>
                <th style="width: 80px;">KODE</th>
                <th>JUDUL BUKU</th>
                <th>PENULIS</th>
                <th>KATEGORI</th>
                <th style="width: 70px;">TAHUN</th>
                <th>PENERBIT</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            if ($result && mysqli_num_rows($result) > 0):
                while ($row = mysqli_fetch_assoc($result)): 
            ?>
                <tr>
                    <td class="center"><?= $no++; ?></td>
                    <td class="center"><strong><?= htmlspecialchars($row['kode_buku']); ?></strong></td>
                    <td><?= htmlspecialchars($row['judul']); ?></td>
                    <td><?= htmlspecialchars($row['penulis']); ?></td>
                    <td><?= htmlspecialchars($row['kategori']); ?></td>
                    <td class="center"><?= htmlspecialchars($row['tahun_terbit']); ?></td>
                    <td><?= htmlspecialchars($row['penerbit']); ?></td>
                </tr>
            <?php 
                endwhile;
            else:
            ?>
                <tr>
                    <td colspan="7" class="center">Tidak ada data buku yang sesuai pencarian.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak oleh: <strong><?= htmlspecialchars($_SESSION['admin']); ?></strong></p>
    </div>
</body>
</html>
