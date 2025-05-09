<?php require_once "../layout/header.php"; ?>

<body>

    <?php include "../menu/menu.php"; ?>

    <div id="app" class="container-fluid mt-5">
        <div class="text-center mb-4">
            <button class="btn btn-primary" @click="navigateToLHUS">Kembali</button>
        </div>
        <table class="table table-bordered table-striped" v-if="info.length > 0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tgl Terima</th>
                    <th>Tgl LHU</th>
                    <th>Kode Sample</th>
                    <th>Target Pengujian</th>
                    <th>Metode Acuan (Ref)</th>
                    <th>Bidang Pengujian (LHU)</th>
                    <th>Parameter</th>
                    <th>Hasil</th>
                    <th>Persyaratan Mutu</th>
                    <th>Kepala Laboratorium / MT</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(a, index) in info" :key="a.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ a.tgl_terima || '-' }}</td>
                    <td>{{ a.tgl_lhu || '-' }}</td>
                    <td>{{ a.kd_sample || '-' }}<br>
                        <ul>
                            <li>{{ a.nama_sample || '-' }}</li>
                            <li>{{ a.nama_customer || '-' }}</li>
                        </ul>
                    </td>
                    <td>{{ a.target_pengujian || '-' }}</td>
                    <td>{{ a.metode_pengujian || '-' }}</td>
                    <td>{{ a.bidang_pengujian || '-' }}</td>
                    <td>{{ a.parameter || '-' }}</td>
                    <td v-html="a.hasil || '-'"></td>
                    <td v-html="a.persyaratan_mutu || '-'"></td>
                    <td>{{ a.nama_pegawai || '-' }}</td>
                    <td class="btn-group">
                        <input type="button" class="btn btn-warning btn-sm" value="Hasil Pengujian" @click="isiData(index, a)">
                    </td>
                </tr>
            </tbody>
        </table>


        <!-- Modal Isi Data Hasil Pengujian-->
        <div class="modal fade" id="ModalLhp" tabindex="-1" role="dialog" aria-labelledby="ModalLhpLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-fullscreen-xxl-down" role="document">
                <div class="modal-content">

                    <form @submit.prevent="updateData">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ModalLhpLabel"><span class="fas fa-edit"></span> Input Hasil Pengujian</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <label class="label label-primary">Kode Sample</label>
                                            <input type="text" v-model="currentData.kd_sample" class="form-control form-control-sm" disabled>
                                            <label class="form-label">
                                                Tanggal Terima : {{ currentData.tgl_terima }},
                                                Tanggal Uji : {{ currentData.tgl_uji }},
                                                Customer : {{ currentData.nama_customer }},
                                                No. Reg : {{ currentData.no_reg }},
                                                Jenis Sample : {{ currentData.nama_sample }}, {{ currentData.jumlah }} {{ currentData.satuan }}, {{ currentData.kondisi_sample }}
                                            </label>
                                            <label class="form-label">Target Pengujian : </label>
                                            <h5 class="text-primary">{{ currentData.target_pengujian }}</h5>
                                            <label class="form-label">Metode Pengujian : </label>
                                            <h5 class="text-primary">{{ currentData.metode_pengujian }}</h5>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Parameter</label>
                                                    <input type="text" class="form-control form-control-sm" v-model="currentData.parameter" required>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Tanggal LHU</label>
                                                    <input type="date" class="form-control form-control-sm" v-model="currentData.tgl_lhu" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Hasil Pengujian</label>
                                                    <textarea id="editor1" name='hasil' v-model="currentData.hasil" class="form-control"></textarea>
                                                </div>
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Persyaratan Mutu</label>
                                                        <textarea id="editor2" name='persyaratan_mutu' v-model="currentData.persyaratan_mutu" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Metode Acuan</label>
                                                    <input type="text" name="metode_acuan" class="form-control form-control-sm" v-model="currentData.metode_acuan" required>
                                                    <label class="badge bg-primary">Copy dari Metode Pengujian</label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Keterangan</label>
                                                    <textarea id="editor3" name='keterangan' v-model="currentData.keterangan" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Manajer Teknis</label>
                                                    <auto-suggest v-model="currentData.nama_pegawai" :suggestions="manajerTeknis" display-key="nama_pegawai" extra-key="nip_pegawai" @input="debouncedSearchManajerTeknis" @select="selectManajerTeknis"></auto-suggest>
                                                </div>
                                            </div>



                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-right">Simpan</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                    </form>

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