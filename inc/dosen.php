<?php
// Koneksi ke database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'k12'; // Nama database utama

$koneksi = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Query untuk mengambil total jumlah `id` dari tabel login_user
$idQuery = "SELECT COUNT(id) AS total_id FROM tb_rps_1";
$idResult = $koneksi->query($idQuery);
$total_id = $idResult->fetch_assoc()['total_id'] ?? 0;

// Query untuk mengambil data RPS dari tabel tb_rps_1
$sql = "SELECT Matakuliah, Kode, Rumpun_MK, `Bobot_(SKS)`, Semester, Tanggal_Penyusunan, OTORISASI, 
Capaian_Pembelajaran, Deskrisi_Singkat_MK, Pustaka, Media_Pembelajaran, Team_Teaching, Matakuliah_Syarat, id 
FROM tb_rps_1";

$result = $koneksi->query($sql);

// Tutup koneksi setelah semua query selesai
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
    /* Main Content Styling */
    .main-content {
      padding: 20px;
      flex-grow: 1;
      background-color: #f8f9fa;
    }

    .dashboard {
      display: flex;
      width: 100%;
      height: 90vh;
    }

    .ADD {
      background-color: #4CAF50;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
      margin-bottom: 20px;
    }

    .ADD:hover {
      background-color: darkgreen;
    }

    /* Overview Cards */
    .card {
      border-radius: 10px;
      padding: 15px;
      background-color: #007bff;
      color: white;
      text-align: center;
    }

    .card h3 {
      margin-bottom: 10px;
      font-size: 1.5rem;
    }

    .card p {
      font-size: 2rem;
      margin: 0;
    }

    .logout-btn{
      background-color: red;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
      margin-bottom: 20px;
    }

  </style>
</head>
<body>
  
    <!-- Sidebar -->
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
    <a href="Login.php" class="">Logout</a> 
  </div>

     

    <!-- Main Content -->
    <div class="main-content">
      <header>
        <h1>Kelola Pengguna</h1>
        <a href="tambah-dosen.php" class="ADD">Tambah User</a>
        
      </header>

      <!-- Overview Cards -->
      <section class="mt-4">
        <div class="row g-4">
          <div class="col-md-4">
            <div class="card">
              <h3>Total Dosen</h3>
              <p><?= number_format($total_id) ?></p>
            </div>
          </div>
        </div>
      </section>
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
