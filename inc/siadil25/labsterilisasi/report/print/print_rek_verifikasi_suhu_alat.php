<style>
    body {
        font-size: 12px;
    }

    table {
        border: solid 1px black;
        border-collapse: collapse
    }

    table th {
        font-size: 12px;
        text-align: center;
        height: 20px;
    }

    table td {
        font-size: 12px;
        height: 15px;
    }

    div.container {
        margin-left: 800px;
        width: 300px;
        height: 150px;
    }

    div.judul {
        font-size: 14px;
        font-weight: bold;
    }

    div.tebal {
        font-size: 12px;
        font-weight: bold;
    }

    div.label {
        font-size: 9px;
    }

    div.conthead {
        font-size: 12px;
    }

    div.conthead table th {
        font-size: 14px;
    }

    div.conthead table td {
        font-size: 12px;
    }
</style>
<?php
include '../../login/config.php';
include 'fungsi_indotgl.php';
session_start();
$ruangid = $_SESSION['ruangid'];
$ruang = $_SESSION['folder'];
?>
<page backtop="40mm">
    <page_header>
        <br>
        <div class="conthead">
            <table width="200" border="1">
                <tr>
                    <td rowspan="4" width="100" align="center" valign="middle"><img src="../../img/bppmhkp.png" width="100" height="60" align="center" /></td>
                    <td rowspan="2" width="300" align="center" valign="middle">
                        <h2>FORMULIR KERJA</h2>
                    </td>
                    <td>No. Dokumen</td>
                    <td>: FK 7.3.7 /OK/SKI-MM</td>
                </tr>
                <tr>
                    <td width="80">Edisi/Revisi/tgl</td>
                    <td width="150">: 01/04/01 Maret 2024</td>
                </tr>
                <tr>
                    <th rowspan="2" align="center" valign="middle" width="300">VERIFIKASI SUHU ALAT</th>
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
    </page_header>

    <div class="judul">
        <p align="center">REKAMAN VERIFIKASI SUHU ALAT</p>
    </div>
    <br>

    <table border="1">
        <tr>
            <td width="100">Nama Ruang</td>
            <td width="225">: <?= strtoupper($ruang); ?></td>
            <td width="100">Bulan</td>
            <td width="225">: <?= getBulan($_GET['bulan']); ?></td>
        </tr>
        <tr>
            <td width="100">Nama Alat</td>
            <td width="225">: <?= $_GET['alat']; ?></td>
            <td width="100">Tahun</td>
            <td width="225">: <?= $_GET['tahun']; ?></td>
        </tr>

    </table>
    <p></p>

    <table width="600" border="1">
        <tr>
            <th scope="col" width="40">No</th>
            <th scope="col" width="100">Tanggal Pelaksanaan</th>
            <th scope="col" width="100">Hasil Pengukuran dari Alat Standar</th>
            <th scope="col" width="100">Setting Alat/Nilai yang Tertera pada Alat yang Diuji</th>
            <th scope="col" width="150">Nama Petugas / Penyelia / Analis</th>
            <th scope="col" width="100">Paraf</th>
            <th scope="col" width="50">Ket.</th>
        </tr>
        <?php
        $i = 1;
        $bulan = $_REQUEST['bulan'];
        $tahun = $_REQUEST['tahun'];
        $ruangid = $_SESSION['ruangid'];
        $alat = $_GET['alat'];
        $sql = "SELECT * FROM View_rek_verifikasi_suhu_alat WHERE month(tanggal)=$bulan AND year(tanggal)=$tahun AND ruangid='$ruangid' AND UPPER(nama_alat)='$alat' ORDER BY tanggal ASC";
        $query = sqlsrv_query($koneksi, $sql);
        while ($r = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {


            $hariBahasaInggris = date_format($r['tanggal'], 'l');
            $bulanBahasaInggris = date_format($r['tanggal'], 'm');
            $hariBahasaIndonesia = hariIndo($hariBahasaInggris);
            $bulanBahasaIndonesia = getBulan($bulanBahasaInggris);


        ?>
            <tr>
                <td width="40" align="center"><?= $i++; ?></td>
                <td width="100" align="center"><?= date_format($r['tanggal'], 'd-m-Y'); ?></td>
                <td width="100" align="center"><?= $r['hasil_pengukuran']; ?> <sup>0</sup>C</td>
                <td width="100" align="center"><?= $r['nilai_set']; ?> <sup>0</sup>C</td>
                <td width="150" align="center"><?= $r['nama_pegawai']; ?></td>
                <td></td>
                <td></td>
            </tr>
        <?php } ?>
    </table>
    <br>

    <br>

    <table align="center" border="0">
        <tr>
            <?php
            $bln_aja = $_REQUEST['bulan'];
            $thn = $_REQUEST['tahun'];
            $bulanAjaBahasaIndonesia = getBulan($bln_aja);
            echo
            '<td align="center">Merauke, ........ - ' . $bulanAjaBahasaIndonesia . ' ' . $thn . '</td>';
            ?>
        </tr>
        <tr>
            <td align="center">Manajer Teknis</td>
        </tr>
        <tr>
            <td align="center">&nbsp;</td>
        </tr>
        <tr>
            <td align="center">&nbsp;</td>
        </tr>
        <tr>
            <td align="center"><?= $_REQUEST['nm_mt']; ?></td>
        </tr>
    </table>
    <page_footer>
        <div class="label" align="right"><?php echo strtoupper('--ruang : ' . $_SESSION['folder'] . '--'); ?></div>
    </page_footer>
</page>