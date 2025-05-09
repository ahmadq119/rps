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
  <link rel="icon" type="image/png" href="logo.jpg" ">
  <style>
    body {
      margin: 0;
      font-family: arial, sans-serif;
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


    /* Main Content */
    .main-content {
      display: flex;
      flex-direction: column;
      padding: 20px;
    }

    header {
      margin-top: 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
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

    .btn {
      padding: 5px 10px;
      border: none;
      cursor: pointer;
      text-transform: capitalize;
      margin-top: 5px;
      border-radius: 5px;
    }

    .btn-approve {
      background-color: #4CAF50;
      color: white;
    }

    .btn-pending {
      background-color: #FFC107;
      color: white;
    }

    /* Modal Styles */
    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
      background-color: #fefefe;
      margin: 15% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 50%;
    }

    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
      width: 12px;
    }

    ::-webkit-scrollbar-thumb {
      background: #888;
      border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: #555;
    }

    ::-webkit-scrollbar-track {
      background: #f1f1f1;
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

  <!-- Main Content -->
  <div class="main-content flex-grow-1">
    <h2>Persetujuan RPS</h2>

    <!-- Tabel Persetujuan RPS -->

    <table>
      <thead>
        <tr>
          <th>Nama</th>
          <th>Status</th>
          <th>Masukan</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['Matakuliah']); ?></td>
              <td><?= htmlspecialchars($row['status']); ?></td>
              <td><?= htmlspecialchars($row['alasan_penolakan']); ?></td>
              <td>

                <form method="POST" style="display:inline;">
                  <input type="hidden" name="id" value="<?= $row['id']; ?>">
                  <input type="hidden" name="status" value="Approved">
                  <button type="submit" class="btn btn-approve">Di Setujui</button>
                </form>
                <button class="btn btn-pending" onclick="openModal(<?= $row['id']; ?>)">Di Tolak</button>
              </td>

            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="4">Tidak ada data.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>

    <!-- Modal -->
    <div id="modal" class="modal">
      <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Masukan untuk Pending</h2>
        <form method="POST">
          <input type="hidden" id="modal-id" name="id">
          <input type="hidden" name="status" value="Pending">
          <label for="alasan_penolakan">Masukan:</label><br>
          <textarea id="alasan_penolakan" name="alasan_penolakan" rows="4" cols="50" required></textarea><br><br>
          <button type="submit" class="btn btn-pending">Submit</button>
        </form>
      </div>
    </div>

  </div>
  </div>
  <script>
    function openModal(id) {
      document.getElementById('modal-id').value = id;
      document.getElementById('modal').style.display = 'block';
    }

    function closeModal() {
      document.getElementById('modal').style.display = 'none';
    }
  </script>

  <script>
    // Mengatur dropdown untuk membuka dan menutup menu
    document.querySelector('.dropdown-btn').addEventListener('click', function() {
      const dropdownMenu = this.nextElementSibling;
      dropdownMenu.classList.toggle('active');
    });
  </script>

</body>

</html>