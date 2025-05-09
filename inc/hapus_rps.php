<?php
include('config.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus data berdasarkan ID
    $sql = "DELETE FROM tb_rps_1 WHERE id = $id";
    if (mysqli_query($koneksi, $sql)) {
        // Redirect ke halaman utama dengan status sukses
        header("Location: akses_rps.php?status=success");
    } else {
        // Redirect ke halaman utama dengan status gagal
        header("Location: hapus_rps.php?status=error");
    }
} else {
    // Redirect jika ID tidak ditemukan
    header("Location: hapus_rps.php?status=error");
}

// Tutup koneksi database
mysqli_close($koneksi);
?>