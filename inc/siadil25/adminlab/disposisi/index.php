<?php require_once "../layout/header.php"; ?>

<body>

    <?php include "../menu/menu.php"; ?>

    <div id="app" class="container-fluid mt-5">
        <div class="text-center mb-4">
            <button class="btn btn-primary" @click="navigateToDaftarSample">Kembali</button>
        </div>
        <table class="table table-bordered table-striped" v-if="info.length > 0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tgl Terima</th>
                    <th>Customer</th>
                    <th>Kode Sample</th>
                    <th>Nama Sample</th>
                    <th>Target Pengujian</th>
                    <th>Metode Pengujian (Acuan)</th>
                    <th>Organ Target Pemeriksaan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(a, index) in info" :key="a.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ a.tgl_terima || '-' }}</td>
                    <td>{{ a.nama_customer || '-' }}</td>
                    <td>{{ a.kd_sample || '-' }}</td>
                    <td>{{ a.nama_sample || '-' }}</td>
                    <td>{{ a.target_pengujian || '-' }}</td>
                    <td>{{ a.metode_pengujian || '-' }}</td>
                    <td>{{ a.organ_target || '-' }}</td>
                    <td class="btn-group">
                        <input type="button" class="btn btn-warning btn-sm" value="Organ Target" @click="isiData(index, a)">
                    </td>
                </tr>
            </tbody>
        </table>


        <!-- Modal Isi Data Organ Target-->
        <div class="modal fade" id="ModalDisposisi" tabindex="-1" role="dialog" aria-labelledby="ModalDisposisiLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
                <div class="modal-content">

                    <form @submit.prevent="updateOrganTarget">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ModalDisposisiLabel"><span class="fas fa-edit"></span> Edit Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <input type="text" v-model="currentData.id" class="form-control" hidden>
                                            <label class="form-label">Kode Sample : </label>
                                            <h5 class="text-primary">{{ currentData.kd_sample }}</h5>
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


                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="">
                                                <label class="form-label">Organ Target:</label>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                        Pilih Organ Target
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li v-for="organ in nilaiOrganTarget" :key="organ.idorg">
                                                            <div class="form-check">
                                                                <input
                                                                    type="checkbox"
                                                                    class="form-check-input"
                                                                    :id="'organ-' + organ.idorg"
                                                                    :value="organ.nama_organ"
                                                                    v-model="selectedTargets">
                                                                <label class="form-check-label" :for="'organ-' + organ.idorg">
                                                                    {{ organ.nama_organ }}
                                                                </label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="">
                                                <!--label class="form-label">Organ yang Dipilih:</label>
                                                <ul>
                                                    <li v-for="targetId in selectedTargets" :key="targetId">
                                                        {{ getTargetName(targetId) }}
                                                    </li>
                                                </ul-->
                                                <label for="selectedTargets" class="form-label">Organ yang Dipilih:</label>
                                                <p>{{ selectedTargets.join(', ') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-default">
                            <div class="col-12 d-flex">
                                <button type="submit" class="btn btn-primary btn-left">Simpan</button>
                            </div>
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