<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Dosen</title>
  <link rel="icon" type="image/png" href="logo.jpg" ">  
  <style>
    /* General Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      display: flex;
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
      height: 100vh;
    }

    /* Sidebar Styles */
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
      padding: 10px;
      margin: 10px 0;
      border-radius: 5px;
      display: block;
    }

    .sidebar a:hover {
      background-color: #495057;
    }

    .dropdown-btn {
      background: none;
      border: none;
      color: white;
      padding: 10px;
      width: 100%;
      text-align: left;
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
      color: white;
      padding: 10px;
      text-decoration: none;
      display: block;
    }

    .dropdown-menu a:hover {
      background-color: #6c757d;
    }

    .dropdown-menu.active {
      display: block;
    }

    /* Main Content */
    .table-container {
      width: calc(100% - 260px);
      margin: 20px auto;
      padding: 20px;
      overflow: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th,
    td {
      padding: 10px;
      border: 1px solid #ddd;
      text-align: center;
    }

    th {
      background-color: lightgray;
      position: sticky;
      top: 0;
      z-index: 1;
    }

    /* Buttons */
    .btn {
      padding: 8px 12px;
      text-decoration: none;
      font-weight: bold;
      border-radius: 5px;
      transition: all 0.3s ease;
    }

    .btn-edit {
      background-color: #4CAF50;
      color: white;
    }

    .btn-edit:hover {
      background-color: #45a049;
    }

    .btn-hapus {
      background-color: #e53e3e;
      color: white;
    }

    .btn-hapus:hover {
      background-color: #c53030;
    }

    .btn-download {
      background-color: #2b6cb0;
      color: white;
    }

    .btn-download:hover {
      background-color: #3182ce;
    }
  </style>
</head>

<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <h4><a href="dashboard_dosen.php">Dosen</a></h4>
    <hr>
    <button class="dropdown-btn">RPS</button>
    <ul class="dropdown-menu">
      <li><a href="upload.php">Upload RPS</a></li>
      <li><a href="Akses_RPS.php">Akses RPS</a></li>
    </ul>
    <hr>
    <a href="profil.php">Profil</a>
    <a href="Login.php" class="">Logout</a> 
  </div>

  <!-- Main Content -->
  <div class="table-container">
    <table>
      <tr>
        <th>Matakuliah</th>
        <th>Kode</th>
        <th>Rumpun MK</th>
        <th>Bobot (SKS)</th>
        <th>Semester</th>
        <th>Status</th>
        <th>Alasan Penolakan</th>
        <th>Aksi</th>
      </tr>
      <?php
      // Database connection
      $host = "localhost";
      $username = "root";
      $password = "";
      $dbname = "k12";

      $koneksi = new mysqli($host, $username, $password, $dbname);

      if ($koneksi->connect_error) {
        die("Koneksi gagal: " . $koneksi->connect_error);
      }

      $sql = "SELECT * FROM tb_rps_1";
      $result = $koneksi->query($sql);

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $statusClass = $row['status'] === 'disetujui' ? 'approved' : 'rejected';
          echo "<tr>
                  <td>{$row['Matakuliah']}</td>
                  <td>{$row['Kode']}</td>
                  <td>{$row['Rumpun_MK']}</td>
                  <td>{$row['Bobot_(SKS)']}</td>
                  <td>{$row['Semester']}</td>
                  <td class='{$statusClass}'>{$row['status']}</td>
                  <td>{$row['alasan_penolakan']}</td>
                  <td>
                    <a href='edit_rps.php?id={$row['id']}' class='btn btn-edit'>Edit</a>
                    <a href='hapus_rps.php?id={$row['id']}' class='btn btn-hapus'onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Hapus</a>
                    <a href='download_rps.php?id={$row['id']}' class='btn btn-download'>Download</a>
                  </td>
                </tr>";
        }
      } else {
        echo "<tr><td colspan='8'>Tidak ada data.</td></tr>";
      }

      $koneksi->close();
      ?>
    </table>
  </div>

  <script>
    document.querySelector('.dropdown-btn').addEventListener('click', function() {
      const dropdownMenu = this.nextElementSibling;
      dropdownMenu.classList.toggle('active');
    });
  </script>
</body>

</html>
