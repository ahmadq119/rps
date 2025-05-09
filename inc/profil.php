<?php
// Koneksi ke database
include "config.php";
session_start();

// Periksa apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

// Ambil ID user dari sesi
$id_user = $_SESSION['id_user'];

// Query untuk mengambil data user berdasarkan ID
$sql = "SELECT nama_lengkap, username, nip, alamat, no_hp FROM login WHERE id_user = ?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    die("Data user tidak ditemukan.");
}
// Tutup koneksi
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Dosen</title>
  <link rel="icon" type="image/png" href="logo.jpg" ">  
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      display: flex;
      height: 100vh; /* Memastikan body memenuhi tinggi viewport */
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
    }

    .sidebar {
      width: 250px;
      background-color: #343a40;
      color: white;
      padding: 20px;
      display: flex;
      flex-direction: column;
    }

    .sidebar h4 {
      margin-bottom: 20px;
    }

    .sidebar a {
      color: white;
      text-decoration: none;
      display: block;
      margin: 10px 0;
      padding: 10px;
      border-radius: 5px;
    }

    .sidebar a:hover {
      background-color: #495057;
    }

    .dropdown {
      position: relative;
    }

    .dropdown-btn {
      background: none;
      border: none;
      color: white;
      text-align: left;
      padding: 10px;
      width: 100%;
      cursor: pointer;
      border-radius: 5px;
    }

    .dropdown-btn:hover {
      background-color: #495057;
    }

    .dropdown-menu {
      display: none;
      margin-top: 5px;
      padding: 0;
      list-style: none;
      background-color: #495057;
      border-radius: 5px;
    }

    .dropdown-menu a {
      display: block;
      padding: 10px;
      color: white;
      text-decoration: none;
    }

    .dropdown-menu a:hover {
      background-color: #6c757d;
    }

    .dropdown-menu.active {
      display: block;
    }
    .main-content {
      margin-left: 260px;
      padding: 20px;
      width: calc(100% - 260px);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      padding: 12px;
      border: 1px solid #ddd;
      text-align: left;
    }

    th {
      background-color: #f4f4f4;
      text-align: center;
    }

    button {
      padding: 10px 20px;
      background-color: #343a40;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    button:hover {
      background-color: #495057;
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <h4><a href="dashboard_dosen.php">Dosen</a></h4>
    <hr>
    <!-- Dropdown RPS -->
    <div class="dropdown">
      <button class="dropdown-btn">RPS</button>
      <ul class="dropdown-menu">
        <li><a href="upload.php">Upload RPS</a></li>
        <li><a href="Akses_RPS.php">Akses RPS</a></li>
      </ul>
    </div>
    <hr>  
    <!-- Profil -->
    <a href="profil.php">Profil</a>
    <a href="Login.php" class="">Logout</a> 
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <h2>Profil Dosen</h2>
    <table>
      <tr>
        <th>Field</th>
        <th>Detail</th>
      </tr>
      <tr>
        <td>Nama Lengkap</td>
        <td><?php echo htmlspecialchars($user['nama_lengkap']); ?></td>
      </tr>
      <tr>
        <td>Username</td>
        <td><?php echo htmlspecialchars($user['username']); ?></td>
      </tr>
      <tr>
        <td>NIP</td>
        <td><?php echo htmlspecialchars($user['nip']); ?></td>
      </tr>
      <tr>
        <td>Alamat</td>
        <td><?php echo htmlspecialchars($user['alamat']); ?></td>
      </tr>
      <tr>
        <td>No HP</td>
        <td><?php echo htmlspecialchars($user['no_hp']); ?></td>
      </tr>
    </table>

    <!-- Form Logout -->
    <form action="login.php" method="post" style="margin-top: 20px;">
      <button type="submit">Logout</button>
    </form>
  </div>

  <script>
    // Mengatur dropdown untuk membuka dan menutup menu
    document.querySelector('.dropdown-btn').addEventListener('click', function() {
      const dropdownMenu = this.nextElementSibling;
      dropdownMenu.classList.toggle('active');
    });
  </script>
</body>
</html>
