<?php require_once "../layout/header.php"; ?>

<body>

    <?php include "../menu/menu.php"; ?>

    <div id="app" class="container-fluid mt-5">
        <div class="text-center mb-4">
            <button class="btn btn-primary" @click="tampildata">Tampil Data</button>
        </div>
        <div class="row justify-content-center mb-4">
            <div class="col-6">
                <input type="text" class="form-control" v-model="searchQuery" placeholder="Cari berdasarkan Kode Sample dan Customer">
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

        <table class="table table-bordered table-striped" v-if="info.length > 0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tgl Terima</th>
                    <th>Customer</th>
                    <th>No. Reg</th>
                    <th>Kode Sample</th>
                    <th>Nama Sample</th>
                    <th>Target Pengujian</th>
                    <th>Organ Target</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(a, index) in info" :key="a.kd_sample">
                    <td>{{ index + 1 }}</td>
                    <td>{{ formatDate(a.tgl_terima) }}</td>
                    <td>{{ a.nama_customer }}</td>
                    <td>{{ a.no_reg }}</td>
                    <td>{{ a.kd_sample }}</td>
                    <td>{{ a.nama_sample }}</td>
                    <td>{{ a.target_pengujian }}</td>
                    <td>{{ a.organ_target || '???' }}</td>
                    <td class="btn-group">
                        <!--input type="button" class="btn btn-warning btn-sm" value="Disposisi" @click="navigateToDisposisi(a.kd_sample)"-->
                        <button class="btn btn-warning btn-sm" @click="navigateToDisposisi(a.kd_sample)">
                            <i class="fas fa-edit"></i> Disposisi
                        </button>
                        <button class="btn btn-info btn-sm" @click="printDisposisi(a)">
                            <i class="fas fa-print"></i> Print
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Modal Isi Data Organ Target-->
        <div class="modal fade" id="ModalDisposisi" tabindex="-1" role="dialog" aria-labelledby="ModalDisposisiLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
                <div class="modal-content">

                    <form @submit.prevent="addData">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ModalDisposisiLabel"><span class="fas fa-edit"></span> Edit Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-2">
                                    <div class="mb-3">
                                        <label for="tgl_terima" class="form-label">Tanggal Terima</label>
                                        <input type="date" class="form-control form-control-sm" v-model="currentData.tgl_terima" required disabled>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="mb-3">
                                        <label for="kd_sample" class="form-label">Kode Sample</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.kd_sample" required disabled>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label for="no_reg" class="form-label">No. Registrasi</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.no_reg" required disabled>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="nama_customer" class="form-label">Nama Customer</label>
                                        <input type="text" v-model="currentData.nama_customer" class="form-control form-control-sm" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label for="nm_sample" class="form-label">Nama Sample</label>
                                        <input type="text" v-model="currentData.nama_sample" class="form-control form-control-sm" disabled>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <div class="mb-3">
                                        <label for="jumlah" class="form-label">Jumlah</label>
                                        <input type="number" class="form-control form-control-sm" v-model="currentData.jumlah" required disabled>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <div class="mb-3">
                                        <label for="satuan" class="form-label">Satuan</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.satuan" required disabled>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="mb-3">
                                        <label for="kondisi" class="form-label">Kondisi</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.kondisi_sample" required disabled>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="mb-3">
                                        <label for="tgl_uji" class="form-label">Tanggal Pengujian</label>
                                        <input type="date" class="form-control form-control-sm" v-model="currentData.tgl_uji" required>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label for="target_pengujian" class="form-label">Target Pengujian</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.target_pengujian" required disabled>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label for="metode_pengujian" class="form-label">Metode Pengujian</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.metode_pengujian" required disabled>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="manajerTeknis" class="form-label">Manajer Teknis</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.mt" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="">
                                                <label class="form-label">Organ Target:</label>

                                                <!-- Checkbox untuk Organ Target -->
                                                <!--div v-for="target in nilaiOrganTarget" :key="target.idorg">
                                                    <input type="checkbox"
                                                        :value="target.idorg"
                                                        v-model="selectedTargets">
                                                    {{ target.nama_organ }}
                                                </div-->
                                                <!-- Dropdown dengan Checkbox -->
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Pilih Organ Target
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <li v-for="target in nilaiOrganTarget" :key="target.idorg" class="dropdown-item">
                                                            <div class="form-check">
                                                                <input class="form-check-input form-check-sm" type="checkbox"
                                                                    :id="'checkbox-' + target.idorg"
                                                                    :value="target.idorg"
                                                                    v-model="selectedTargets">
                                                                <label class="form-check-label" :for="'checkbox-' + target.idorg">
                                                                    {{ target.nama_organ }}
                                                                </label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="">
                                                <label class="form-label">Organ yang Dipilih:</label>
                                                <ul>
                                                    <li v-for="targetId in selectedTargets" :key="targetId">
                                                        {{ getTargetName(targetId) }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row mt-5">

                            </div>
                        </div>
                        <div class="modal-footer bg-default">
                            <div class="col-12 d-flex">
                                <button type="submit" class="btn btn-primary btn-left">Simpan</button>
                            </div>
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