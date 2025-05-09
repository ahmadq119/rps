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
        margin-left: 50px;
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
?>

<page backtop="40mm" backbottom="10mm" backleft="15mm" backright="15mm">
    <page_header>
        <br>
        <div class="conthead">
            <table width="200" border="1">
                <tr>
                    <td rowspan="4" width="100" align="center" valign="middle"><img src="../../img/bppmhkp.png" width="90" align="center" /></td>
                    <td rowspan="2" width="300" align="center" valign="middle">
                        <h2>FORMULIR KERJA</h2>
                    </td>
                    <td>No. Dokumen</td>
                    <td>: FK 7.5.6 /OK/SKI-MM</td>
                </tr>
                <tr>
                    <td width="80">Edisi/Revisi/tgl</td>
                    <td width="150">: 01/04/01 Maret 2024</td>
                </tr>
                <tr>
                    <th rowspan="2" align="center" valign="middle" width="300">REKAMAN PENYINARAN UV RUANG UJI</th>
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
        <p align="center">REKAMAN PENYINARAN UV RUANG UJI</p>
    </div>
    <br>
    <table>
        <tr>
            <td width=100>Nama Ruang</td>
            <td>:</td>
            <td>Ruang <?= ucfirst(
                            $_SESSION['folder']
                        ) ?></td>
        </tr>
        <tr>
            <?php
            $ambilbulan = $_REQUEST['bulan'];
            $bulanIndo = getBulan($ambilbulan);
            echo '<td>Bulan</td><td>:</td><td>' . $bulanIndo . '</td>';
            ?>
        </tr>
        <tr>
            <td>Tahun</td>
            <td>:</td>
            <td><?= $_REQUEST['tahun'] ?></td>
        </tr>
    </table>
    <br>
    <table width="600" border="1">
        <tr>
            <th rowspan="3" scope="col" width="100">Tanggal Pelaksanaan</th>
            <th colspan="2" scope="col">Penyinaran UV 60'</th>
            <th rowspan="3" scope="col" width="190">Petugas/Analis/Penyelia</th>
            <th rowspan="3" scope="col" width="100">Paraf</th>
        </tr>
        <tr>
            <th colspan="2" scope="col">Waktu Pelaksanaan</th>
        </tr>
        <tr>
            <td align="center" width="120">Pra Kegiatan</td>
            <td align="center" width="120">Pasca Kegiatan</td>
        </tr>
        <?php
        $i = 1;
        $bulan = $_REQUEST['bulan'];
        $tahun = $_REQUEST['tahun'];
        $ruangid = $_SESSION['ruangid'];
        $sql = "Select * from view_rek_uv_ruangan where month(tgl_kegiatan)='$bulan' and year(tgl_kegiatan)='$tahun' and ruangid='$ruangid' order by tgl_kegiatan asc";
        $query = sqlsrv_query($koneksi, $sql);
        while ($r = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) { ?>
            <tr>
                <td width="100" align="center"><?= date_format(
                                                    $r['tgl_kegiatan'],
                                                    'd-m-Y'
                                                ) ?></td>
                <td width="120" align="center"><?= date_format($r['pra_mulai'], 'H:i') .
                                                    ' - ' .
                                                    date_format($r['pra_selesai'], 'H:i') ?></td>
                <td width="120" align="center"><?= date_format($r['pasca_mulai'], 'H:i') .
                                                    ' - ' .
                                                    date_format($r['pasca_selesai'], 'H:i') ?></td>
                <td width="190" align="center"><?= $r['nama_pegawai'] ?></td>
                <td width="100" align="center"></td>
            </tr>
        <?php }
        ?>
    </table>
    <table border="0">
        <tr>
            <td colspan="3">Penggunaan lampu UV ruang efektiv membunuh mikroorganisme : 1000 jam</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Total penggunaan lampu UV periode bulan ini</td>
            <td>:</td>
            <td>.........................Jam</td>
        </tr>
        <tr>
            <td>Total penggunaan lampu UV s/d bulan ini</td>
            <td>:</td>
            <td>.........................Jam</td>
        </tr>
    </table>
    <br>
    <br>

    <table align="center" border="0">
        <tr>
            <?php
            $bln_aja = $_REQUEST['bulan'];
            $thn = $_REQUEST['tahun'];
            $bulanAjaBahasaIndonesia = getBulan($bln_aja);
            echo '<td align="center">Merauke, ........ - ' .
                $bulanAjaBahasaIndonesia .
                ' ' .
                $thn .
                '</td>';
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
            <td align="center"><?= $_REQUEST['nm_mt'] ?></td>
        </tr>
    </table>
</page>