<?php include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nama = $_POST['nama'];
  $makanan = $_POST['makanan'];
  $jumlah = $_POST['jumlah'];

  $conn->query("INSERT INTO pesanan (nama_pelanggan, nama_makanan, jumlah) VALUES ('$nama', '$makanan', $jumlah)");
  header("Location: index.php");
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Tambah Pesanan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
  <h2>Tambah Pesanan</h2>
  <form method="POST">
    <div class="mb-3">
      <label>Nama Pelanggan</label>
      <input type="text" name="nama" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Nama Makanan</label>
      <input type="text" name="makanan" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Jumlah</label>
      <input type="number" name="jumlah" class="form-control" required>
    </div>
    <button class="btn btn-success">Simpan</button>
    <a href="index.php" class="btn btn-secondary">Kembali</a>
  </form>
</body>
</html>
