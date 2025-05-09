<?php
include '../../login/config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Kaji Ulang Permintaan</title>
</head>

<body>
    <div style="text-align: right;">FK 8.12.7 /OK/SKI-MM</div>
    <table border="0">
        <tr>
            <td width="140">
                <img src="../../img/lgkkp.png" alt="Deskripsi Gambar" style="max-width: 100%; height: auto;">
            </td>
            <td width="410">
                <div style="text-align: center; font-family:Arial; font-size:14px; color:blue; font-weight:bold">
                    KEMENTERIAN KELAUTAN DAN PERIKANAN
                </div>
                <div style="text-align: center; font-family:Arial; font-size:16px; color:blue;">
                    BADAN PENGENDALIAN DAN PENGAWASAN MUTU HASIL KELAUTAN DAN PERIKANAN
                </div>
                <div style="text-align: center; font-family:Arial; font-size:14px; color:blue; font-weight:bold">
                    STASIUN KARANTINA IKAN, PENGENDALIAN MUTU DAN KEAMANAN HASIL PERIKANAN MERAUKE
                </div>
                <div style="text-align: center; font-family:Arial; font-size:12px;">
                    JALAN GARUDA SPADEM KOTAK POS 263 MERAUKE 99601 <br>TELEPON (0971) 324169, FAKSIMILE (0971) 323749

                </div>
                <div style="text-align: center; font-family:Arial; font-size:12px;">
                    LAMAN <a href="www.kkp.go.id">www.kkp.go.id</a> SUREL <a href="mailto:skipmmerauke@kkp.go.id">skipmmerauke@kkp.go.id</a>
                </div>
            </td>
            <td width="140">
                <img src="../../img/KAN-Merauke.png" alt="Logo Kan" style="max-width: 100%; height: auto;">
            </td>
        </tr>
    </table>
    <hr>
    <br>
    <div style="text-align: center; font-weight:bold;">
        HASIL UJI <br>
        <em>TEST RESULT</em>
    </div>
    <div style="text-align:center">
        Nomor / <em>Number</em> : <?php echo $_GET['no_lhu'] ?>
    </div>
    <br>
    <p>Menyatakan bahwa :<br><em>This is certiify that</em></p>
    <div class="#">
        <table width="600" border="0">
            <?php
            $kd_sample = $_GET['kd_sample'];
            $sql = "SELECT * FROM View_penerimaan_sample WHERE kd_sample = '$kd_sample'";
            $query = sqlsrv_query($koneksi, $sql);
            $records = []; // Array untuk menyimpan record
            //$response = array();
            while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                $records[] = $row;
            ?>
                <tr>
                    <td>1.</td>
                    <td width="150">Pelanggan / <em>Customer</em></td>
                    <td width="3">:</td>
                    <td width="470"><?= $row['nama_customer']; ?></td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>Alamat / <em>Address</em></td>
                    <td>:</td>
                    <td width="470" style="text-align: justify;"><?= $row['alamat_customer']; ?> </td>
                </tr>
                <tr>
                    <td>3.</td>
                    <td>Tanggal Penerimaan / <em>Receipt date</em></td>
                    <td>:</td>
                    <td><?= ($row['tgl_terima'] instanceof DateTime) ? $row['tgl_terima']->format('d-m-Y') : date('d-m-Y', strtotime($row['tgl_terima'])); ?></td>
                </tr>
                <tr>
                    <td>4.</td>
                    <td>Jenis Sampel / <em>Type of sample</em></td>
                    <td>:</td>
                    <td><?= $row['nama_sample']; ?> </td>
                </tr>
                <tr>
                    <td>5.</td>
                    <td>Kode Sampel / <em>Sample code</em></td>
                    <td>:</td>
                    <td><?= $row['kd_sample']; ?> </td>
                </tr>
                <tr>
                    <td>6.</td>
                    <td>Tanggal Pengujian / <em>Testing date</em></td>
                    <td>:</td>
                    <td><?= ($row['tgl_uji'] instanceof DateTime) ? $row['tgl_uji']->format('d-m-Y') : $row['tgl_uji']; ?></td>
                </tr>
            <?php } ?>
        </table>

        <br>
        <br>
        <table border="1" class="tabel-hasil">
            <thead>
                <tr>
                    <th>
                        No.
                    </th>
                    <th width="110">
                        Bidang Pengujian / <em>Test Field</em>
                    </th>
                    <th width="100">
                        Parameter /
                        <em>Parameter</em>
                    </th>
                    <th width="100">
                        Hasil (Satuan) /
                        <em>Result (unit)</em>
                    </th>
                    <th width="100">
                        Persyaratan Mutu /
                        <em>Quality Requirement</em>
                    </th>
                    <th width="130">
                        Metode Acuan /
                        <em>Reference Methode</em>
                    </th>
                    <th width="100">
                        Keterangan /
                        <em>Information</em>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $sql = "SELECT * FROM view_lhu WHERE kd_sample='" . $_GET['kd_sample'] . "'";
                $query = sqlsrv_query($koneksi, $sql);
                $records = []; // Array untuk menyimpan record
                while ($r = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                    $records[] = $r;
                }

                // Hitung jumlah record
                $recordCount = count($records);

                // Tentukan tinggi row berdasarkan jumlah record
                $rowHeight = 0;
                if ($recordCount === 1) {
                    $rowHeight = 60;
                } elseif ($recordCount === 2) {
                    $rowHeight = 60;
                }


                // Tampilkan data dengan tinggi yang sesuai
                foreach ($records as $r) {
                    $isItalic = !in_array($r['idtarget'], [1, 2, 3]); // Cek apakah idtarget adalah 1, 2, atau 3 
                ?>
                    <tr>
                        <td width="30" align="center" style="<?= $rowHeight ? "height: {$rowHeight}px;" : ''; ?>">
                            <?= $no++; ?>
                        </td>
                        <td width="110" style="<?= $isItalic ? 'font-style: italic;' : ''; ?>">
                            <?= $r['bidang_pengujian']; ?>
                        </td>
                        <td width="100">
                            <?= $r['parameter']; ?>
                        </td>
                        <td width="100">
                            <?= nl2br(html_entity_decode($r['hasil'])); ?>
                        </td>
                        <td width="100">
                            <?= nl2br(html_entity_decode($r['persyaratan_mutu'])); ?>
                        </td>
                        <td width="130">
                            <?= nl2br(html_entity_decode($r['metode_acuan'])); ?>
                        </td>
                        <td width="100">
                            <?= nl2br(html_entity_decode($r['keterangan'])); ?>
                        </td>
                    </tr>
                <?php }
                ?>
            </tbody>
        </table>
        <p>&nbsp;</p>
        <table class="tabel-catatan">
            <tr>
                <td>Catatan / :<br><em>Note</em></td>
                <td>1.</td>
                <td>Hasil uji ini hanya berlaku untuk contoh uji yang diuji <br>
                    <em>This result of the test are only valid for the tested sample</em>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>2.</td>
                <td>Laporan hasil iji ini terdiri dari 1 (satu) lembar asli (Stempel Asli) <br>
                    <em>This report of test consist of 1 (one) page original (Original sign)</em>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>3.</td>
                <td width="600">Laporan hasil uji ini tidak boleh digandakan, kecuali secara lengkap dan seizin tertulis Kepala Stasiun KIPM Merauke (Stempel Copy)<br>
                    <em>This report Test shall not be reproduced (copied) except for the completed one and with written permission of the Head of Marine and Fisheries Quality Assurance Agency of Merauke</em>
                </td>
            </tr>
        </table>
        <p>&nbsp;</p>
        <table>
            <?php
            $sql = "SELECT DISTINCT tgl_lhu, nama_pegawai, nip_pegawai FROM view_lhu WHERE kd_sample='" . $_GET['kd_sample'] . "'";
            $query = sqlsrv_query($koneksi, $sql);
            $records = []; // Array untuk menyimpan record
            while ($r = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                $records[] = $r;
            ?>
                <tr>
                    <td style="width: 400;">
                        &nbsp; &nbsp;
                    </td>
                    <td style="width: 250;">
                        Manajer Teknis, <br>
                        Merauke, <?= ($r['tgl_lhu'] instanceof DateTime) ? $r['tgl_lhu']->format('d-m-Y') : $r['tgl_lhu']; ?>
                        <br>
                        <br>
                        <br>
                        <br>
                        <?= $r['nama_pegawai']; ?>
                    </td>
                </tr>
            <?php } ?>
        </table>




    </div>

    <!-- Page Footer -->
    <!--div class="page-footer">
        <p>Dokumen ini dicetak secara otomatis oleh sistem | Halaman <span class="page-number"></span></p>
    </div-->
</body>

</html>
<style>
    .page-header {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        text-align: center;
        font-size: 14px;
        font-weight: bold;
        background: white;
        padding: 10px;
        border-bottom: 2px solid black;
    }

    .page-footer {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        text-align: center;
        font-size: 12px;
        background: white;
        padding: 5px;
        border-top: 1px solid black;
    }

    body {
        margin-top: 120px;
        /* Pastikan isi dokumen tidak tertutup oleh header */
        margin-bottom: 50px;
        /* Pastikan isi dokumen tidak tertutup oleh footer */
    }

    table {
        border: solid 1px black;
        border-collapse: collapse
    }

    th {
        text-align: center;
        height: 35px;
        vertical-align: middle;
    }

    .tabel-hasil th,
    .tabel-hasil td {
        text-align: center;
        vertical-align: middle;
        font-size: 12px;

    }

    .tabel-catatan td {
        text-align: justify;
        vertical-align: top;
        font-size: smaller;

    }
</style>