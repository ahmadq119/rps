<?php require_once "../layout/header.php" ?>

<body>

    <?php include "../menu/menu.php"; ?>

    <div id="app" class="container-fluid mt-5 " style="padding-top: 20px;">
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="text-center mb-4">
                    <button class="btn btn-primary" @click="tampildata">Tampil Data</button>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addDataModal">Tambah Data</button>
                </div>
                <div class="row justify-content-center mb-4">
                    <div class="col-6">
                        <input type="text" class="form-control" v-model="searchQuery" placeholder="Cari berdasarkan nama pegawai">
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
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm " v-if="info.length > 0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pegawai</th>
                                <th>NIP Pegawai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(a, index) in info" :key="a.idpeg">
                                <td>{{ index + 1 }}</td>
                                <td>{{ a.nama_pegawai }}</td>
                                <td>{{ a.nip_pegawai }}</td>
                                <td class="btn-group d-grid gap-2">
                                    <!--input type="button" class="btn btn-danger btn-sm" value="hapus" @click="confirmHapus(index, a.idrec)"-->
                                    <input type="button" class="btn btn-default btn-sm" value="ubah" @click="editData(index, a)">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Data -->
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
                                        <label class="form-label">Nama Pegawai</label>
                                        <input type="text" class="form-control form-control-sm" v-model="newData.nama_pegawai" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">NIP</label>
                                        <input type="text" class="form-control form-control-sm" v-model="newData.nip_pegawai" required>
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
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
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
                                        <label class="form-label">Nama Pegawai</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.nama_pegawai" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">NIP Pegawai</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.nip_pegawai" required>
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