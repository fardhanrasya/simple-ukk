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
$page_title = "Konfirmasi Pesanan - Aplikasi Pemesanan Makanan";

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

// Update status pesanan menjadi selesai
$query = "UPDATE pesanan SET status = 'selesai' WHERE id = $pesanan_id";
$koneksi->query($query);

include 'header.php';
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-4">
                <div class="card-header bg-success text-white">
                    <h3 class="mb-0">Konfirmasi Pesanan Berhasil</h3>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-check-circle-fill text-success" viewBox="0 0 16 16">
                          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </svg>
                        <h4 class="mt-3">Status Pesanan Telah Diperbarui</h4>
                        <p class="lead">Pesanan #<?= $pesanan_id ?> telah dikonfirmasi sebagai <strong>Selesai</strong>.</p>
                    </div>
                    
                    <div class="alert alert-info">
                        <p class="mb-0">Terima kasih telah menggunakan layanan kami!</p>
                    </div>
                    
                    <a href="index.php" class="btn btn-primary mt-3">Kembali ke Halaman Utama</a>
                </div>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
