<?php
// Membuat koneksi ke database
include('config.php'); // Ganti dengan file koneksi database yang sebenarnya


// Mendapatkan data dari form
$username = $_POST['username'];
$level = $_POST['level'];
$password = md5($_POST['password']); // Meng-hash password menggunakan MD5
$nip = $_POST['nip'];
$alamat = $_POST['alamat'];
$no_hp = $_POST['no_hp'];

// Validasi apakah level adalah admin atau dosen
if ($level !== 'admin' && $level !== 'dosen') {
    echo "Level tidak valid. Harap pilih 'admin' atau 'dosen'.";
    exit;
}

// Menyiapkan query SQL untuk memasukkan data ke database
$query = "INSERT INTO username (username, level, password, nip, alamat, no_hp) 
          VALUES ('$username', '$level', '$password', '$nip', '$alamat', '$no_hp')";

// Menjalankan query
if (mysqli_query($koneksi, $query)) {
    echo "User berhasil ditambahkan!";
} else {
    echo "Error: " . mysqli_error($koneksi);
}

// Menutup koneksi database
mysqli_close($koneksi);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berhasil</title>
</head>
<body>  
    <h1><a href="InformasiLogin.php">Kembali</a></h1>
</body>
