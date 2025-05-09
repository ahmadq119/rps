<?php
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

// Query untuk mendapatkan total RPS
$totalRPSQuery = "SELECT COUNT(*) AS total FROM tb_rps_1";
$totalRPSResult = $koneksi->query($totalRPSQuery);
$totalRPS = $totalRPSResult->fetch_assoc()['total'] ?? 0;

// Query untuk mendapatkan total RPS yang disetujui
$idQuery_rps_setuju = "SELECT COUNT(id) AS total_id_rps_setuju FROM tb_rps_1 WHERE status = 'Approved'";
$idResult_rps_setuju = $koneksi->query($idQuery_rps_setuju);
$total_id_rps_setuju = $idResult_rps_setuju ? $idResult_rps_setuju->fetch_assoc()['total_id_rps_setuju'] : 0;

// Query untuk mendapatkan jumlah RPS yang menunggu persetujuan
$pendingRPSQuery = "SELECT COUNT(*) AS pending FROM tb_rps_1 WHERE status = 'pending'";
$pendingRPSResult = $koneksi->query($pendingRPSQuery);
$pendingRPS = $pendingRPSResult->fetch_assoc()['pending'] ?? 0;

// Tutup koneksi
$koneksi->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="icon" type="image/png" href="logo.jpg" ">  
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      display: flex;
      height: 100vh;
    }

    .sidebar {
      width: 250px;
      background-color: #343a40;
      color: white;
      padding: 20px;
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
      position: relative;
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
      flex-grow: 1;
      padding: 20px;
      background-color: #f8f9fa;
    }

    .row {
      display: flex;
      gap: 20px;
    }

    .card {
      flex: 1;
      padding: 20px;
      border-radius: 10px;
      color: white;
      text-align: center;
    }

    .bg-primary {
      background-color: #007bff;
    }

    .bg-success {
      background-color: #28a745;
    }

    .bg-warning {
      background-color: #ffc107;
      color: black;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <h4><a href="admin.php">Admin</a></h4>
    <hr>
    <!-- Dropdown RPS -->
    <div class="dropdown">
      <button class="dropdown-btn">RPS</button>
      <ul class="dropdown-menu">
        <li><a href="list-rps.php">List RPS</a></li>
        <li><a href="persetujuan.php">Persetujuan RPS</a></li>
      </ul>
    </div>
    <hr>
    <!-- Dosen -->
    <a href="dosen.php">Dosen</a>
    <a href="Login.php" class="logout-btn">Logout</a>
  </div>

  <div class="main-content">
    <h2>Dashboard</h2>
    <p>Selamat datang di halaman dashboard admin!</p>
    <div class="row">
      <!-- Total RPS -->
      <div class="card bg-primary">
        <h5>Total RPS</h5>
        <p><?php echo $totalRPS; ?></p>
      </div>

      <!-- RPS Disetujui -->
      <div class="card bg-success">
        <h5>RPS Disetujui</h5>
        <p><?php echo $total_id_rps_setuju; ?></p>
      </div>

      <!-- Menunggu Persetujuan -->
      <div class="card bg-warning">
        <h5>Menunggu Persetujuan</h5>
        <p><?php echo $pendingRPS; ?></p>
      </div>
    </div>
  </div>

  <script>
    // Mengatur dropdown untuk membuka dan menutup menu
    document.querySelector('.dropdown-btn').addEventListener('click', function () {
      const dropdownMenu = this.nextElementSibling;
      dropdownMenu.classList.toggle('active');
    });
  </script>
</body>
</html>
