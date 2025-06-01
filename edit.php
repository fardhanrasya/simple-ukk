<?php
include 'db.php';

$id = $_GET['id'];
$data = $conn->query("SELECT * FROM pesanan WHERE id = $id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nama = $_POST['nama'];
  $makanan = $_POST['makanan'];
  $jumlah = $_POST['jumlah'];

  $conn->query("UPDATE pesanan SET nama_pelanggan='$nama', nama_makanan='$makanan', jumlah=$jumlah WHERE id=$id");
  header("Location: index.php");
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Pesanan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
  <h2>Edit Pesanan</h2>
  <form method="POST">
    <div class="mb-3">
      <label>Nama Pelanggan</label>
      <input type="text" name="nama" value="<?= $data['nama_pelanggan'] ?>" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Nama Makanan</label>
      <input type="text" name="makanan" value="<?= $data['nama_makanan'] ?>" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Jumlah</label>
      <input type="number" name="jumlah" value="<?= $data['jumlah'] ?>" class="form-control" required>
    </div>
    <button class="btn btn-warning">Update</button>
    <a href="index.php" class="btn btn-secondary">Batal</a>
  </form>
</body>
</html>
