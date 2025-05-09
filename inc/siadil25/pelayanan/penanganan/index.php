<?php require_once "../layout/header.php"; ?>

<body>

    <?php include "../menu/menu.php"; ?>

    <div id="app" class="container-fluid mt-5" style="padding-top: 20px;">
        <!-- Konten Vue.js -->
        <div class="row justify-content-center">
            <div class="col-12">
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
                    <div class="col-md-12 offset-md-2">
                        <div v-if="searchMessage" class="alert alert-warning" role="alert">
                            {{ searchMessage }}
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped table-sm" v-if="info.length > 0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Sampel</th>
                            <th>Jenis Sampel</th>
                            <th>Kemasan</th>
                            <th>Kondisi Kemasan</th>
                            <th>Desinfeksi</th>
                            <th>Pelabelan</th>
                            <th>Perlakuan khusus lainnya</th>
                            <th>Distribusi</th>
                            <th>Masuk Instalasi</th>
                            <th>Petugas Penanganan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(a, index) in info" :key="a.kd_sample">
                            <td>{{ index + 1 }}</td>
                            <td>{{ a.kd_sample }}</td>
                            <td>{{ a.nama_sample }}</td>
                            <td>{{ a.kemasan }}</td>
                            <td>{{ a.kondisi_kemasan }}</td>
                            <td>{{ a.desinfeksi === 1 ? 'Ya' : 'Tidak' }}</td> <!-- Desinfeksi -->
                            <td>{{ a.kodefikasi === 1 ? 'Ya' : 'Tidak' }}</td> <!-- Kodefikasi -->
                            <td>{{ a.lainnya }}</td>
                            <td>{{ a.distribusi === 1 ? 'Ya' : 'Tidak' }}</td> <!-- Distribusi -->
                            <td>{{ a.masuk_instalasi === 1 ? 'Ya' : 'Tidak' }}</td>
                            <td>{{ a.nama_pegawai }}</td>
                            <td>{{ a.sts_eks === 1 ? 'Selesai' : 'Ready' }}</td>
                            <td class="btn-group">
                                <!--input type="button" class="btn btn-warning btn-sm" value="ubah" @click="editData(index, a)"-->
                                <input
                                    type="button"
                                    :class="['btn btn-sm', a.sts_eks === 1 ? 'btn-success' : 'btn-danger']"
                                    value="Proses"
                                    @click="editData(index, a)">

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Edit Data -->
        <div class="modal fade" id="editDataModal" tabindex="-1" role="dialog" aria-labelledby="editDataModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editDataModalLabel"><span class="fas fa-edit"></span> Edit Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="updateData" class="form-horizontal">

                            <div class="row mb-3">
                                <div class="col-3">
                                    <!-- Kode Sampel -->
                                    <label for="kd_sample" class="col-form-label ">Kode Sampel</label>
                                    <input type="text" class="form-control" id="kd_sample" v-model="currentData.kd_sample" required readonly>
                                </div>
                                <div class="col-3">
                                    <!-- Kemasan -->
                                    <label for="kemasan" class="col-form-label ">Kemasan</label>
                                    <input type="text" class="form-control" id="kemasan" v-model="currentData.kemasan" required>
                                </div>
                                <div class="col-3">
                                    <!-- Kondisi Kemasan -->
                                    <label for="kondisi_kemasan" class="col-form-label ">Kondisi Kemasan</label>
                                    <input type="text" class="form-control" id="kondisi_kemasan" v-model="currentData.kondisi_kemasan" required>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-3">
                                    <!-- Desinfeksi -->
                                    <label for="desinfeksi" class="col-form-label ">Desinfeksi : </label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="desinfeksi_ya" value="1" v-model="currentData.desinfeksi" required>
                                        <label class="form-check-label" for="desinfeksi_ya">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="desinfeksi_tidak" value="0" v-model="currentData.desinfeksi" required>
                                        <label class="form-check-label" for="desinfeksi_tidak">Tidak</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <!-- Kodefikasi -->
                                    <label for="kodefikasi" class="col-form-label ">Kodefikasi : </label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="kodefikasi_ya" value="1" v-model="currentData.kodefikasi" required>
                                        <label class="form-check-label" for="kodefikasi_ya">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="kodefikasi_tidak" value="0" v-model="currentData.kodefikasi" required>
                                        <label class="form-check-label" for="kodefikasi_tidak">Tidak</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <!-- Distribusi -->
                                    <label for="distribusi" class="col-form-label ">Distribusi</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="distribusi_ya" value="1" v-model="currentData.distribusi" required>
                                        <label class="form-check-label" for="distribusi_ya">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="distribusi_tidak" value="0" v-model="currentData.distribusi" required>
                                        <label class="form-check-label" for="distribusi_tidak">Tidak</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <!-- Masuk Instalasi -->
                                    <label for="masuk_instalasi" class="col-form-label ">Masuk Instalasi</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="masuk_instalasi_ya" value="1" v-model="currentData.masuk_instalasi" required>
                                        <label class="form-check-label" for="masuk_instalasi_ya">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="masuk_instalasi_tidak" value="0" v-model="currentData.masuk_instalasi" required>
                                        <label class="form-check-label" for="masuk_instalasi_tidak">Tidak</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-3">
                                    <!-- Perlakuan Khusus Lainnya -->
                                    <label for="lainnya" class="col-form-label ">Perlakuan Khusus Lainnya</label>
                                    <input type="text" class="form-control" id="lainnya" v-model="currentData.lainnya">
                                </div>
                                <div class="col-3">
                                    <!-- Petugas Penanganan -->
                                    <label for="idpeg" class="col-form-label ">Petugas Penanganan</label>
                                    <select class="form-control" id="idpeg" v-model="currentData.idpeg" required>
                                        <option v-for="pegawai in pegawaiList" :value="pegawai.idpeg">{{ pegawai.nama_pegawai }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--End Modal-->

    </div>

    <!-- Pindahkan tag script ke sini -->
    <script src="../../libs/popper.min.js"></script>
    <script src="../../libs/bootstrap.bundle.min.js"></script>
    <script src="../../logout.js"></script>
    <script src="apps.js"></script>

</body>

</html>