<?php
// Koneksi ke database
$host = "localhost";
$username = "root";
$password = "f@rdhan1426";
$database = "db_pemesanan_makanan";

$koneksi = new mysqli($host, $username, $password, $database);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Cek ID pesanan
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$pesanan_id = $_GET['id'];

// Ambil data pesanan
$query = "SELECT * FROM pesanan WHERE id = $pesanan_id";
$result = $koneksi->query($query);

if ($result->num_rows == 0) {
    header("Location: index.php");
    exit();
}

$pesanan = $result->fetch_assoc();

// Ambil detail pesanan
$query = "SELECT dp.*, m.nama, m.harga 
          FROM detail_pesanan dp 
          JOIN menu m ON dp.menu_id = m.id 
          WHERE dp.pesanan_id = $pesanan_id";
$result = $koneksi->query($query);

$detail_pesanan = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $detail_pesanan[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Aplikasi Pemesanan Makanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h2 class="mb-0">Detail Pesanan #<?= $pesanan_id ?></h2>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>Informasi Pemesan</h5>
                        <p><strong>Nama:</strong> <?= $pesanan['nama_pemesan'] ?></p>
                        <p><strong>Alamat:</strong> <?= $pesanan['alamat'] ?></p>
                        <p><strong>No Telepon:</strong> <?= $pesanan['no_telepon'] ?></p>
                    </div>
                    <div class="col-md-6">
                        <h5>Informasi Pesanan</h5>
                        <p><strong>Tanggal Pesan:</strong> <?= date('d-m-Y H:i', strtotime($pesanan['tanggal'])) ?></p>
                        <p><strong>Status:</strong> <span class="badge bg-warning"><?= ucfirst($pesanan['status']) ?></span></p>
                        <p><strong>Total Pembayaran:</strong> <span class="text-primary fw-bold">Rp <?= number_format($pesanan['total'], 0, ',', '.') ?></span></p>
                    </div>
                </div>
                
                <h5>Daftar Menu yang Dipesan</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Menu</th>
                                <th>Harga Satuan</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($detail_pesanan as $detail): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $detail['nama'] ?></td>
                                <td>Rp <?= number_format($detail['harga'], 0, ',', '.') ?></td>
                                <td><?= $detail['jumlah'] ?></td>
                                <td>Rp <?= number_format($detail['subtotal'], 0, ',', '.') ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="table-primary">
                            <tr>
                                <th colspan="4" class="text-end">Total</th>
                                <th>Rp <?= number_format($pesanan['total'], 0, ',', '.') ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <a href="index.php" class="btn btn-primary">Kembali ke Halaman Utama</a>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
