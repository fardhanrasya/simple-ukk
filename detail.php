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

// Set judul halaman
$page_title = "Detail Pesanan - Aplikasi Pemesanan Makanan";

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

<?php include 'header.php'; ?>
    <div class="container">
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
                
                <div class="row mt-4">
                    <div class="col-md-6">
                        <a href="index.php" class="btn btn-primary">Kembali ke Halaman Utama</a>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">QR Code Konfirmasi Pesanan</h5>
                            </div>
                            <div class="card-body text-center">
                                <p>Scan QR code ini untuk mengubah status pesanan menjadi <strong>Selesai</strong></p>
                                <?php
                                include 'qrcode.php';
                                $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
                                $qr_url = $base_url . "/update_status.php?id=" . $pesanan_id;
                                $qrCodeUrl = generateQRCode($qr_url, 300);
                                ?>
                                <img src="<?= $qrCodeUrl ?>" alt="QR Code" class="img-fluid" style="max-width: 250px;">
                                <p class="mt-2 text-muted small">QR code ini hanya dapat digunakan sekali</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
