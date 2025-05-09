<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login/index.html");
    exit();
}

// Cek apakah session sudah timeout
if (!isset($_SESSION['loggedin_time']) || (time() - $_SESSION['loggedin_time']) > 1800) {
    session_unset();
    session_destroy();
    header("Location: ../login/index.html");
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
    <title>SIADIL25 : <?php echo strtoupper($_SESSION['folder']) ?></title>
    <link rel="stylesheet" href="../libs/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../libs/css/halaman1.css">
    <script src="../libs/vue.js"></script>
    <script src="../libs/axios.min.js"></script>
    <style type="text/css">
        body {
            padding-top: 50px;
        }

        .warna-nav {
            background-color: midnightblue;
        }

        .nav-link.active {
            color: #fff !important;
            font-weight: bold;
            /* Contoh: warna putih */
            /*background-color: #007bff !important;
            /* Contoh: warna biru */
        }
    </style>
</head>

<body>
    <div id="app">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg warna-nav fixed-top" data-bs-theme="dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#"><i class="fas fa-home"></i> SIADIL Versi 25</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <button class="btn logout-btn" @click="logout"><i class="fas fa-sign-out-alt"></i> Logout</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <div class="container-fluid mt-3">
            <h2 style="text-transform: capitalize;"> Hai {{ nama }}. Anda Berada di Ruang {{ nama_ruang }}</h2>
            <p>Pilih link berikut untuk melaksanakan tugas anda.</p>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Ringkasan Informasi Sample</h4>

                            <div class="accordion accordion-flush accordion-sm" id="accordionFlushExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                            Jumlah Sampel 5 Tahun Terakhir
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <table class="table table-bordered table-striped table-sm" v-if="info.length > 0">
                                                <thead>
                                                    <tr>
                                                        <th>Tahun</th>
                                                        <th>Jumlah Sample</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(a, index) in info" :key="index">
                                                        <td>{{ a.Year }}</td>
                                                        <td>{{ a.Total_Records }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                            Info Lainnya
                                        </button>
                                    </h2>
                                    <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">Dalam pengembangan.</div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                            Info Lainnya
                                        </button>
                                    </h2>
                                    <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">Dalam pengembangan.</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title" style="text-transform: capitalize;">Menu Ruang {{ nama_ruang }}</h4>
                            <ul>
                                <li><a href="../labbahan/permintaan/" class="card-link">Daftar Permintaan Bahan</a></li>
                                <li><a href="../labbahan/bahan/" class="card-link">Form Permintaan Bahan</a></li>
                                <li><a href="../labbahan/rekaman_rh_temperatur/" class="card-link">Rekaman Ruang Pengujian</a></li>
                                <li><a href="../labbahan/rekaman_uv_ruang/" class="card-link">Rekaman UV Ruang Pengujian</a></li>
                                <li><a href="../labbahan/rekaman_uv_alat/" class="card-link">Rekaman UV Alat Pengujian</a></li>
                                <li><a href="../labbahan/report/" class="card-link">Laporan</a></li>
                                <li><a href="../labbahan/users/" class="card-link">User</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../libs/popper.min.js"></script>
    <script src="../libs/bootstrap.bundle.min.js"></script>
    <script src="apps.js"></script>
</body>

</html>