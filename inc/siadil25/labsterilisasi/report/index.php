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
                        <div class="col">
                            <label for="laporan" class="form-label">Jenis Laporan</label>
                            <select v-model="selectedLaporan" id="laporan" class="form-select form-select-sm">
                                <option v-for="laporan in laporanList" :key="laporan.nilai" :value="laporan.nilai">
                                    {{ laporan.nama }}
                                </option>
                            </select>
                        </div>
                        <!-- Input baru "nama_alat" yang muncul ketika selectedLaporan bernilai 2 -->
                        <div class="col" v-if="selectedLaporan === 2">
                            <div class="mb-3">
                                <label for="alat" class="form-label">Nama Alat</label>
                                <select v-model="newData.alat" id="alat" class="form-select form-select-sm">
                                    <option value="" disabled>Pilih Nama Alat</option>
                                    <option v-for="alat in dataAlat" :value="alat.nama_alat">{{ alat.nama_alat }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <label for="bulan" class="form-label">Bulan</label>
                            <select v-model="selectedBulan" id="bulan" class="form-select form-select-sm">
                                <option v-for="bulan in bulanList" :key="bulan.nilai" :value="bulan.nilai">
                                    {{ bulan.nama }}
                                </option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="tahun" class="form-label">Tahun</label>
                            <select v-model="newData.tahun" id="tahun" class="form-select form-select-sm">
                                <option value="" disabled>Pilih Tahun</option>
                                <option v-for="tahun in dataTahun" :value="tahun">{{ tahun }}</option>
                            </select>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Manajer Teknis</label>
                                <auto-suggest v-model="newData.nama_pegawai" :suggestions="manajerTeknis" display-key="nama_pegawai" extra-key="nip_pegawai" @input="debouncedSearchPetugas" @select="selectPetugas"></auto-suggest>
                            </div>
                        </div>
                        <div class="col">
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