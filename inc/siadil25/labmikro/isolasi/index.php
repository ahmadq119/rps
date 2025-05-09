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
                    <th>Tgl Terima</th>
                    <th>Kode / Nama Sample</th>
                    <th>Jumlah</th>
                    <th>Panjang</th>
                    <th>Berat</th>
                    <th>Target Pengujian</th>
                    <th>Acuan</th>
                    <th>Bahan</th>
                    <th>Suhu Inkubasi</th>
                    <th>Hasil Isolasi Awal</th>
                    <th>Sts</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(a, index) in info" :key="a.kd_sample">
                    <td>{{ index + 1 }}</td>
                    <td>{{ a.tgl_terima_dipelayanan ? a.tgl_terima_dipelayanan : '-' }}</td>
                    <td>{{ a.kd_sample }} <br>({{ a.nama_sample }})</td>
                    <td>{{ a.jumlah }} {{ a.satuan }}</td>
                    <td>{{ a.panjang }}</td>
                    <td>{{ a.berat }}</td>
                    <td style="white-space: pre-wrap">{{ a.target_pengujian }}</td>
                    <td style="white-space: pre-wrap">{{ a.acuan }}</td>
                    <td>{{ a.bahan }}</td>
                    <td>{{ a.suhu_inkubasi }}</td>
                    <td>{{ a.hasil_isolasi_awal }}</td>
                    <td>{{ a.sts_terima == 1 ? 'Finish' : 'Ready' }}</td>

                    <td class="btn-group">
                        <input type="button" class="btn btn-warning btn-sm" value="Isolasi Awal" @click="editData(index, a)">
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Modal Edit Data -->
        <div class="modal fade" id="editDataModal" tabindex="-1" role="dialog" aria-labelledby="editDataModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="editDataModalLabel"><span class="fas fa-edit"></span> Input Data Isolasi Awal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="updateData">
                            <div class="row">
                                <div class="col-2">
                                    <div class="mb-3">
                                        <label for="tgl_terima" class="form-label">Tanggal Terima</label>
                                        <input type="date" class="form-control form-control-sm" v-model="currentData.tgl_terima_dipelayanan" required disabled>
                                    </div>
                                </div>
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
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label class="form-label">Metode Isolasi</label>
                                        <select v-model="currentData.idmtd_isolasi" class="form-select form-select-sm">
                                            <option value="" disabled>-- Pilih Metode Isolasi --</option>
                                            <option v-for="mtd in metodeIsolasi"
                                                :key="mtd.idmtd_isolasi"
                                                :value="mtd.idmtd_isolasi">
                                                {{ mtd.metode_isolasi }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label class="form-label">Bahan yang digunakan</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.bahan" required>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="mb-3">
                                        <label class="form-label">Suhu Inkubasi</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.suhu_inkubasi" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label class="form-label">Hasil Isolasi Awal</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.hasil_isolasi_awal" required>
                                    </div>
                                </div>
                                <!--div class="col-4">
                                    <div class="mb-3">
                                        <label for="petugas_preparasi" class="form-label">Petugas Preparasi</label>
                                        <auto-suggest v-model="currentData.p_preparasi" :suggestions="petugasPreparasi" display-key="nama_pegawai" extra-key="nip_pegawai" @input="debouncedSearchPetugasPreparasi" @select="selectPetugasPreparasi"></auto-suggest>
                                    </div>
                                </div-->
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