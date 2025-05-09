<?php require_once "../layout/header.php"; ?>

<body>

    <?php include "../menu/menu.php"; ?>

    <div id="app" class="container-fluid mt-5" style="padding-top: 20px;">
        <div class="row justify-content-center">
            <div class="col-10">


                <div class="text-center mb-4">
                    <button class="btn btn-primary" @click="tampildata">Tampil Data</button>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addDataModal">Form Permintaan Bahan</button>
                </div>
                <div class="row justify-content-center mb-4">
                    <div class="col-8">
                        <input type="text" class="form-control" v-model="searchQuery" placeholder="Cari berdasarkan Nama Bahan dan Nama Alat">
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
                <table class="table table-bordered table-striped table-sm" v-if="info.length > 0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Ruang</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Nama Bahan</th>
                            <th>Jumlah Bahan</th>
                            <th>Nama Alat</th>
                            <th>Jumlah Alat</th>
                            <th>Petugas Pemohon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(a, index) in info" :key="a.idbahan">
                            <td>{{ index + 1 }}</td>
                            <td>{{ a.ruangid }}-{{ a.nama_ruang }} </td>
                            <td>{{ formatDate(a.tanggal) }}</td>
                            <td>{{ a.waktu }} </td>
                            <td>{{ a.nama_bahan }} </td>
                            <td>{{ a.jumlah_bahan }} </td>
                            <td>{{ a.nama_alat }} </td>
                            <td>{{ a.jumlah_alat }} </td>
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

        <!-- Modal Tambah Data Permintaan Bahan -->
        <div class="modal fade modal-lg" id="addDataModal" tabindex="-1" role="dialog" aria-labelledby="addDataModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="addDataModalLabel"><span class="fas fa-plus"></span> Tambah Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="tambahData">
                            <div class="row">
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="tanggal" class="form-label">Ruang ID </label>
                                        <input type="text" id="ruangid" class="form-control form-control-sm" v-model="newData.ruangid" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="tanggal" class="form-label">Tanggal</label>
                                        <input type="date" id="tanggal" name="tanggal" class="form-control form-control-sm" v-model="newData.tanggal" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="waktu" class="form-label">Waktu</label>
                                        <input type="time" id="waktu" name="waktu" class="form-control form-control-sm" v-model="newData.waktu" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="petugas_bahan" class="form-label">Petugas Pemohon</label>
                                        <auto-suggest v-model="currentData.nama_pegawai" :suggestions="petugasBahan" display-key="nama_pegawai" extra-key="nip_pegawai" @input="debouncedSearchPetugasBahan" @select="selectPetugasBahan"></auto-suggest>
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <!-- Tabel Input Data -->
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Bahan</th>
                                            <th>Jumlah Bahan</th>
                                            <th>Nama Alat</th>
                                            <th>Jumlah Alat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in items" :key="index">
                                            <td>{{ index + 1 }}</td> <!-- Menampilkan nomor urut -->
                                            <td><input type="text" class="form-control" v-model="item.namaBahan" placeholder="Nama Bahan" required></td>
                                            <td><input type="text" class="form-control" v-model="item.jumlahBahan" placeholder="Jumlah Bahan" required></td>
                                            <td><input type="text" class="form-control" v-model="item.namaAlat" placeholder="Nama Alat" required></td>
                                            <td><input type="text" class="form-control" v-model="item.jumlahAlat" placeholder="Jumlah Alat" required></td>
                                            <td><button type="button" class="btn btn-danger" @click="removeItem(index)">Hapus</button></td>
                                        </tr>

                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-success" @click="addItem">+ Add</button>

                                <!-- Tombol Simpan dan Batal -->
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="reset" class="btn btn-warning" @click="resetForm">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--Modal Edit-->
        <div class="modal fade modal-lg" id="editDataModal" tabindex="-1" role="dialog" aria-labelledby="aditDataModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="editDataModalLabel"><span class="fas fa-plus"></span> Edit Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="updateData">
                            <div class="row">
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="tanggal" class="form-label">Ruang ID </label>
                                        <input type="text" class="form-control form-control-sm" v-model="currentData.ruangid" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="tanggal" class="form-label">Tanggal</label>
                                        <input type="date" id="tanggal" name="tanggal" class="form-control form-control-sm" v-model="currentData.tanggal" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="waktu" class="form-label">Waktu</label>
                                        <input type="time" id="waktu" name="waktu" class="form-control form-control-sm" v-model="currentData.waktu" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="petugas_bahan" class="form-label">Petugas Pemohon</label>
                                        <auto-suggest v-model="currentData.nama_pegawai" :suggestions="petugasBahan" display-key="nama_pegawai" extra-key="nip_pegawai" @input="debouncedSearchPetugasBahan" @select="selectPetugasBahanNew"></auto-suggest>
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <!-- Tabel Input Data -->
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Bahan</th>
                                            <th>Jumlah Bahan</th>
                                            <th>Nama Alat</th>
                                            <th>Jumlah Alat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in items" :key="index">
                                            <td>{{ index + 1 }}</td> <!-- Menampilkan nomor urut -->
                                            <td><input type="text" class="form-control" v-model="currentData.nama_bahan" placeholder="Nama Bahan" required></td>
                                            <td><input type="text" class="form-control" v-model="currentData.jumlah_bahan" placeholder="Jumlah Bahan" required></td>
                                            <td><input type="text" class="form-control" v-model="currentData.nama_alat" placeholder="Nama Alat" required></td>
                                            <td><input type="text" class="form-control" v-model="currentData.jumlah_alat" placeholder="Jumlah Alat" required></td>
                                            <td><button type="button" class="btn btn-danger" @click="removeItem(index)" disabled>Hapus</button></td>
                                        </tr>

                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-success" @click="addItem" disabled>+ Add</button>

                                <!-- Tombol Simpan dan Batal -->
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="reset" class="btn btn-warning" @click="resetForm">Batal</button>
                                </div>
                            </div>
                        </form>
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