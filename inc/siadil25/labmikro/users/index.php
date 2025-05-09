<?php require_once "../layout/header.php" ?>

<body>

    <?php include "../menu/menu.php"; ?>

    <div id="app" class="container-fluid mt-5" style="padding-top: 20px;">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card">
                    <h5 class="card-header bg-primary text-light">Data Username & Password</h5>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm" v-if="info.length > 0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Password</th>
                                        <th>Ruang/Bagian</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(a, index) in info" :key="a.userid">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ a.nama }}</td>
                                        <td>{{ a.username }} </td>
                                        <td>{{ a.password }} </td>
                                        <td>{{ a.nama_ruang }} </td>
                                        <td class="btn-group">
                                            <!--input type="button" class="btn btn-danger btn-sm" value="hapus" @click="confirmHapus(index, a.idrec)"-->
                                            <input type="button" class="btn btn-default btn-sm" value="ubah" @click="editData(index, a)">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
                                        <label class="form-label">Nama User</label>
                                        <input type="text" class="form-control form-control-sm" v-model="newData.nama" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="text" class="form-control form-control-sm" v-model="newData.username" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control form-control-sm" v-model="newData.password" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control form-control-sm" v-model="newData.email" placeholder="name@example.com" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">No. Kontak</label>
                                        <input type="text" class="form-control form-control-sm" v-model="newData.no_contact" placeholder="62xxxxx" required>
                                    </div>
                                </div>
                                <!-- Input Ruang/Bagian untuk Tambah Data -->
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="nama_ruang" class="form-label">Ruang/Bagian</label>
                                        <select v-model="newData.ruangid" class="form-control form-control-sm">
                                            <option v-for="nr in namaRuang" :value="nr.ruangid">{{ nr.nama_ruang }}</option>
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
                                        <label class="form-label">Nama</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.nama" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.username" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control form-control-sm" v-model="currentData.password" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.email" placeholder="example@gamil.com" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nomor Kontak</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.no_contact" required>
                                    </div>
                                </div>
                                <!-- Input Ruang/Bagian untuk Edit Data -->
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Ruang/Bagian</label>
                                        <select v-model="currentData.ruangid" class="form-control form-control-sm" disabled>
                                            <option v-for="nr in namaRuang" :value="nr.ruangid">{{ nr.nama_ruang }}</option>
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