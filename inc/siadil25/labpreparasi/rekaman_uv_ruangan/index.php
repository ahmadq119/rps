<?php require_once "../layout/header.php"; ?>

<body>

    <?php include "../menu/menu.php"; ?>

    <div id="app" class="container-fluid mt-5" style="padding-top: 20px;">
        <div class="row justify-content-center">
            <div class="col-10">


                <div class="text-center mb-4">
                    <button class="btn btn-primary" @click="tampildata">Tampil Data</button>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addDataModal">Tambah Rekaman UV Ruang Pengujian</button>
                </div>
                <table class="table table-bordered table-striped table-sm" v-if="info.length > 0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Ruang</th>
                            <th>Tanggal</th>
                            <th>Pra Kegiatan</th>
                            <th>Pasca Kegiatan</th>
                            <th>Petugas Pencatat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(a, index) in info" :key="a.id">
                            <td>{{ index + 1 }}</td>
                            <td>{{ a.ruangid }}-{{ a.nama_ruang }} </td>
                            <td>{{ formatDate(a.tgl_kegiatan) }}</td>
                            <td>{{ formatTime(a.pra_mulai) }} - {{ formatTime(a.pra_selesai) }}</td>
                            <td>{{ formatTime(a.pasca_mulai) }} - {{ formatTime(a.pasca_selesai) }} </td>
                            <td>{{ a.nama_pegawai }} </td>
                            <td class="btn-group d-grid gap-2">
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
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal</label>
                                        <input type="date" class="form-control form-control-sm" v-model="newData.tgl_kegiatan" required>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="mb-3">
                                        <label class="form-label">Pra Mulai</label>
                                        <input type="time" class="form-control form-control-sm" v-model="newData.pra_mulai" required>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="mb-3">
                                        <label class="form-label">Pra Selesai</label>
                                        <input type="time" class="form-control form-control-sm" v-model="newData.pra_selesai" required>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="mb-3">
                                        <label class="form-label">Pasca Mulai</label>
                                        <input type="time" class="form-control form-control-sm" v-model="newData.pasca_mulai" required>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="mb-3">
                                        <label class="form-label">Pasca Selesai</label>
                                        <input type="time" class="form-control form-control-sm" v-model="newData.pasca_selesai" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Petugas Pemohon</label>
                                        <auto-suggest v-model="currentData.nama_pegawai" :suggestions="petugas" display-key="nama_pegawai" extra-key="nip_pegawai" @input="debouncedSearchPetugas" @select="selectPetugas"></auto-suggest>
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
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal</label>
                                        <input type="date" class="form-control form-control-sm" v-model="currentData.tgl_kegiatan" required>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label class="form-label">Pra Mulai</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.pra_mulai" required>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label class="form-label">Pra Selesai</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.pra_selesai" required>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label class="form-label">Pasca Mulai</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.pasca_mulai" required>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label class="form-label">Pasca Selesai</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.pasca_selesai" required>
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