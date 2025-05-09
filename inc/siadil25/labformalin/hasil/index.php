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
                    <th>Metode Pengujian</th>
                    <th>Hasil Pengujian</th>
                    <th>Analis</th>
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
                    <td>{{ a.metode_pengujian }}</td>
                    <td>{{ a.hasil_pengujian }}</td>
                    <td>{{ a.nama_pegawai }}</td>
                    <td class="btn-group">
                        <input type="button" class="btn btn-warning btn-sm" value="Edit Hasil" @click="editData(index, a)">
                        <input type="button" class="btn btn-danger btn-sm" value="Upload Foto" @click="uploadFoto(index, a)">
                        <input type="button" class="btn btn-primary btn-sm" value="Form LHP" @click="printLhp(a)">
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Modal Edit Data -->
        <div class="modal fade" id="editDataModal" tabindex="-1" role="dialog" aria-labelledby="editDataModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
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
                                        <input type="date" class="form-control form-control-sm" v-model="currentData.tgl_uji" required disabled>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label for="kd_sample" class="form-label">Kode Sample</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.kd_sample" disabled>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="nm_sample" class="form-label">Nama Sample</label>
                                        <input type="text" v-model="currentData.nama_sample" class="form-control form-control-sm" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Hasil</label>
                                        <input type="date" class="form-control form-control-sm" v-model="currentData.tgl_uji" required>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label class="form-label">Hasil Pengujian</label>
                                        <select v-model="currentData.hasil_pengujian" class="form-select form-select-sm">
                                            <option value="" disabled>-- Pilih Hasil Pengujian --</option>
                                            <option value="Negatif (-) Formalin">Negatif (-) Formalin</option>
                                            <option value="Positif (+) Formalin">Positif (+) Formalin</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label">Analis</label>
                                        <auto-suggest v-model="currentData.analis" :suggestions="petugasAnalis" display-key="nama_pegawai" extra-key="nip_pegawai" @input="debouncedSearchAnalis" @select="selectAnalis"></auto-suggest>
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

        <!-- Modal Upload -->
        <div class="modal fade" id="editDataModalUpload" tabindex="-1" role="dialog" aria-labelledby="editDataModalUploadLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="editDataModalUploadLabel"><span class="fas fa-upload"></span> Upload Foto Hasil Pengujian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form @submit.prevent="updateFileUpload" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="keterangan" class="form-label"><strong>Keterangan</strong></label>
                                        <textarea id="keterangan" name='ket_file' v-model="newData.ket_file" class="form-control" rows="4"></textarea>
                                        <p class="text-muted">Preview: {{ currentData.ket_file }}</p> <!-- Debugging -->
                                    </div>
                                    <div class="mb-3">
                                        <label for="uploadFoto" class="form-label"><strong>Upload Foto Hasil Pengujian</strong></label>
                                        <input type="file" class="form-control form-control-sm" id="uploadFoto" accept="image/*" @change="handleFileUpload">
                                        <small class="text-muted">Uk. File Upload max = 5 MB</small>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            <strong>LAMPIRAN</strong>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama File</th>
                                                        <th>Preview</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(file, index) in info" :key="index">
                                                        <td>{{ index + 1 }}</td>
                                                        <td>{{ file.nama_file }}</td>
                                                        <td><img :src="'../../file_labformalin/' + file.nama_file" class="img-thumbnail" width="100" v-if="file.nama_file"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                                <button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal">Kembali</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--End Modal Upload-->


    </div>

    <!-- Sertakan jQuery dari CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="../../libs/popper.min.js"></script>
    <script src="../../libs/bootstrap.bundle.min.js"></script>
    <script src="../../logout.js"></script>
    <script src="apps.js"></script>
</body>

</html>