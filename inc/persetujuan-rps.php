<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'k12');

// Periksa koneksi
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

// Proses perubahan status dengan masukan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Pastikan id dan status ada di $_POST
  if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = (int) $_POST['id'];
    $status = $conn->real_escape_string($_POST['status']);
    $masukan = isset($_POST['alasan_penolakan']) ? $conn->real_escape_string($_POST['alasan_penolakan']) : null;

    // Update status dan masukan di database
    $sql = "UPDATE tb_rps_1 SET status = '$status', alasan_penolakan = '$masukan' WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
      echo "";
    } else {
      echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
    }
  }
}

// Ambil data dari tabel
$result = $conn->query("SELECT * FROM tb_rps_1 ORDER BY id ASC");
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Persetujuan RPS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .sidebar {
      height: 100vh;
      background-color: #343a40;
      color: white;
      padding: 20px;
    }

    .sidebar a {
      color: white;
      text-decoration: none;
      display: block;
      margin: 10px 0;
    }

    .sidebar a:hover {
      text-decoration: underline;
    }

    .main-content {
      padding: 20px;
    }

    .card {
      border-radius: 10px;
    }

    .status {
      background-color: lightgray;
      padding: 5px;
      border-radius: 5px;
    }

    .approved {
      background-color: green;
      color: white;
      padding: 5px;
      border-radius: 5px;
    }

    .rejected {
      background-color: red;
      color: white;
      padding: 5px;
      border-radius: 5px;
    }
  </style>
</head>

<body>
  <div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar">
      <h4><a href="admin.php">Admin</a></h4>
      <hr>
      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="rpsDropdown" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,10">
          RPS
        </button>
        <ul class="dropdown-menu" aria-labelledby="rpsDropdown">
          <li><a class="dropdown-item" href="list-rps.php">List RPS</a></li>
          <li><a class="dropdown-item" href="persetujuan-rps.php">Persetujuan RPS</a></li>
        </ul>
      </div>
      <a href="dosen.php">Dosen</a>

    </div>

    <!-- Main Content -->
    <div class="main-content flex-grow-1">
      <h2>Persetujuan RPS</h2>

      <!-- Tabel Persetujuan RPS -->
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Matakuliah</th>
            <th>Kode</th>
            <th>Rumpun MK</th>
            <th>Bobot (SKS)</th>
            <th>Semester</th>
            <th>Otorisasi</th>
            <th>Aksi</th>
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
              <td class="status"><?php echo $row['OTORISASI']; ?></td>
              <td>
                <a href="persetujuan.php?approve_id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">Setujui</a>
                <a href="persetujuan.php?reject_id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Tolak</a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>