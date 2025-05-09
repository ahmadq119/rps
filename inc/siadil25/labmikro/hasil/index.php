<?php require_once "../layout/header.php" ?>

<body>

    <?php include "../menu/menu.php"; ?>

    <div id="app" class="container-fluid mt-5">
        <div class="text-center mb-4">
            <button class="btn btn-primary" @click="tampildata">Tampil Data</button>
            <!--button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addDataModal">Tambah Data</button-->
        </div>
        <div class="row justify-content-center mb-4">
            <div class="col-6">
                <input type="text" class="form-control" v-model="searchQuery" placeholder="Cari berdasarkan Kode Sample">
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
                    <th>Kode Sample</th>
                    <th>Tgl Terima</th>
                    <th>Tgl Hasil</th>
                    <th>Target Pengujian</th>
                    <th>Hasil Isolasi Awal</th>
                    <th>Metode Pengujian</th>
                    <th>Bakteri Teridentifikasi</th>
                    <th>Analis</th>
                    <th>Penyelia</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(a, index) in info" :key="a.kd_sample">
                    <td>{{ index + 1 }}</td>
                    <td>{{ a.kd_sample }}</td>
                    <td>{{ a.tgl_terima ? a.tgl_terima : '-' }}</td>
                    <td>{{ a.tgl_hasil ? a.tgl_hasil : '-' }}</td>
                    <td style="white-space: pre-wrap">{{ a.target_pengujian }}</td>
                    <td>{{ a.hasil_isolasi_awal }}</td>
                    <td>{{ a.metode_pengujian }}</td>
                    <td>{{ a.nama_bakteri_ditemukan }}</td>
                    <td>{{ a.analis }}</td>
                    <td>{{ a.penyelia }}</td>
                    <td class="btn-group">
                        <input type="button" class="btn btn-warning btn-sm" value="Edit Hasil" @click="editData(index, a)">
                        <input type="button" class="btn btn-primary btn-sm" value="Form LHP" @click="printLhp(a)">
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Modal Edit Data -->
        <div class="modal fade" id="editDataModal" tabindex="-1" role="dialog" aria-labelledby="editDataModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="editDataModalLabel"><span class="fas fa-edit"></span> Input Hasil Pengujian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="updateData">
                            <div class="row">
                                <div class="col-2">
                                    <div class="mb-3">
                                        <label for="tgl_terima" class="form-label">Tanggal Uji</label>
                                        <input type="date" class="form-control form-control-sm" v-model="currentData.tgl_harus_uji" required disabled>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="mb-3">
                                        <label for="kd_sample" class="form-label">Kode Sample</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.kd_sample" disabled>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="nm_sample" class="form-label">Nama Sample</label>
                                        <input type="text" v-model="currentData.nama_sample" class="form-control form-control-sm" disabled>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label class="form-label">Hasil Isolasi Awal</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.hasil_isolasi_awal" disabled required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Hasil</label>
                                        <input type="date" class="form-control form-control-sm" v-model="currentData.draft_tgl_hasil" required>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Bakteri yang ditemukan:</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.nama_bakteri_ditemukan" required>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label class="form-label">Metode Pengujian</label>
                                        <select v-model="currentData.metode_pengujian" class="form-select form-select-sm">
                                            <option value="" disabled>-- Pilih Metode Pengujian --</option>
                                            <option value="Mikroskopis">Mikroskopis</option>
                                            <option value="Konvensional">Konvensional</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label class="form-label">Analis</label>
                                        <auto-suggest v-model="currentData.analis" :suggestions="petugasAnalis" display-key="nama_pegawai" extra-key="nip_pegawai" @input="debouncedSearchAnalis" @select="selectAnalis"></auto-suggest>
                                    </div>

                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label class="form-label">Penyelia</label>
                                        <auto-suggest v-model="currentData.penyelia" :suggestions="petugasPenyelia" display-key="nama_pegawai" extra-key="nip_pegawai" @input="debouncedSearchPenyelia" @select="selectPenyelia"></auto-suggest>
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
                    <!--div class="modal-footer">
                        Pastikan formulir telah diisi lengkap.
                    </div-->

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