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
    <title>SIADIL25 : Superadmin</title>
    <!-- Menambahkan favicon -->
    <link rel="icon" href="../img/logobulatbppmhkp.png" type="image/png">
    <link rel="stylesheet" href="../libs/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../libs/css/halaman1.css">
    <script src="../libs/vue.js"></script>
    <script src="../libs/axios.min.js"></script>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg warna-nav fixed-top" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand text-white" href="#"><i class="fas fa-home"></i> SIADIL Versi 25</a>
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

        <div class="container mt-4">
            <h2 class="text-primary">Hai {{ nama }}, Anda Berada di Ruang {{ nama_ruang }}</h2>
            <p>Pilih menu berikut untuk melaksanakan tugas Anda.</p>

            <div class="row">
                <div class="col-md-6">
                    <div class="card p-3">
                        <h4 class="card-title">Ringkasan Informasi Sample</h4>
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false">
                                        Jumlah Sampel 5 Tahun Terakhir
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Tahun</th>
                                                        <th v-for="(value, key) in infoPivot[0]" v-if="key !== 'Tahun'">{{ key }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(row, index) in infoPivot" :key="index">
                                                        <td>{{ row.Tahun }}</td>
                                                        <td v-for="(value, key) in row" v-if="key !== 'Tahun'">{{ value }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-3">
                        <h4 class="card-title" style="text-transform: capitalize;">Menu Ruang {{ nama_ruang }}</h4>
                        <div class="accordion" id="accordionExample2">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false">
                                        Referensi
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample2">
                                    <div class="accordion-body">
                                        <ul>
                                            <li v-for="link in menuLinks" :key="link.text">
                                                <a :href="link.url" class="card-link">{{ link.text }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
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