<?php require_once "../layout/header.php" ?>

<body>

    <?php include "../menu/menu.php"; ?>

    <div id="app" class="container-fluid mt-5" style="padding-top: 20px;">
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="text-center mb-4">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#inputRecordModal">Tampil Data</button>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addDataModal">Tambah Rekaman RH & Temperatur Ruang Pengujian</button>
                </div>
                <div class="text bg-warning mb-4">
                    <ul>
                        <li>
                            Formulir ini digunakan bila metode pengujian mempersyaratkan kondisi ruang pengujian tertentu, atau bila laboratorium mempersyaratkan pemantauan RH/T/lx pada ruang pengujian/instrumentasi.
                        </li>
                        <li>
                            Standart persyaratan <strong>Kelembaban (RH) = 45-65 %</strong> dan <strong>suhu ruang (T) = 20 ±3<sup>0</sup>C</strong>
                        </li>
                        <li>
                            Standar persyaratan <strong>Intensitas cahaya (lx)</strong> pada bilik pengujian organoleptik : <strong>300 - 500 lux</strong>
                        </li>
                        <li>
                            RH = Relative Humidity; T = Temperature; lx = Lux (pencahayaan dan daya pancar cahaya)
                        </li>
                    </ul>
                </div>
                <table class="table table-bordered table-striped table-sm" v-if="info.length > 0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Ruang</th>
                            <th>Tanggal</th>
                            <th>Nilai RH</th>
                            <th>Temperatur (<sup>0</sup>C)</th>
                            <th>Lux (lx)</th>
                            <th>Kesimpulan</th>
                            <th>Petugas Pencatat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(a, index) in info" :key="a.id">
                            <td>{{ index + 1 }}</td>
                            <td>{{ a.ruangid }}-{{ a.nama_ruang }} </td>
                            <td>{{ formatDate(a.tgl_kegiatan) }}</td>
                            <td>{{ a.nil_rh }} </td>
                            <td>{{ a.nil_temp }} </td>
                            <td>{{ a.nil_lx }} </td>
                            <td :class="getKesimpulanClass(a.nil_rh, a.nil_temp, a.nil_lx)">
                                {{ getKesimpulan(a.nil_rh, a.nil_temp, a.nil_lx) }}
                            </td>
                            <td>{{ a.nama_pegawai }} </td>
                            <td class="btn-group d-grid gap-2">
                                <!--input type="button" class="btn btn-danger btn-sm" value="hapus" @click="confirmHapus(index, a.idrec)"-->
                                <input type="button" class="btn btn-default btn-sm" value="ubah" @click="editData(index, a)">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Tambah Data  -->
        <div class="modal fade modal-lg" id="addDataModal" tabindex="-1" role="dialog" aria-labelledby="addDataModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <form @submit.prevent="tambahData">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="addDataModalLabel"><span class="fas fa-plus"></span> Tambah Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col">
                                    <H5 class="text-primary">Standart :</H5>
                                    <ul>
                                        <li>
                                            <strong>Kelembaban (RH) = 45-65 %</strong>
                                        </li>
                                        <li>
                                            <strong>Suhu ruang (T) = 20 ±3<sup>0</sup>C</strong>
                                        </li>
                                        <li>
                                            <strong>Intensitas cahaya (lx)</strong> pada bilik pengujian organoleptik = <strong>300 - 500 lux</strong>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-1" hidden>
                                    <div class="mb-3">
                                        <label class="form-label">Ruang </label>
                                        <input type="text" id="ruangid" class="form-control form-control-sm" v-model="newData.ruangid" required disabled>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal</label>
                                        <input type="date" class="form-control form-control-sm" v-model="newData.tgl_kegiatan" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label">Nilai RH</label>
                                        <input type="text" class="form-control form-control-sm" v-model="newData.nil_rh" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label">Nilai Temperatur (<sup>0</sup>C)</label>
                                        <input type="text" class="form-control form-control-sm" v-model="newData.nil_temp" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label">Nilai Lux (lx)</label>
                                        <input type="text" class="form-control form-control-sm" v-model="newData.nil_lx" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Petugas Pencatat</label>
                                        <auto-suggest v-model="newData.nama_pegawai" :suggestions="petugas" display-key="nama_pegawai" extra-key="nip_pegawai" @input="debouncedSearchPetugas" @select="selectPetugas"></auto-suggest>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-warning" data-bs-dismiss="modal" aria-label="Close">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!--Modal Edit-->
        <div class="modal fade modal-lg" id="editDataModal" tabindex="-1" role="dialog" aria-labelledby="aditDataModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <form @submit.prevent="updateData">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editDataModalLabel"><span class="fas fa-plus"></span> Edit Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col">
                                    <H5 class="text-primary">Standart :</H5>
                                    <ul>
                                        <li>
                                            <strong>Kelembaban (RH) = 45-65 %</strong>
                                        </li>
                                        <li>
                                            <strong>Suhu ruang (T) = 20 ±3<sup>0</sup>C</strong>
                                        </li>
                                        <li>
                                            <strong>Intensitas cahaya (lx)</strong> pada bilik pengujian organoleptik = <strong>300 - 500 lux</strong>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-1" hidden>
                                    <div class="mb-3">
                                        <label class="form-label">Ruang</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.ruangid" required disabled>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal</label>
                                        <input type="date" class="form-control form-control-sm" v-model="currentData.tgl_kegiatan" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label">Nilai RH</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.nil_rh" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label">Nilai Temperatur (<sup>0</sup>C)</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.nil_temp" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label">Nilai Lux (<sup>0</sup>C)</label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.nil_lx" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Petugas Pencatat</label>
                                        <auto-suggest v-model="currentData.nama_pegawai" :suggestions="petugas" display-key="nama_pegawai" extra-key="nip_pegawai" @input="debouncedSearchPetugas" @select="selectPetugasNew"></auto-suggest>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-warning" data-bs-dismiss="modal" aria-label="Close">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--Modal Input Record-->
        <div class="modal fade" id="inputRecordModal" tabindex="-1" role="dialog" aria-labelledby="inputRecordModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="inputRecordModalLabel"><span class="fas fa-plus"></span> Masukan Jumlah Record yang akan dilihat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="tampildata365">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label">Jumlah Record :</label>
                                        <input type="number" class="form-control form-control-sm" v-model="inputNilai">
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <!-- Tombol Simpan dan Batal -->
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal" aria-label="Close">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../../libs/bootstrap.bundle.min.js"></script>
    <script src="../../logout.js"></script>
    <script src="apps.js"></script>
</body>

</html>