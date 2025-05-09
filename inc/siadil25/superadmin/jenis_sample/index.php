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
    <title>Customer</title>

    <link rel="stylesheet" href="../../libs/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Vue.js library -->
    <script src="../../libs/vue.js"></script>
    <script src="../../libs/axios.min.js"></script>

    <style type="text/css">
        body {
            padding-top: 50px;
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

    <div id="app" class="container-fluid mt-5" style="padding-top: 20px;">
        <div class="row justify-content-center">
            <div class="col-6">


                <div class="text-center mb-4">
                    <button class="btn btn-primary" @click="tampildata">Tampil Data</button>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addDataModal">Tambah Data</button>
                </div>
                <div class="row justify-content-center mb-4">
                    <div class="col-8">
                        <input type="text" class="form-control" v-model="searchQuery" placeholder="Cari berdasarkan Jenis Sample, Satuan, Kelompok">
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-secondary" @click="caridata">Cari</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <div v-if="searchMessage" class="alert alert-warning" role="alert">
                            {{ searchMessage }}
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped table-sm" v-if="info.length > 0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Sample</th>
                            <th>Satuan</th>
                            <th>Kelompok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(a, index) in info" :key="a.idsample">
                            <td>{{ index + 1 }}</td>
                            <td>{{ a.nama_sample }}</td>
                            <td>{{ a.satuan }} </td>
                            <td>{{ a.kelompok }} </td>
                            <td class="btn-group d-grid gap-2">
                                <!--input type="button" class="btn btn-danger btn-sm" value="hapus" @click="confirmHapus(index, a.idrec)"-->
                                <input type="button" class="btn btn-default btn-sm" value="ubah" @click="editData(index, a)">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Tambah Data User -->
        <div class="modal fade" id="addDataModal" tabindex="-1" role="dialog" aria-labelledby="addDataModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="addDataModalLabel"><span class="fas fa-plus"></span> Tambah Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="tambahData">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Sample</label>
                                        <input type="text" class="form-control form-control-sm" v-model="newData.nama_sample" required>
                                    </div>
                                </div>

                                <!-- Input Satuan untuk Tambah Data -->
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Satuan</label>
                                        <select id="satuan" v-model="newData.satuan" class="form-control form-control-sm">
                                            <option v-for="satuan in nilaiSatuan" :key="satuan.idsatuan" :value="satuan.idsatuan">
                                                {{ satuan.satuan }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Input Kelompok untuk Tambah Data -->
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Kelompok</label>
                                        <select id="kelompok" v-model="newData.kelompok" class="form-control form-control-sm">
                                            <option v-for="kelompok in nilaiKelompok" :key="kelompok.idkelompok" :value="kelompok.idkelompok">
                                                {{ kelompok.kelompok }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <button type="submit" class="btn btn-primary btn-left">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit Data -->
        <div class="modal fade" id="editDataModal" tabindex="-1" role="dialog" aria-labelledby="editDataModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="editDataModalLabel"><span class="fas fa-edit"></span> Edit Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="updateData">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Sample</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.nama_sample" required>
                                    </div>
                                </div>

                                <!-- Input Satuan untuk Edit Data -->
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Satuan</label>
                                        <select class="form-control form-control-sm" v-model="currentData.idsatuan">
                                            <option v-for="satuan in nilaiSatuan" :value="satuan.idsatuan">
                                                {{ satuan.satuan }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Input Kelompok untuk Edit Data -->
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Kelompok</label>
                                        <select class="form-control form-control-sm" v-model="currentData.idkelompok">
                                            <option v-for="kelompok in nilaiKelompok" :value="kelompok.idkelompok">
                                                {{ kelompok.kelompok }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <button type="submit" class="btn btn-primary btn-left">Simpan</button>
                                </div>
                            </div>

                    </div>
                </div>
            </div>
        </div>
        <script src="../../libs/popper.min.js"></script>
        <script src="../../libs/bootstrap.bundle.min.js"></script>
        <script src="../../logout.js"></script>
        <script src="apps.js"></script>
</body>

</html>