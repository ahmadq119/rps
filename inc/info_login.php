<?php
// Koneksi ke database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'K12';

$conn = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}


// Tutup koneksi
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f6f8;
        }

        .dashboard {
            display: grid;
            grid-template-columns: 250px 1fr;
            width: 90%;
            max-width: 1200px;
            height: 90vh;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Sidebar */
        .sidebar {
            background-color: #2d3748;
            color: #fff;
            padding: 20px;
        }

        .sidebar h2 {
            margin-bottom: 20px;
        }

        .sidebar nav ul {
            list-style: none;
        }

        .sidebar nav ul li {
            margin: 15px 0;
        }

        .sidebar nav ul li a {
            color: #a0aec0;
            text-decoration: none;
        }

        .sidebar nav ul li a:hover {
            color: #63b3ed;
        }

        /* Main Content */
        .main-content {
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .ADD {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 450px;
            text-decoration: none;
        }

        .ADD:hover {
            background-color: darkgreen;
        }

        .logout-btn {
            background-color: #e53e3e;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .logout-btn:hover {
            background-color: #c53030;
        }

        th, td {
            padding: 15px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }


    </style>
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>My Dashboard</h2>
            <nav>
                <ul>
                    <li><a href="Dashboard_Admin.php">Dashboard</a></li>
                    <li><a href="InformasiLogin.php">Informasi User</a></li>
                    <li><a href="Profil_User_admin.php">Profile</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header>
                <h1>Informasi User</h1>
                <a href="tambah_user.php" class="ADD">Tambah User</a>
                <a href="halaman_utama.php" class="logout-btn">Logout</a>
            </header>

            

            <!-- Tabel Data Login User -->
            <table>
                <tr>
                    
                    <th>User</th>
                    <th>Password</th>
                    <th>NIP</th>
                    <th>Alamat</th>
                    <th>NoHP</th>
                    <th>Aksi</th>
                </tr>
                
                <?php
                // Koneksi ulang ke database karena sudah ditutup di atas
                $conn = new mysqli($host, $username, $password, $database);
                if ($conn->connect_error) {
                    die("Koneksi gagal: " . $conn->connect_error);
                }
 
                // Query untuk mengambil data
                $sql = "SELECT id, User, Password, NIP, Alamat, NoHP FROM login_user";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        
                        echo "<tr>";
                        
                        echo "<td>" . $row["User"] . "</td>";
                        echo "<td>" . $row["Password"] . "</td>";
                        echo "<td>" . $row["NIP"] . "</td>";
                        echo "<td>" . $row["Alamat"] . "</td>";
                        echo "<td>" . $row["NoHP"] . "</td>";
                        echo "<td>
                            <a href='edit_user.php?id=" . $row["id"] . "' class='btn btn-edit'>Edit</a> | 
                            <a href='hapus_user.php?id=" . $row["id"] . "' class='btn btn-hapus' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Hapus</a>
                          </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Tidak ada data.</td></tr>";
                }

                // Tutup koneksi
                $conn->close();
                ?>
            </table>
        </main>
    </div>
</body>
</html>