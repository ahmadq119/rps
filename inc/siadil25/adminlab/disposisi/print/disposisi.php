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
        <!--?php
        $sql = "select * from view_penerimaan_sample where kd_sample='" . $_GET['kd_sample'] . "'";
        $query = sqlsrv_query($koneksi, $sql);
        while ($r = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) { ?>
            <p>Nomor Registrasi : <!?= $r['no_reg']; ?></p>
            <p>Tanggal Penerimaan : <!?= date_format($r['tgl_terima'], 'd-m-Y'); ?></p>
            <p>Sehubungan dengan adanya permohonanan pengujian laboratorium, segera lakukan pengujian terhadap sampel yang diterima.</p-->
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
                <td><?= $_GET['tgl_terima']; ?></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>5.</td>
                <td>Tanggal Terima Sampel</td>
                <td>:</td>
                <td><?= $_GET['tgl_terima']; ?></td>
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
            <tr>
                <td align="center">
                    No.
                </td>
                <td align="center">
                    Target Uji
                </td>
                <td align="center">
                    Metode Pengujian (Acuan)
                </td>
                <td align="center">
                    Organ Target Periksa
                </td>
            </tr>
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
            foreach ($records as $r) { ?>
                <tr>
                    <td width="40" align="center" style="<?= $rowHeight ? "height: {$rowHeight}px;" : ''; ?>"><?= $no++; ?></td>
                    <td width="200"><em><?= $r['target_pengujian']; ?></em></td>
                    <td width="200"><?= $r['metode_pengujian']; ?></td>
                    <td width="200"></td>
                </tr>
            <?php }
            ?>
        </table>




    </div>


</body>

</html>
<style>
    table {
        border: solid 1px black;
        border-collapse: collapse
    }


    p {
        margin: 3px 0;
    }
</style>