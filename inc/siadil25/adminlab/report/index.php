<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../login/index.html");
    exit();
}

// Cek apakah session sudah timeout
if (!isset($_SESSION['loggedin_time']) || (time() - $_SESSION['loggedin_time']) > 1800) {
    session_unset();
    session_destroy();
    header("Location: ../../login/index.html");
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
    <title>Penerimaan</title>

    <script src="../../libs/html2pdf.bundle.min.js"></script>
    <link rel="stylesheet" href="../../libs/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script src="../../libs/vue.js"></script>
    <script src="../../libs/axios.min.js"></script>
    <style type="text/css">
        body {
            padding-top: 70px;
        }

        .table {
            --bs-table-color: var(--bs-gray-600);
            --bs-table-bg: var(--bs-gray-100);
            --bs-table-border-color: transparent;
            font-size: small;
        }

        .list-group {
            position: absolute;
            z-index: 1000;
            width: 50%;
        }

        .modal {
            font-size: small;
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
    <!--link href="headers.css" rel="stylesheet"-->
</head>

<body>

    <?php include "../menu/menu.php"; ?>

    <div id="app">
        <div class="container mt-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Form Pilihan Laporan</h5>
                </div>
                <div class="card-body">
                    <form class="row justify-content-center">
                        <div class="col-3">
                            <label for="laporan" class="form-label">Jenis Laporan</label>
                            <select v-model="newData.laporan" id="laporan" class="form-select">
                                <option value="" disabled>Pilih Jenis Laporan</option>
                                <option value="1">Rekap Penerimaan Sample</option>
                                <option value="2">Rekap Penanganan Sample</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <label for="bulan" class="form-label">Bulan</label>
                            <select v-model="newData.bulan" id="bulan" class="form-select">
                                <option value="" disabled>Pilih Bulan</option>
                                <option v-for="bulan in dataBulan" :value="bulan.value">{{ bulan.name }}</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <label for="tahun" class="form-label">Tahun</label>
                            <select v-model="newData.tahun" id="tahun" class="form-select">
                                <option value="" disabled>Pilih Tahun</option>
                                <option v-for="tahun in dataTahun" :value="tahun">{{ tahun }}</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <label class="form-label">Aksi</label>
                            <button type="button" class="btn btn-primary form-control" @click="printData">Cetak PDF</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Sertakan jQuery dari CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="../../libs/popper.min.js"></script>
    <script src="../../libs/bootstrap.bundle.min.js"></script>
    <script src="../../logout.js"></script>
    <script src="apps.js"></script>
</body>

</html>