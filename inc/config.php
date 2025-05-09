<?php
// Konfigurasi database
$server = "localhost"; // Nama server (localhost untuk XAMPP)
$user = "root";        // Username default MySQL di XAMPP
$password = "";        // Password default di XAMPP biasanya kosong
$database = "k12"; // Nama database yang ingin Anda gunakan

// Membuat koneksi
$koneksi = mysqli_connect($server, $user, $password, $database);

// Cek apakah koneksi berhasil
if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
} else {

}