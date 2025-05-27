-- Database untuk aplikasi pemesanan makanan sederhana
CREATE DATABASE IF NOT EXISTS db_pemesanan_makanan;

USE db_pemesanan_makanan;

-- Tabel menu makanan
CREATE TABLE IF NOT EXISTS menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    harga DECIMAL(10, 2) NOT NULL,
    gambar VARCHAR(255)
);

-- Tabel pesanan
CREATE TABLE IF NOT EXISTS pesanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_pemesan VARCHAR(100) NOT NULL,
    alamat TEXT NOT NULL,
    no_telepon VARCHAR(15) NOT NULL,
    tanggal DATETIME DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10, 2) NOT NULL,
    status ENUM('menunggu', 'diproses', 'selesai') DEFAULT 'menunggu'
);  

-- Tabel detail pesanan
CREATE TABLE IF NOT EXISTS detail_pesanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pesanan_id INT NOT NULL,
    menu_id INT NOT NULL,
    jumlah INT NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (pesanan_id) REFERENCES pesanan(id),
    FOREIGN KEY (menu_id) REFERENCES menu(id)
);

-- Isi data menu makanan
INSERT INTO menu (nama, deskripsi, harga, gambar) VALUES
('Nasi Goreng', 'Nasi goreng spesial dengan telur dan ayam', 25000, 'nasi_goreng.jpg'),
('Mie Goreng', 'Mie goreng dengan bumbu khas dan seafood', 23000, 'mie_goreng.jpg'),
('Ayam Bakar', 'Ayam bakar dengan bumbu manis pedas', 30000, 'ayam_bakar.jpg'),
('Soto Ayam', 'Soto ayam dengan kuah bening dan daging ayam suwir', 20000, 'soto_ayam.jpg'),
('Es Teh Manis', 'Es teh manis segar', 5000, 'es_teh.jpg'),
('Es Jeruk', 'Es jeruk segar dengan potongan jeruk asli', 7000, 'es_jeruk.jpg');
