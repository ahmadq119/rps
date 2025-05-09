<?php require_once "../layout/header.php"; ?>

<body>

    <?php include "../menu/menu.php"; ?>

    <div id="app" class="container-fluid mt-5">
        <div class="text-center mb-4">
            <button class="btn btn-primary" @click="tampildata">Tampil Data</button>
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
                    <th>Kode Sample</th>
                    <th>Nama Sample</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Organ Target : Target Uji</th>
                    <th>Panjang</th>
                    <th>Berat</th>
                    <th>Petugas Nekropsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(a, index) in info" :key="a.kd_sample">
                    <td>{{ index + 1 }}</td>
                    <td>{{ a.tgl_terima ? a.tgl_terima : '-' }}</td>
                    <td>{{ a.kd_sample }}</td>
                    <td>{{ a.nama_sample }}</td>
                    <td>{{ a.jumlah }}</td>
                    <td>{{ a.satuan }}</td>
                    <td style="white-space: pre-wrap">{{ a.pengujian_tergabung }}</td>
                    <td>{{ a.panjang }}</td>
                    <td>{{ a.berat }}</td>
                    <td>{{ a.nama_pegawai }}</td>
                    <td class="btn-group">
                        <input type="button" class="btn btn-warning btn-sm" value="Panjang Berat" @click="editData(index, a)">
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Modal Edit Data -->
        <div class="modal fade" id="editDataModal" tabindex="-1" role="dialog" aria-labelledby="editDataModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="editDataModalLabel"><span class="fas fa-edit"></span> Edit Data Panjang dan Berat Sample</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="updateData">
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
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.kd_sample" disabled>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label for="nm_sample" class="form-label">Nama Sample</label>
                                        <input type="text" v-model="currentData.nama_sample" class="form-control form-control-sm" disabled>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <div class="mb-3">
                                        <label for="jumlah" class="form-label">Jumlah</label>
                                        <input type="number" class="form-control form-control-sm" v-model="currentData.jumlah" disabled>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <div class="mb-3">
                                        <label for="satuan" class="form-label">Satuan</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.satuan" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="panjang" class="form-label">Panjang</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.panjang" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="berat" class="form-label">Berat</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.berat" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="petugas_preparasi" class="form-label">Petugas Preparasi</label>
                                        <auto-suggest v-model="currentData.p_preparasi" :suggestions="petugasPreparasi" display-key="nama_pegawai" extra-key="nip_pegawai" @input="debouncedSearchPetugasPreparasi" @select="selectPetugasPreparasi"></auto-suggest>
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