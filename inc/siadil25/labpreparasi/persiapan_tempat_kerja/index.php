<?php require_once "../layout/header.php"; ?>

<body>

    <?php include "../menu/menu.php"; ?>

    <div id="app" class="container-fluid mt-5 " style="padding-top: 20px;">
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="text-center mb-4">
                    <button class="btn btn-primary" @click="tampildata">Tampil Data</button>
                </div>
                <div class="row justify-content-center mb-4">
                    <div class="col-6">
                        <input type="text" class="form-control" v-model="searchQuery" placeholder="Cari berdasarkan Customer">
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
                                <th>Kode Sample</th>
                                <th>Nama Sample</th>
                                <th>Tanggal Terima</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(a, index) in info" :key="a.kd_sample">
                                <td>{{ index + 1 }}</td>
                                <td>{{ a.kd_sample }}</td>
                                <td>{{ a.nama_sample }}</td>
                                <td>{{ a.tgl_terima ? a.tgl_terima : '-' }}</td>
                                <td class="btn-group d-grid gap-2">
                                    <!--input type="button" class="btn btn-danger btn-sm" value="hapus" @click="confirmHapus(index, a.idrec)"-->
                                    <input type="button" class="btn btn-default btn-sm" value="Proses Persiapan Tempat Kerja" @click="editData(index, a)">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Edit Data -->
        <div class="modal fade modal-lg" id="editDataModal" tabindex="-1" role="dialog" aria-labelledby="editDataModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="editDataModalLabel"><span class="fas fa-edit"></span> Proses Rekaman Persiapan Tempat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="tambahData">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Kode Sample</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.kd_sample" disabled>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Jenis Sample</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.nama_sample" disabled>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Kegiatan</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.tgl_terima" disabled>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="petugas_preparasi" class="form-label">Petugas Preparasi</label>
                                        <auto-suggest v-model="currentData.nama_pegawai" :suggestions="petugasPreparasi" display-key="nama_pegawai" extra-key="nip_pegawai" @input="debouncedSearchPetugasPreparasi" @select="selectPetugasPreparasi"></auto-suggest>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Kegiatan</label>
                                        <input type="text" class="form-control form-control-sm" v-model="newData.nama_kegiatan" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label>PERSIAPAN TEMPAT KERJA</label><br>
                                        <input type="checkbox" value="1" v-model="newData.s_uv" checked> Penyinaran UV 30 menit<br>
                                        <input type="checkbox" value="1" v-model="newData.s_ol" checked> Desinfeksi Alkohol 70%<br>
                                        <input type="checkbox" value="1" v-model="newData.s_bh" checked> Menyiapkan Bahan<br>
                                        <input type="checkbox" value="1" v-model="newData.s_al" checked> Menyiapkan Alat<br>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label>PENANGANAN SISA KERJA</label><br>
                                        <input type="checkbox" value="1" v-model="newData.p_ss" checked> Memisahkan dan membersihkan sisa kerja<br>
                                        <input type="checkbox" value="1" v-model="newData.p_ol" checked> Desinfeksi Alkohol 70%<br>
                                        <input type="checkbox" value="1" v-model="newData.p_sk" checked> Membuang sisa kerja<br>
                                        <input type="checkbox" value="1" v-model="newData.p_al" checked> Mengembalikan alat dan bahan<br>
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