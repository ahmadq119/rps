<?php
// Menampilkan semua error untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Memanggil koneksi database
include "config.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengambil data dari form login dengan validasi
    $username = isset($_POST['username']) ? mysqli_real_escape_string($koneksi, $_POST['username']) : '';
    $password_plain = isset($_POST['password']) ? $_POST['password'] : '';
    $level = isset($_POST['level']) ? mysqli_real_escape_string($koneksi, $_POST['level']) : '';

    // Enkripsi password dengan MD5
    $password = md5($password_plain);

    if ($username && $password_plain && $level) {
        // Query untuk memeriksa username dan level
        $query = "SELECT * FROM login WHERE username = '$username' AND level = '$level'";
        $cek_user = mysqli_query($koneksi, $query);

        if (!$cek_user) {
            die("Query gagal: " . mysqli_error($koneksi)); // Debug jika query gagal
        }

        $user_valid = mysqli_fetch_array($cek_user);

        if ($user_valid) {
            // Jika username terdaftar, periksa password
            if ($password === $user_valid['password']) {
                // Login berhasil
                $_SESSION['id_user'] = $user_valid['id_user']; // Menyimpan ID user
                $_SESSION['username'] = $user_valid['username'];
                $_SESSION['level'] = $user_valid['level'];

                // Redirect ke halaman sesuai level
                $redirect = ($level === 'admin') ? 'admin.php' : 'dashboard_dosen.php';
                header("Location: $redirect?message=success&user=$username");
            } else {
                // Password salah
                header("Location: login.php?message=error&reason=password");
            }
        } else {
            // Username atau level tidak terdaftar
            header("Location: login.php?message=error&reason=invalid_user");
        }
    } else {
        // Input tidak lengkap
        header("Location: login.php?message=error&reason=incomplete_input");
    }
    exit();
}
?>
