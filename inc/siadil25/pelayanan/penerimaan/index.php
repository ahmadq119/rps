<?php require_once "../layout/header.php"; ?>

<body>

    <?php include "../menu/menu.php"; ?>

    <div id="app" class="container-fluid mt-5">
        <div class="text-center mb-4">
            <button class="btn btn-primary" @click="tampildata">Tampil Data</button>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addDataModal">Tambah Data</button>
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
        <div class="table-responsive-md">
            <table class="table table-bordered table-striped" v-if="info.length > 0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tgl Terima</th>
                        <th>Customer & Alamat</th>
                        <th>No. Reg</th>
                        <th>Kode Sample</th>
                        <th>Nama Sample</th>
                        <th>Jumlah</th>
                        <th>Asal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(a, index) in info" :key="a.kd_sample">
                        <td>{{ index + 1 }}</td>
                        <td>{{ formatDate(a.tgl_terima) }}</td>
                        <td>{{ a.nama_customer }} <br>{{ a.alamat_customer }}<br><span class="badge rounded-pill bg-info">{{ a.asal_sampel }}</span><span class="badge rounded-pill bg-secondary">{{ a.ket_golongan }}</span></td>
                        <td>{{ a.no_reg }}</td>
                        <td>{{ a.kd_sample }}</td>
                        <td>{{ a.nama_sample }}</td>
                        <td>{{ a.jumlah }} {{ a.satuan }}</td>
                        <td>{{ a.asal_sample }}</td>
                        <td class="btn-group">
                            <input type="button" class="btn btn-warning btn-sm" value="ubah" @click="editData(index, a)">
                            <input type="button" class="btn btn-info btn-sm" value="kajiulang" @click="printKajiUlang(a)">
                            <input type="button" class="btn btn-primary btn-sm" value="bap" @click="printBap(a)">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal Tambah Data -->
        <div class="modal fade" id="addDataModal" tabindex="-1" role="dialog" aria-labelledby="addDataModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen" role="document">
                <div class="modal-content">

                    <div class="modal-header bg-primary text-light">
                        <h5 class="modal-title" id="addDataModalLabel"><span class="fas fa-plus"></span> Input Data Sample</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="tambahData">
                            <div class="row">
                                <div class="col-2" hidden>
                                    <div class="mb-3">
                                        <label for="nomor" class="form-label">Nomor</label>
                                        <input type="text" class="form-control form-control-sm" v-model="newData.nomor" required readonly>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="mb-3">
                                        <label for="tgl_terima" class="form-label">Tanggal Terima</label>
                                        <input type="date" class="form-control form-control-sm" v-model="newData.tgl_terima" required>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="mb-3">
                                        <label for="kd_sample" class="form-label">Kode Sample</label>
                                        <input type="text" class="form-control form-control-sm" v-model="newData.kd_sample" required readonly>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="mb-3">
                                        <label for="no_reg" class="form-label">No. Registrasi</label>
                                        <input type="text" class="form-control form-control-sm" v-model="newData.no_reg" required readonly>
                                    </div>
                                </div>
                                <div class="col" hidden>
                                    <div class="mb-3">
                                        <label class="form-label">No. BAP</label>
                                        <input type="text" class="form-control form-control-sm" v-model="newData.no_bap" required readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="nama_customer" class="form-label">Nama Customer</label>
                                        <auto-suggest v-model="newData.nama_customer" :suggestions="customers" display-key="nama_customer" extra-key="alamat_customer" @input="debouncedSearch" @select="selectCustomer"></auto-suggest>
                                    </div>
                                </div>
                                <div class="col" hidden>
                                    <div class="mb-3">
                                        <label for="alamat_customer" class="form-label">Alamat</label>
                                        <input type="text" class="form-control form-control-sm" v-model="newData.alamat_customer" required readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <div class="mb-3">
                                        <label for="tgl_uji" class="form-label">Tanggal Pengujian</label>
                                        <input type="date" class="form-control form-control-sm" v-model="newData.tgl_uji" required>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label for="nama_sample" class="form-label">Jenis Sample</label>
                                        <auto-suggest v-model="newData.nama_sample" :suggestions="namaSample" display-key="nama_sample" extra-key="satuan" @input="debouncedSearchSample" @select="selectSample"></auto-suggest>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <div class="mb-3">
                                        <label for="jumlah" class="form-label">Jumlah</label>
                                        <input type="number" class="form-control form-control-sm" v-model="newData.jumlah" required>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <div class="mb-3">
                                        <label for="satuan" class="form-label">Satuan</label>
                                        <input type="text" class="form-control form-control-sm" v-model="newData.satuan" required readonly>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="mb-3">
                                        <label class="form-label">Kondisi Sample</label>
                                        <select v-model="newData.idkondisi" class="form-select form-select-sm">
                                            <option value="">-- Pilih Kondisi Sample --</option>
                                            <option v-for="kondisi in kondisiSample"
                                                :key="kondisi.idkondisi"
                                                :value="kondisi.idkondisi">
                                                {{ kondisi.kondisi_sample }}
                                            </option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label for="asal" class="form-label">Asal Sample</label>
                                        <select v-model="newData.idasal" class="form-select form-select-sm">
                                            <option value="">-- Pilih Asal Sample --</option>
                                            <option v-for="asal in asalSample"
                                                :key="asal.idasal"
                                                :value="asal.idasal">
                                                {{ asal.asal_sample }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Target Pengujian:</label>

                                                <!-- Checkbox untuk target pengujian -->
                                                <div v-for="target in nilaiTargetPengujian" :key="target.idtarget">
                                                    <input type="checkbox"
                                                        :value="target.idtarget"
                                                        v-model="selectedTargets">
                                                    {{ target.target_pengujian }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Target yang Dipilih:</label>
                                                <ul>
                                                    <li v-for="targetId in selectedTargets" :key="targetId">
                                                        {{ getTargetName(targetId) }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="petugas_pelayanan" class="form-label">Petugas Pelayanan</label>
                                        <auto-suggest v-model="newData.petugas_pelayanan" :suggestions="petugasPelayanan" display-key="nama_pegawai" extra-key="nip_pegawai" @input="debouncedSearchPetugasPelayanan" @select="selectPetugasPelayanan"></auto-suggest>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="petugas_pengambil_sample" class="form-label">Petugas Pengambil Sample</label>
                                        <auto-suggest v-model="newData.petugas_pengambil_sample" :suggestions="petugasPengambilSample" display-key="nama_pegawai" extra-key="nip_pegawai" @input="debouncedSearchPetugasPengambilSample" @select="selectPetugasPengambilSample"></auto-suggest>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="manajerTeknis" class="form-label">Manajer Teknis</label>
                                        <auto-suggest v-model="newData.manajerTeknis" :suggestions="manajerTeknis" display-key="nama_pegawai" extra-key="nip_pegawai" @input="debouncedSearchmanajerTeknis" @select="selectManajerTeknis"></auto-suggest>
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
                    <div class="modal-footer bg-primary text-light">
                        Pastikan formulir telah diisi lengkap.
                    </div>

                </div>
            </div>
        </div>

        <!-- Modal Edit Data -->
        <div class="modal fade" id="editDataModal" tabindex="-1" role="dialog" aria-labelledby="editDataModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen" role="document">
                <div class="modal-content">

                    <div class="modal-header bg-primary text-light">
                        <h5 class="modal-title" id="editDataModalLabel"><span class="fas fa-edit"></span> Edit Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="updateData">
                            <div class="row">
                                <div class="col-2" hidden>
                                    <div class="mb-3">
                                        <label for="nomor" class="form-label">Nomor</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.nomor" required readonly>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="mb-3">
                                        <label for="tgl_terima" class="form-label">Tanggal Terima</label>
                                        <input type="date" class="form-control form-control-sm" v-model="currentData.tgl_terima" required>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="mb-3">
                                        <label for="kd_sample" class="form-label">Kode Sample</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.kd_sample" required>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="mb-3">
                                        <label for="no_reg" class="form-label">No. Registrasi</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.no_reg" required readonly>
                                    </div>
                                </div>
                                <div class="col" hidden>
                                    <div class="mb-3">
                                        <label for="no_bap" class="form-label">No. BAP</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.no_bap" required readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="nama_customer" class="form-label">Nama Customer</label>
                                        <auto-suggest v-model="currentData.nama_customer" :suggestions="customers" display-key="nama_customer" extra-key="alamat_customer" @input="debouncedSearch" @select="selectCustomer2"></auto-suggest>
                                    </div>
                                </div>
                                <div class="col-6" hidden>
                                    <div class="mb-3">
                                        <label for="alamat_customer" class="form-label">Alamat</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.alamat_customer" required readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <div class="mb-3">
                                        <label for="tgl_uji" class="form-label">Tanggal Pengujian</label>
                                        <input type="date" class="form-control form-control-sm" v-model="currentData.tgl_uji" required>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label for="nm_sample" class="form-label">Nama Sample</label>
                                        <auto-suggest v-model="currentData.nama_sample" :suggestions="namaSample" display-key="nama_sample" extra-key="satuan" @input="debouncedSearchSample" @select="selectSample2"></auto-suggest>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <div class="mb-3">
                                        <label for="jumlah" class="form-label">Jumlah</label>
                                        <input type="number" class="form-control form-control-sm" v-model="currentData.jumlah" required>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <div class="mb-3">
                                        <label for="satuan" class="form-label">Satuan</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.satuan" required readonly>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="mb-3">
                                        <label for="kondisi" class="form-label">Kondisi</label>
                                        <select v-model="currentData.idkondisi" class="form-select form-select-sm">
                                            <option value="">-- Pilih Kondisi Sample --</option>
                                            <option v-for="kondisi in kondisiSample"
                                                :key="kondisi.idkondisi"
                                                :value="kondisi.idkondisi">
                                                {{ kondisi.kondisi_sample }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="mb-3">
                                        <label for="asal" class="form-label">Asal Sample</label>
                                        <select v-model="currentData.idasal" class="form-select form-select-sm">
                                            <option value="">-- Pilih Asal Sample --</option>
                                            <option v-for="asal in asalSample"
                                                :key="asal.idasal"
                                                :value="asal.idasal">
                                                {{ asal.asal_sample }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Target Pengujian:</label>

                                                <!-- Checkbox untuk target pengujian -->
                                                <div v-for="target in nilaiTargetPengujian" :key="target.idtarget">
                                                    <input type="checkbox"
                                                        :value="target.idtarget"
                                                        v-model="selectedTargets">
                                                    {{ target.target_pengujian }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Target yang Dipilih:</label>
                                                <ul>
                                                    <li v-for="targetId in selectedTargets" :key="targetId">
                                                        {{ getTargetName(targetId) }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="petugas_pelayanan" class="form-label">Petugas Pelayanan</label>
                                        <auto-suggest v-model="currentData.p_pelayanan" :suggestions="petugasPelayanan" display-key="nama_pegawai" extra-key="nip_pegawai" @input="debouncedSearchPetugasPelayanan" @select="selectPetugasPelayanan2"></auto-suggest>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="petugas_pengambil_sample" class="form-label">Petugas Pengambil Sample</label>
                                        <auto-suggest v-model="currentData.p_sample" :suggestions="petugasPengambilSample" display-key="nama_pegawai" extra-key="nip_pegawai" @input="debouncedSearchPetugasPengambilSample" @select="selectPetugasPengambilSample2"></auto-suggest>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="manajerTeknis" class="form-label">Manajer Teknis</label>
                                        <auto-suggest v-model="currentData.mt" :suggestions="manajerTeknis" display-key="nama_pegawai" extra-key="nip_pegawai" @input="debouncedSearchmanajerTeknis" @select="selectManajerTeknis2"></auto-suggest>
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