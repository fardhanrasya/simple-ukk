<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Daftar Pesanan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

  <h2>Daftar Pesanan Makanan</h2>
  <a href="add.php" class="btn btn-primary mb-3">Tambah Pesanan</a>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Nama Pelanggan</th>
        <th>Nama Makanan</th>
        <th>Jumlah</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $result = $conn->query("SELECT * FROM pesanan");
        while($row = $result->fetch_assoc()):
      ?>
        <tr>
          <td><?= $row['nama_pelanggan'] ?></td>
          <td><?= $row['nama_makanan'] ?></td>
          <td><?= $row['jumlah'] ?></td>
          <td>
            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
            <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</body>
</html>
