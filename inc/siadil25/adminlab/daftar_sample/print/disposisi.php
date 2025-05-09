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
                <td rowspan="4" width="100" align="center" valign="middle"><img src="../../img/bppmhkp.png" width="100" height="60" align="center" /></td>
                <td rowspan="2" width="300" align="center" valign="middle">
                    <h2>FORMULIR KERJA</h2>
                </td>
                <td>No. Dokumen</td>
                <td>: FK 8.4.3/OK/SKI-MM</td>
            </tr>
            <tr>
                <td width="80">Edisi/Revisi/tgl</td>
                <td width="150">: 01/04/01 Maret 2024</td>
            </tr>
            <tr>
                <th rowspan="2" align="center" valign="middle" width="300">DISPOSISI PEMERIKSAAN LABORATORIUM</th>
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
    <p style="text-align: center; font-weight:bold;">DISPOSISI PEMERIKSAAN LABORATORIUM</p>
    <br>

    <div class="#">
        <table width="600" border="0">
            <tr>
                <td width="15"><strong>A.</strong></td>
                <td colspan="4"><strong>Informasi Sample</strong></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td width="12">1.</td>
                <td width="200">Kode Sample</td>
                <td width="3">:</td>
                <td width="410"><?= $_REQUEST['kd_sample']; ?></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>2.</td>
                <td>Nama Sampel</td>
                <td>:</td>
                <td><?= $_REQUEST['nama_sample']; ?> </td>
            </tr>

            <tr>
                <td>&nbsp;</td>
                <td>3.</td>
                <td>Jumlah Sampel</td>
                <td>:</td>
                <td><?= $_REQUEST['jumlah']; ?> <?= $_REQUEST['satuan']; ?></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>4.</td>
                <td>Tanggal Permintaan Uji</td>
                <td>:</td>
                <td><?= date('d-m-Y', strtotime($_REQUEST['tgl_terima'])); ?></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>5.</td>
                <td>Tanggal Terima Sampel</td>
                <td>:</td>
                <td><?= date('d-m-Y', strtotime($_REQUEST['tgl_terima'])); ?></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>
        <!--?php } ?-->

        <strong>B. Parameter Uji</strong>
        <p>Bersama dengan ini memerintahkan kepada petugas pemeriksa untuk dilakukan pemeriksaan laboratorium sebagai
            berikut :</p>
        <table border="1">
            <thead>
                <tr>
                    <th>
                        No.
                    </th>
                    <th>
                        Target Uji
                    </th>
                    <th>
                        Metode Pengujian (Acuan)
                    </th>
                    <th>
                        Organ Target Periksa
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $sql = "SELECT * FROM view_penerimaan_target WHERE kd_sample='" . $_GET['kd_sample'] . "'";
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
                        <td width="40" align="center" style="<?= $rowHeight ? "height: {$rowHeight}px;" : ''; ?>"><?= $no++; ?></td>
                        <td width="200" style="<?= $isItalic ? 'font-style: italic;' : ''; ?>">
                            <?= $r['target_pengujian']; ?>
                        </td>
                        <td width="200"><?= $r['metode_pengujian']; ?></td>
                        <td width="200"><?= $r['organ_target']; ?></td>
                    </tr>
                <?php }
                ?>
            </tbody>
        </table>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <table>
            <tr>
                <td style="width: 400;">
                    &nbsp; &nbsp;
                </td>
                <td style="width: 250;">
                    Manajer Teknis, <br>
                    Merauke, <?= date('d-m-Y', strtotime($_REQUEST['tgl_terima'])); ?>
                    <br>
                    <br>
                    <br>
                    <br>
                    <?= $_REQUEST['mt']; ?>
                </td>
            </tr>
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
    }


    p {
        margin: 15px 0;
        height: 10px;
        line-height: 1.5;
    }
</style>