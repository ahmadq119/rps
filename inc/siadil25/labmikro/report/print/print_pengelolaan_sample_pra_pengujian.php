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

    div.container {
        width: 300px;
        height: 150px;
    }

    div.contmt {
        width: 300px;
        height: 150px;
        font-size: 12px;
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

<page backtop="40mm">
    <page_header>
        <div class="conthead">
            <table width="200" border="1">
                <tr>
                    <td rowspan="4" width="100" align="center" valign="middle"><img src="../../img/bppmhkp.png" width="100" align="center" /></td>
                    <td rowspan="2" width="300" align="center" valign="middle">
                        <h2>FORMULIR KERJA</h2>
                    </td>
                    <td>No. Dokumen</td>
                    <td>: FK 8.9.9/OK/SKI-MM</td>
                </tr>
                <tr>
                    <td width="80">Edisi/Revisi/tgl</td>
                    <td width="150">: 01/04/01 Maret 2024</td>
                </tr>
                <tr>
                    <th rowspan="2" align="center" valign="middle" width="300">REKAMAN PENGELOLAAN SAMPEL PRA PENGUJIAN</th>
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
    <?php
    include '../../login/config.php';
    include 'fungsi_indotgl.php';
    session_start();
    ?>
    <div class="judul" align="center">REKAMAN PENGELOLAAN SAMPEL PRA PENGUJIAN</div>

    <div class="judul">Bulan : <?php echo getBulan($_REQUEST['bulan']); ?></div>
    <div class="judul">Tahun : <?php echo $_REQUEST['tahun']; ?></div>
    <table width="1091" border="1">
        <thead>
            <tr>
                <th width="60" rowspan="2">Tanggal Terima Sample</th>
                <th width="100" rowspan="2">Kode Sampel</th>
                <th width="150" rowspan="2">Jenis Sampel</th>
                <th colspan="3" width="150">Tindakan Pengelolaan Sampel Pra Pengujian</th>
                <th width="130" rowspan="2">Petugas / Analis / Penyelia</th>
                <th width="60" rowspan="2">Paraf</th>
            </tr>

            <tr>
                <th width="50">Preparasi</th>
                <th width="50">Pelabelan</th>
                <th width="50">Distribusi</th>
            </tr>
        </thead>
        <?php
        $thn = $_REQUEST['tahun'];
        $bln = $_REQUEST['bulan'];
        $ruangid = $_SESSION['ruangid'];
        $i = 0;
        $sql = sqlsrv_query($koneksi, "SELECT DISTINCT tgl_kegiatan, kd_sample, nama_sample, nama_pegawai 
                FROM view_persiapan_tempat_kerja
                WHERE year(tgl_kegiatan)='$thn' AND month(tgl_kegiatan)='$bln' AND ruangid= '$ruangid' 
                ORDER BY tgl_kegiatan ASC, kd_sample ASC");
        while ($r = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
            $i++;
        ?>
            <tbody>
                <tr>
                    <td align="center" height="15"><?php echo date_format($r['tgl_kegiatan'], 'd-m-Y'); ?></td>
                    <td width="100" align="center"><?php echo $r['kd_sample']; ?></td>
                    <td><?php echo $r['nama_sample']; ?></td>
                    <td align="center">V</td>
                    <td align="center">V</td>
                    <td align="center">V</td>
                    <td width="130"><?php echo $r['nama_pegawai']; ?></td>
                    <td>&nbsp;</td>
                </tr>

            </tbody>
        <?php } ?>
    </table>
    <br>
    <br>
    <table>
        <tr>
            <td style="width: 400;"></td>
            <td>
                <div class="contmt">
                    <?php

                    $nm = $_REQUEST['nm_mt'];
                    echo "Manajer Teknis,";
                    echo '<br>';
                    echo '<br>';
                    echo '<br>';
                    echo '<br>';
                    echo '<br>';
                    echo '<div class="subjudul">' . $nm . '</div>';
                    echo "NIP. " . $_REQUEST['nip_mt'];

                    ?>
                </div>
            </td>
        </tr>
    </table>
</page>