<style>
    table {
        border: solid 1px black;
        border-collapse: collapse
    }

    table th {
        font-size: 10px;
        text-align: center;
        height: 20px;
    }

    table td {
        font-size: 10px;
    }

    div.containeranalis {
        margin-left: 750px;
        width: 300px;
        height: 150px;
        font-size: 12px;
    }

    div.container {
        /*margin-left: 50px;*/
        width: 300px;
        height: 100px;
        font-size: 12px;
    }

    div.judul {
        font-size: 14px;
        font-weight: bold;
    }

    div.subjudul {
        font-size: 12px;
        font-weight: bold;
        align: left;
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

<page backtop="40mm">
    <page_header>
        <div class="conthead" align=">
<table width=" 200" border="1" align="center">
            <tr>
                <td rowspan="4" width="200" align="center" valign="middle"><img src="../../img/bppmhkp.png" width="100" align="center" /></td>
                <td rowspan="2" width="450" align="center" valign="middle">
                    <h2>FORMULIR KERJA</h2>
                </td>
                <td>No. Dokumen</td>
                <td>: FK 8.9.11/OK/SKI-MM</td>
            </tr>
            <tr>
                <td width="100">Edisi/Revisi/tgl</td>
                <td width="200">: 01/04/01 Maret 2024</td>
            </tr>
            <tr>
                <td rowspan="2" align="center" valign="middle">
                    <h4>REKAPITULASI PEMERIKSAAN PENGUJIAN</h4>
                </td>
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
    <page_footer>
    </page_footer>
    <?php
    include '../../login/config.php';
    include 'fungsi_indotgl.php';
    session_start();
    ?>
    <div class="judul">
        <p align="center">REKAPITULASI PEMERIKSAAN / PENGUJIAN PENYAKIT IKAN</p>
    </div>
    <br>
    <table>
        <tr>
            <td width="180" STYLE="font-size:12; font-weight: bold;">RUANG</td>
            <td width="180" STYLE="font-size:12; font-weight: bold;">:
                Ruang <?= ucfirst(
                            $_SESSION['folder']
                        ) ?></td>
        </tr>
        <tr>
            <td STYLE="font-size:12; font-weight: bold;">PERIODE BULAN/TAHUN</td>
            <td STYLE="font-size:12; font-weight: bold;">
                : <?php
                    $ambilbulan = $_REQUEST['bulan'];
                    $bulanIndo = getBulan($ambilbulan);
                    echo $bulanIndo;
                    ?> <?php echo $_REQUEST['tahun']; ?>
            </td>
        </tr>
    </table>
    <br>
    <table width="1091" border="1">
        <thead>
            <tr>
                <th width="20" rowspan="2">No</th>
                <th rowspan="2">Kode Sampel</th>
                <th width="60" rowspan="2">Tanggal Terima</th>
                <th width="60" rowspan="2">Tanggal Pengujian</th>
                <th width="60" rowspan="2">Tanggal Hasil</th>
                <th width="40" rowspan="2">Jumlah</th>
                <th colspan="2">Morfologi</th>
                <th width="90" rowspan="2">Organ Target</th>
                <th width="80" rowspan="2">Metode Pemeriksaan</th>
                <th width="150" rowspan="2">Hasil Pemeriksaan</th>
                <th width="120" rowspan="2">Nama Pelaksana</th>
                <th width="60" rowspan="2">Paraf / tanda tangan</th>
                <th width="60" rowspan="2">Keterangan</th>
            </tr>
            <tr>
                <th width="70">Panjang</th>
                <th width="70">Berat</th>
            </tr>
        </thead>
        <?php
        $thn = $_REQUEST['tahun'];
        $bln = $_REQUEST['bulan'];
        $i = 0;
        $sql = sqlsrv_query($koneksi, "SELECT * FROM view_hasil_mikrobiologi 
        WHERE year(tgl_terima)='$thn' AND month(tgl_terima)='$bln'
        ORDER BY tgl_terima ASC, kd_sample ASC");
        while ($r = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
            $i++;
        ?>
            <tbody>
                <tr>
                    <td align="center"><?php echo $i; ?></td>
                    <td width="90"><?php echo $r['kd_sample']; ?></td>
                    <td><?php echo date_format($r['tgl_terima'], 'd-m-Y'); ?></td>
                    <td><?php echo date_format($r['tgl_terima'], 'd-m-Y'); ?></td>
                    <td><?php echo date_format($r['tgl_hasil'], 'd-m-Y'); ?></td>
                    <td><?php echo $r['jumlah']; ?> <?php echo $r['satuan']; ?></td>
                    <td><?php echo $r['panjang']; ?></td>
                    <td><?php echo $r['berat']; ?></td>
                    <td><?php echo $r['organ_target']; ?></td>
                    <td width="80"><?php echo $r['metode_pengujian']; ?></td>
                    <td width="150">
                        <?php echo $r['nama_bakteri_ditemukan']; ?>
                    </td>

                    <td width="120"> <?php echo $r['analis']; ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>

            </tbody>
        <?php } ?>
    </table>
    <br>
    <br>
    <div class="containeranalis">
        <?php
        $nm = $_REQUEST['nm_mt'];
        echo "Merauke,........  " . getBulan($_REQUEST['bulan']) . ' ' . $_REQUEST['tahun'] . '<br>' . "Manajer Teknis,";
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '<div class="subjudul">' . $nm . '</div>';

        //echo "NIP ".$row['nip'];
        //}
        ?>
    </div>
    <br>
</page>