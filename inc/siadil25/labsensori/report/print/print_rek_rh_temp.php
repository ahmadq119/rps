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

    .memenuhi {
        color: black;
    }

    .tidak_memenuhi {
        color: red;
    }
</style>
<?php
include '../../login/config.php';
include 'fungsi_indotgl.php';
session_start();
$ruangid = $_SESSION['ruangid'];
?>
<page backtop="40mm" backbottom="10mm">
    <page_header>
        <br>
        <div class="conthead">
            <table width="200" border="1">
                <tr>
                    <td rowspan="4" width="120" align="center" valign="middle"><img src="../../img/bppmhkp.png" width="100" height="60" align="center" /></td>
                    <td rowspan="2" width="320" align="center" valign="middle">
                        <h2>FORMULIR KERJA</h2>
                    </td>
                    <td>No. Dokumen</td>
                    <td>: FK 7.5.3 /OK/SKI-MM</td>
                </tr>
                <tr>
                    <td width="80">Edisi/Revisi/tgl</td>
                    <td width="170">: 01/05/05 Desember 2024 </td>
                </tr>
                <tr>
                    <th rowspan="2" align="center" valign="middle" width="300">REKAMAN RUANG PENGUJIAN</th>
                    <td>Berlaku Efektif</td>
                    <td>: 05 Desember 2024</td>
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
        <p align="center">REKAMAN RUANG PENGUJIAN</p>
    </div>
    <br>

    <table width="600" border="1">
        <tr>
            <th rowspan="2" scope="col" width="40">No</th>
            <th rowspan="2" scope="col" width="130">Hari/Tanggal</th>
            <th colspan="3" scope="col">Kondisi Ruangan</th>
            <th rowspan="2" scope="col" width="130">Kesimpulan</th>
            <th rowspan="2" scope="col" width="70">Paraf</th>
        </tr>
        <tr>
            <td align="center" width="100">RH (%)</td>
            <td align="center" width="100">Temperatur (&deg;C)</td>
            <td align="center" width="100">Lux (lx)</td>
        </tr>
        <?php
        $i = 1;
        $bulan = $_REQUEST['bulan'];
        $tahun = $_REQUEST['tahun'];
        $ruangid = $_SESSION['ruangid'];
        $sql = "SELECT * FROM View_rek_rh_temperatur WHERE month(tgl_kegiatan)=$bulan AND year(tgl_kegiatan)=$tahun AND ruangid='$ruangid' ORDER BY tgl_kegiatan ASC";
        $query = sqlsrv_query($koneksi, $sql);
        while ($r = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {


            $hariBahasaInggris = date_format($r['tgl_kegiatan'], 'l');
            $bulanBahasaInggris = date_format($r['tgl_kegiatan'], 'm');
            $hariBahasaIndonesia = hariIndo($hariBahasaInggris);
            $bulanBahasaIndonesia = getBulan($bulanBahasaInggris);


        ?>
            <tr>
                <td width="40" align="center"><?= $i++; ?></td>
                <td width="130" align="center"><?= $hariBahasaIndonesia . '/' . date_format($r['tgl_kegiatan'], 'd-m-Y'); ?></td>
                <td width="100" align="center"><?= $r['nil_rh']; ?></td>
                <td width="100" align="center"><?= $r['nil_temp']; ?></td>
                <td width="100" align="center"><?= $r['nil_lx']; ?></td>
                <td class="<?= getKesimpulanClass($r['nil_rh'], $r['nil_temp'], $r['nil_lx']) ?>" width="130" align="center">
                    <?= getKesimpulan($r['nil_rh'], $r['nil_temp'], $r['nil_lx']) ?>
                </td>

                <td width="70" align="center"></td>
            </tr>
        <?php } ?>
    </table>
    <br>
    <table>
        <tr>
            <td colspan="2">
                Catatan
            </td>
        </tr>
        <tr>
            <td valign="top">1.</td>
            <td>Formulir ini digunakan bila metode pengujian mempersyaratkan kondisi ruang pengujian tertentu, atau bila laboratorium mempersyaratkan pemantauan RH/T ruang instrumentasi.</td>
        </tr>
        <tr>
            <td>2.</td>
            <td>Standart persyaratan suhu ruang 20 ±3 &deg;C dan kelembaban (RH) 45 - 65 %.</td>
        </tr>
        <tr>
            <td>3.</td>
            <td> Standar persyaratan Intensitas cahaya (lx) pada bilik pengujian organoleptik : 300 - 500 lux</td>
        </tr>
        <tr>
            <td>4.</td>
            <td>RH = Relative Humidity.</td>
        </tr>
        <tr>
            <td>5.</td>
            <td>T = Temperature</td>
        </tr>
        <tr>
            <td>6.</td>
            <td> lx = Lux (pencahayaan dan daya pancar cahaya)</td>
        </tr>
    </table>

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

<?php
function getKesimpulan($rh, $temp, $lux)
{
    $rhMin = 45;
    $rhMax = 65;
    $tempMin = 17;
    $tempMax = 23; // 20 ± 3°C
    $luxMin = 300;
    $luxMax = 500;

    if ($rh >= $rhMin && $rh <= $rhMax && $temp >= $tempMin && $temp <= $tempMax && $lux >= $luxMin && $lux <= $luxMax) {
        return "Memenuhi";
    } else {
        return "Tidak Memenuhi";
    }
}

function getKesimpulanClass($rh, $temp, $lux)
{
    return getKesimpulan($rh, $temp, $lux) === "Memenuhi" ? "memenuhi" : "tidak_memenuhi";
}
?>