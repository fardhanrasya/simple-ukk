CREATE DATABASE IF NOT EXISTS crud_makanan;

USE crud_makanan;

CREATE TABLE pesanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_pelanggan VARCHAR(100),
    nama_makanan VARCHAR(100),
    jumlah INT
);
