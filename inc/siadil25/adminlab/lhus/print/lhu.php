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

    <div class="conthead">
        <table width="200" border="1">
            <tr>
                <td rowspan="4" width="130" align="center" valign="middle"><img src="../../img/bppmhkp.png" width="100" height="60" align="center" /></td>
                <td rowspan="2" width="300" align="center" valign="middle">
                    <h2>FORMULIR KERJA</h2>
                </td>
                <td width="100">No. Dokumen</td>
                <td>: FK 8.12.6/OK/SKI-MM</td>
            </tr>
            <tr>
                <td width="80">Edisi/Revisi/tgl</td>
                <td width="150">: 01/04/01 Maret 2024</td>
            </tr>
            <tr>
                <th rowspan="2" align="center" valign="middle" width="300">LAPORAN HASIL UJI SEMENTARA</th>
                <td>Berlaku Efektif</td>
                <td>: 01 Maret 2024</td>
            </tr>
            <tr>
                <td>Halaman</td>
                <td>: [[page_cu]]/[[page_nb]]</td>
            </tr>
            <tr>
                <th colspan="4" align="center" valign="middle">STASIUN KARANTINA IKAN, PENGENDALIAN MUTU DAN KEAMANAN HASIL PERIKANAN MERAUKE</th>
            </tr>
        </table>
    </div>
    <br>
    <p style="text-align: center; font-weight:bold;">LAPORAN HASIL UJI SEMENTARA (LHUS)</p>
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
                    <td>Kode Sampel / <br><em>Sample code</em></td>
                    <td>:</td>
                    <td><?= $row['kd_sample']; ?> </td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>Jenis Sampel / <br><em>Type of sample</em></td>
                    <td>:</td>
                    <td><?= $row['nama_sample']; ?> </td>
                </tr>
                <tr>
                    <td>3.</td>
                    <td>Tanggal Penerimaan / <br><em>Receipt date</em></td>
                    <td>:</td>
                    <td><?= ($row['tgl_terima'] instanceof DateTime) ? $row['tgl_terima']->format('d-m-Y') : date('d-m-Y', strtotime($row['tgl_terima'])); ?></td>
                </tr>
                <tr>
                    <td>4.</td>
                    <td>Tanggal Pengujian / <br><em>Testing date</em></td>
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


</body>

</html>
<style>
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