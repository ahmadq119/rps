<?php
include('config.php'); // Pastikan koneksi database

// Cek apakah ada input pencarian
$search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';

// Query untuk mengambil RPS dengan status 'Approved', tambahkan filter pencarian jika ada
$query = "SELECT id, Matakuliah FROM tb_rps_1 WHERE status = 'Approved'";
if ($search) {
    $query .= " AND Matakuliah LIKE '%$search%'";
}

// Query untuk mendapatkan total RPS yang disetujui
$idQuery_rps_setuju = "SELECT COUNT(id) AS total_id_rps_setuju FROM tb_rps_1 WHERE status = 'Approved'";
$idResult_rps_setuju = $koneksi->query($idQuery_rps_setuju);
$total_id_rps_setuju = $idResult_rps_setuju ? $idResult_rps_setuju->fetch_assoc()['total_id_rps_setuju'] : 0;

// Query untuk mengambil total jumlah `id` dari tabel login_user
$idQuery = "SELECT COUNT(id) AS total_id FROM tb_rps_1";
$idResult = $koneksi->query($idQuery);
$total_id = $idResult->fetch_assoc()['total_id'] ?? 0;

$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Pages RPS</title>
    <link rel="icon" type="image/png" href="logo.jpg" ">
    <style>
        /* CSS untuk tata letak dan styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
        }

        header {
            background-color: #fff;
            padding: 15px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: #000;
        }

        nav .login-btn {
            padding: 8px 15px;
            background-color: #17b844;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        main {
            padding: 20px;
        }

        .hero {
            text-align: center;
            margin: 15px 0;
        }

        .hero h1 {
            font-size: 2rem;
            margin-bottom: 40px;
        }

        .search-container {
            display: flex;
            justify-content: center;
            align-items: center;   
            margin-bottom: 40px; 
        }

        .search-input {
            padding: 10px 113px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .search-btn {
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            background-color: #007BFF;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }

        .info-cards {
            display: flex;
            justify-content: space-around;
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            gap: 20px; /* Menambahkan jarak antar card */
        }

        .info-cards .card {
            flex: 1;
            max-width: 250px;
            text-align: center;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            font-weight: bold;
            transition: transform 0.3s ease-in-out;
        }

        .info-cards .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        /* Kartu warna berbeda untuk Total Dosen dan RPS Disetujui */
        .card.total-dosen {
            background-color: #6c79bc;
            border-color: #322483;
        }

        .card.rps-disetujui {
            background-color: #5ae498;
            border-color: #317232;
        }

        .card h3 {
            margin-bottom: 10px;
        }

        .list-rps {
            text-align: center;
            margin-top: 30px;
        }

        .list-rps h2 {
            margin-bottom: 10px;
        }

        .courses-grid {
            display: flex;
            gap: 20px;
            justify-content: space-between;
            max-width: 840px;
            margin: 0 auto;
            padding: 20px;
            flex-wrap: wrap;
        }

        .course-card {
            width: 250px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease-in-out;
            background-color: #fff;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
        }

        .course-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .card-body {
            padding: 15px;
            text-align: center;
        }

        .card-body .card-title {
            font-size: 1.1rem;
            margin-bottom: 10px;
        }

        .btn-card {
            display: inline-block;
            padding: 8px 12px;
            background-color: #4CAF50;
            color: #fff;
            border-radius: 5px;
            border-color: #4CAF50;
            text-decoration: none;
            font-size: 12px;
            margin-top: 10px;
        }

        .btn-card-donlod {
            display: inline-block;
            padding: 8px 12px;
            background-color: red;
            color: #fff;
            border-radius: 5px;
            border-color: #4CAF50;
            text-decoration: none;
            font-size: 12px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">RPS</div>
            <form action="Login.php" method="post">
                <nav>
                    <button class="login-btn">Login</button>
                </nav>
            </form>
        </div>
    </header>
    
    <main>
        <section class="hero">
            <p>Selamat Datang di Website</p>
            <h1>Rencana Pembelajaran<span class="highlight">Semester</span></h1> 
        </section>

        <div class="search-container">
            <form action="" method="GET">
                <input type="text" name="search" class="search-input" placeholder="Cari mata kuliah..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <button type="submit" class="search-btn">Search</button>
            </form>
        </div>

        <section class="info-cards">
            <!-- Card untuk Total Dosen -->
            <div class="card total-dosen">
                <h3>Total Dosen</h3>
                <p><?= number_format($total_id) ?></p>
            </div>

            <!-- Card untuk RPS Disetujui -->
            <div class="card rps-disetujui">
                <h3>RPS</h3>
                <p><?php echo $total_id_rps_setuju; ?></p>
            </div>
        </section>

        <section class="list-rps">
            <h2>Daftar RPS</h2>
            <div class="courses-grid">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id'];
                        $Matakuliah = $row['Matakuliah'];
                ?>
                    <!-- Card for each course -->
                    <div class="course-card">
                        <img src="https://via.placeholder.com/250x150" alt="Course Image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $Matakuliah; ?></h5>
                            <p class="card-text">Deskripsi singkat mata kuliah ini.</p>
                            <a href="preview.php?id=<?php echo $id; ?>" class="btn-card">Detail</a>
                            <a href="donlod.php?id=<?php echo $id; ?>" class="btn-card-donlod">Download</a>
                            
                        </div>
                    </div>
                <?php
                    }
                } else {
                    echo "<p class='text-center'>Tidak ada mata kuliah yang sesuai dengan pencarian Anda.</p>";
                }
                ?>
            </div>
        </section>
    </main>
</body>
</html>
