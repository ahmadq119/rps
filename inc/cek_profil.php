<?php
session_start();

// Periksa apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    // Redirect ke halaman login jika belum login
    header("Location: profil.php");
    exit();
}

// Koneksi ke database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'k12';

$koneksi = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil ID user dari sesi
$id_user = $_SESSION['user_id'];

// Query untuk mengambil data user berdasarkan ID
$sql = "SELECT username, nip, alamat, no_hp FROM login WHERE id_user = ?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    // Jika data user tidak ditemukan
    die("Data user tidak ditemukan.");
}

// Tutup koneksi
$stmt->close();
$koneksi->close();
?>
