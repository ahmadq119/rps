<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../login/index.html");
    exit();
}

// Cek apakah session sudah timeout
if (!isset($_SESSION['loggedin_time']) || (time() - $_SESSION['loggedin_time']) > 1800) {
    session_unset();
    session_destroy();
    header("Location: ../../login/index.html");
    exit();
}

// Perbarui waktu login
$_SESSION['loggedin_time'] = time();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= strtoupper($_SESSION['folder']); ?></title>
    <!-- Menambahkan favicon -->
    <link rel="icon" href="../../img/logobulatbppmhkp.png" type="image/png">
    <link rel="stylesheet" href="../../libs/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../libs/css/halaman1.css">

    <!-- Vue.js library -->
    <script src="../../libs/vue.js"></script>
    <script src="../../libs/axios.min.js"></script>
</head>