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

// Cek apakah pesanan ada
$query = "SELECT * FROM pesanan WHERE id = $pesanan_id";
$result = $koneksi->query($query);

if ($result->num_rows == 0) {
    header("Location: index.php");
    exit();
}

// Redirect ke halaman konfirmasi
header("Location: konfirmasi.php?id=$pesanan_id");
exit();
?>
