<?php
$host = 'localhost';
$user = 'root';
$pass = 'f@rdhan1426';
$db = 'crud_makanan';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
