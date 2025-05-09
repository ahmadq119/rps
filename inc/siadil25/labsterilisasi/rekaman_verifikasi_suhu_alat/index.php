<?php require_once "../layout/header.php" ?>

<body>

    <?php include "../menu/menu.php"; ?>

    <div id="app" class="container p-4 my-5 border">
        <div class="row justify-content-center">
            <div class="col-10">


                <div class="text-center mb-4">
                    <button class="btn btn-primary" @click="tampildata">Tampil Data</button>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addDataModal">Tambah Rekaman Verifikasi Suhu Alat</button>
                </div>
                <table class="table table-bordered table-striped table-sm" v-if="info.length > 0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Ruang</th>
                            <th>Nama Alat</th>
                            <th>Tanggal</th>
                            <th>Hasil Pengukuran</th>
                            <th>Nilai Setting Alat</th>
                            <th>Petugas Pencatat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(a, index) in info" :key="a.id">
                            <td>{{ index + 1 }}</td>
                            <td>{{ a.ruangid }}-{{ a.nama_ruang }} </td>
                            <td>{{ a.nama_alat }} </td>
                            <td>{{ formatDate(a.tanggal) }}</td>
                            <td>{{ a.hasil_pengukuran }} </td>
                            <td>{{ a.nilai_set }} </td>
                            <td>{{ a.nama_pegawai }} </td>
                            <td class="btn-group d-grid gap-2">
                                <!--input type="button" class="btn btn-danger btn-sm" value="hapus" @click="confirmHapus(index, a.idrec)"-->
                                <input type="button" class="btn btn-default btn-sm" value="ubah" @click="editData(index, a)">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Tambah Data  -->
        <div class="modal fade modal-lg" id="addDataModal" tabindex="-1" role="dialog" aria-labelledby="addDataModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="addDataModalLabel"><span class="fas fa-plus"></span> Tambah Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="tambahData">
                            <div class="row">
                                <div class="col-1" hidden>
                                    <div class="mb-3">
                                        <label class="form-label">Ruang </label>
                                        <input type="text" id="ruangid" class="form-control form-control-sm" v-model="newData.ruangid" required disabled>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Alat</label>
                                        <auto-suggest v-model="newData.nama_alat" :suggestions="namaAlat" display-key="nama_alat" extra-key="nama_alat" @input="debouncedSearchAlat" @select="selectAlat"></auto-suggest>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal</label>
                                        <input type="date" class="form-control form-control-sm" v-model="newData.tanggal" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label class="form-label">Hasil Pengukuran</label>
                                        <input type="text" class="form-control form-control-sm" v-model="newData.hasil_pengukuran" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label class="form-label">Nilai Setting Alat</label>
                                        <input type="text" class="form-control form-control-sm" v-model="newData.nilai_set" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Petugas Pencatat</label>
                                        <auto-suggest v-model="newData.nama_pegawai" :suggestions="petugas" display-key="nama_pegawai" extra-key="nip_pegawai" @input="debouncedSearchPetugas" @select="selectPetugas"></auto-suggest>
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <!-- Tombol Simpan dan Batal -->
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="reset" class="btn btn-warning" @click="resetForm">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--Modal Edit-->
        <div class="modal fade modal-lg" id="editDataModal" tabindex="-1" role="dialog" aria-labelledby="aditDataModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="editDataModalLabel"><span class="fas fa-plus"></span> Edit Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="updateData">
                            <div class="row">
                                <div class="col-1" hidden>
                                    <div class="mb-3">
                                        <label class="form-label">Ruang</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.ruangid" required disabled>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Alat</label>
                                        <auto-suggest v-model="currentData.nama_alat" :suggestions="namaAlat" display-key="nama_alat" extra-key="nama_alat" @input="debouncedSearchAlat" @select="selectAlat"></auto-suggest>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal</label>
                                        <input type="date" class="form-control form-control-sm" v-model="currentData.tanggal" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label class="form-label">Hasil Pengukuran</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.hasil_pengukuran" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label class="form-label">Nilai Setting Alat</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.nilai_set" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Petugas Pencatat</label>
                                        <auto-suggest v-model="currentData.nama_pegawai" :suggestions="petugas" display-key="nama_pegawai" extra-key="nip_pegawai" @input="debouncedSearchPetugas" @select="selectPetugasNew"></auto-suggest>
                                    </div>
                                </div>


                            </div>
                            <div class="row">

                                <!-- Tombol Simpan dan Batal -->
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="reset" class="btn btn-warning" @click="resetForm">Batal</button>
                                </div>
                            </div>
                        </form>
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