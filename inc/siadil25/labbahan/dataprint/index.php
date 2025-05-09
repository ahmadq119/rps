<?php require_once "../layout/header.php" ?>

<body>

    <?php include "../menu/menu.php"; ?>

    <div id="app" class="container-fluid mt-5" style="padding-top: 20px;">
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="row">
                    <h2 class="text-primary">Daftar Permintaan Bahan</h2>
                    <hr>
                </div>
                <div class="text-center mb-4">
                    <div class="btn-group">
                        <button class="btn btn-primary" @click="tampil_seluruh_data">Tampilkan Seluruh Data</button>
                        <button class="btn btn-success" @click="tampildata">Refresh</button>
                    </div>

                </div>
                <div class="row justify-content-center mb-4">
                    <div class="col-8">
                        <input type="text" class="form-control" v-model="searchQuery" placeholder="Cari berdasarkan Nama Bahan dan Nama Alat">
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
                            <th>Ruang</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(a, index) in info" :key="a.idbahan">
                            <td>{{ index + 1 }}</td>
                            <td>{{ a.ruangid }}-{{ a.nama_ruang }} </td>
                            <td>{{ formatDate(a.tanggal) }}</td>
                            <td class="btn-group d-grid gap-2">
                                <button class="btn btn-info btn-sm" @click="print(a)">
                                    <i class="fas fa-print"></i> Print
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- Tampilkan pesan jika info.length == 0 -->
                <div v-else class="alert alert-warning text-center">
                    Tidak ada permintaan bahan.
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
                                <div class="col-4" hidden>
                                    <div class="mb-3">
                                        <label for="tanggal" class="form-label">Ruang ID </label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.ruangid" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="bahan" class="form-label">Informasi Bahan yang diminta:</label>
                                        <table class="table table-bordered">
                                            <thead class="bg-warning">
                                                <th>Tanggal</th>
                                                <th>Nama Bahan</th>
                                                <th>Jumlah</th>
                                                <th>Nama Alat</th>
                                                <th>Jumlah</th>
                                                <th>Ruang</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{currentData.tanggal}}</td>
                                                    <td>{{currentData.nama_bahan}}</td>
                                                    <td>{{currentData.jumlah_bahan}}</td>
                                                    <td>{{currentData.nama_alat}}</td>
                                                    <td>{{currentData.jumlah_alat}}</td>
                                                    <td>{{currentData.nama_ruang}}</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="petugas_bahan" class="form-label">Petugas Pemohon</label>
                                        <auto-suggest v-model="currentData.nama_p_bahan" :suggestions="petugasBahan" display-key="nama_pegawai" extra-key="nip_pegawai" @input="debouncedSearchPetugasBahan" @select="selectPetugasBahan"></auto-suggest>
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
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