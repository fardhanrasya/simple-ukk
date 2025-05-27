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

// Proses form pesanan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pesan'])) {
    $nama_pemesan = $_POST['nama_pemesan'];
    $alamat = $_POST['alamat'];
    $no_telepon = $_POST['no_telepon'];
    $total = 0;
    
    // Hitung total harga
    $menu_dipilih = [];
    foreach ($_POST['menu'] as $menu_id => $jumlah) {
        if ($jumlah > 0) {
            $query = "SELECT harga FROM menu WHERE id = $menu_id";
            $result = $koneksi->query($query);
            $row = $result->fetch_assoc();
            $harga = $row['harga'];
            $subtotal = $harga * $jumlah;
            $total += $subtotal;
            
            $menu_dipilih[] = [
                'id' => $menu_id,
                'jumlah' => $jumlah,
                'subtotal' => $subtotal
            ];
        }
    }
    
    if (count($menu_dipilih) > 0) {
        // Simpan data pesanan
        $query = "INSERT INTO pesanan (nama_pemesan, alamat, no_telepon, total) 
                  VALUES ('$nama_pemesan', '$alamat', '$no_telepon', $total)";
        
        if ($koneksi->query($query) === TRUE) {
            $pesanan_id = $koneksi->insert_id;
            
            // Simpan detail pesanan
            foreach ($menu_dipilih as $menu) {
                $menu_id = $menu['id'];
                $jumlah = $menu['jumlah'];
                $subtotal = $menu['subtotal'];
                
                $query = "INSERT INTO detail_pesanan (pesanan_id, menu_id, jumlah, subtotal) 
                          VALUES ($pesanan_id, $menu_id, $jumlah, $subtotal)";
                $koneksi->query($query);
            }
            
            // Redirect ke halaman detail pesanan
            header("Location: detail.php?id=$pesanan_id");
            exit();
        } else {
            $error = "Error: " . $query . "<br>" . $koneksi->error;
        }
    } else {
        $error = "Silakan pilih minimal satu menu.";
    }
}

// Ambil data menu
$query = "SELECT * FROM menu";
$result = $koneksi->query($query);
$menu_list = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $menu_list[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Pemesanan Makanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center mb-4">Restoran Sederhana</h1>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Daftar Menu</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" action="">
                            <div class="row justify-content-center">
                                <?php foreach ($menu_list as $menu): ?>
                                <div class="col-md-6 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= $menu['nama'] ?></h5>
                                            <p class="card-text"><?= $menu['deskripsi'] ?></p>
                                            <p class="card-text text-primary fw-bold">Rp <?= number_format($menu['harga'], 0, ',', '.') ?></p>
                                            <div class="input-group">
                                                <span class="input-group-text">Jumlah</span>
                                                <input type="number" class="form-control" name="menu[<?= $menu['id'] ?>]" min="0" value="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            
                            <div class="card mt-4">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0">Informasi Pemesan</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="nama_pemesan" class="form-label">Nama Pemesan</label>
                                        <input type="text" class="form-control" id="nama_pemesan" name="nama_pemesan" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat Pengiriman</label>
                                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="no_telepon" class="form-label">Nomor Telepon</label>
                                        <input type="text" class="form-control" id="no_telepon" name="no_telepon" required>
                                    </div>
                                    <button type="submit" name="pesan" class="btn btn-primary">Pesan Sekarang</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
