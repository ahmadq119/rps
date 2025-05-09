<?php
// Koneksi ke database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'k12'; // Database utama
 
$koneksi = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Query untuk mengambil data RPS
$sql = "SELECT Matakuliah, Kode, Rumpun_MK, `Bobot_(SKS)`, Semester, status, id 
        FROM tb_rps_1";

$result = $koneksi->query($sql);

$koneksi->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>List RPS</title>
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
  padding: 20px;
}
.card {
  border-radius: 10px;
}
.approved {
  background-color: green;
  color: white;
  padding: 10px;
  text-align: center;
  border-radius: 5px;
}
.rejected {
  background-color: red;
  color: white;
  padding: 10px;
  text-align: center;
  border-radius: 5px;
}
 /* Table Styles */
 table {

    width: 80%;
    border-collapse: collapse;
    margin-left: 100px;
    max-height: 500px;
    display: block;
    overflow-y: auto;
    margin-top: 20px;
        }

    th,
    td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
    }

    th {
    background-color: #f4f4f4;
    position: sticky;
    top: 0;
    z-index: 1;
    width: 200px;
    padding: 20px;
    background-color: lightgray;
    }
  h2{
    margin-left: 25px;
    }

    
/* Warna untuk status */
.status.approved {
    background-color: green;
    color: white;
    text-align: center;
    border-radius: 5px;
    padding: 5px;
}
.status.rejected {
    background-color: red;
    color: white;
    text-align: center;
    border-radius: 5px;
    padding: 5px;
}
.status.pending {
    background-color: orange;
    color: white;
    text-align: center;
    border-radius: 5px;
    padding: 5px;
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

  <div class="tabel">
    <h2>List RPS</h2>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>Matakuliah</th>
          <th>Kode</th>
          <th>Rumpun MK</th>
          <th>Bobot (SKS)</th>
          <th>Semester</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
          <tr>
            <td><?php echo $row['Matakuliah']; ?></td>
            <td><?php echo $row['Kode']; ?></td>
            <td><?php echo $row['Rumpun_MK']; ?></td>
            <td><?php echo $row['Bobot_(SKS)']; ?></td>
            <td><?php echo $row['Semester']; ?></td>
            <td class="status <?php echo strtolower($row['status']); ?>" ><?php echo $row['status']?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    
    <script>
    // Mengatur dropdown untuk membuka dan menutup menu
    document.querySelector('.dropdown-btn').addEventListener('click', function () {
      const dropdownMenu = this.nextElementSibling;
      dropdownMenu.classList.toggle('active');
    });
  </script>

  </div>
</body>
</html>
