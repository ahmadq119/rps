<?php require_once "../layout/header.php"; ?>

<body>

    <?php include "../menu/menu.php"; ?>

    <div id="app" class="container-fluid mt-5">
        <div class="text-center mb-4">
            <button class="btn btn-primary" @click="tampildata">Tampil Data</button>
        </div>
        <div class="row justify-content-center mb-4">
            <div class="col-6">
                <input type="text" class="form-control" v-model="searchQuery" placeholder="Cari berdasarkan Kode Sample dan Customer">
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
                    <th>Customer</th>
                    <th>No. Reg / No. LHU</th>
                    <th>Kode Sample</th>
                    <th>Nama Sample</th>
                    <th>Target Pengujian</th>
                    <th>Organ Target</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(a, index) in info" :key="a.kd_sample">
                    <td>{{ index + 1 }}</td>
                    <td>{{ formatDate(a.tgl_terima) }}</td>
                    <td>{{ a.nama_customer }}</td>
                    <td>{{ a.no_reg }}</td>
                    <td>{{ a.kd_sample }}</td>
                    <td>{{ a.nama_sample }}</td>
                    <td>{{ a.target_pengujian }}</td>
                    <td>{{ a.organ_target }}</td>
                    <td class="btn-group">
                        <!--input type="button" class="btn btn-warning btn-sm" value="Disposisi" @click="navigateToDisposisi(a.kd_sample)"-->
                        <!--button class="btn btn-warning btn-sm" @click="navigateToLhp(a.kd_sample)">
                            <i class="fas fa-edit"></i> Input LHP
                        </button-->
                        <button class="btn btn-info btn-sm" @click="printLhu(a)">
                            <i class="fas fa-print"></i> Print
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>

    <!-- Sertakan jQuery dari CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="../../libs/popper.min.js"></script>
    <script src="../../libs/bootstrap.bundle.min.js"></script>
    <script src="../../logout.js"></script>
    <script src="apps.js"></script>
</body>

</html>