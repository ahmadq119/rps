<?php require_once "../layout/header.php" ?>

<body>

    <?php include "../menu/menu.php"; ?>

    <div id="app">
        <div class="container mt-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Form Pilihan Laporan</h5>
                </div>
                <div class="card-body">
                    <form class="row justify-content-center">
                        <div class="col-3">
                            <label for="laporan" class="form-label">Jenis Laporan</label>
                            <select v-model="newData.laporan" id="laporan" class="form-select form-select-sm">
                                <option value="" disabled>Pilih Jenis Laporan</option>
                                <option value="1"><i class="fas fa-virus"></i> Rekapitulasi Pemeriksaan Pengujian</option>
                                <option value="2"><i class="fas fa-print"></i> Rekap Persiapan Tempat Kerja</option>
                                <option value="3"><i class="fas fa-print"></i> Rekaman Ruang Pengujian (RH & Temp)</option>
                                <option value="4"><i class="fas fa-print"></i> Rekaman UV Ruang Pengujian</option>
                                <option value="5" disabled><i class="fas fa-print"></i> Rekaman Pengelolaan Sampel Pra Pengujian</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <label for="bulan" class="form-label">Bulan</label>
                            <select v-model="newData.bulan" id="bulan" class="form-select form-select-sm">
                                <option value="" disabled>Pilih Bulan</option>
                                <option v-for="bulan in dataBulan" :value="bulan.value">{{ bulan.name }}</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <label for="tahun" class="form-label">Tahun</label>
                            <select v-model="newData.tahun" id="tahun" class="form-select form-select-sm">
                                <option value="" disabled>Pilih Tahun</option>
                                <option v-for="tahun in dataTahun" :value="tahun">{{ tahun }}</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <div class="mb-3">
                                <label class="form-label">Manajer Teknis</label>
                                <auto-suggest v-model="newData.nama_pegawai" :suggestions="manajerTeknis" display-key="nama_pegawai" extra-key="nip_pegawai" @input="debouncedSearchPetugas" @select="selectPetugas"></auto-suggest>
                            </div>
                        </div>
                        <div class="col-2">
                            <label class="form-label">Aksi</label>
                            <button type="button" class="btn btn-primary btn-sm form-control" @click="printData">Cetak PDF</button>
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