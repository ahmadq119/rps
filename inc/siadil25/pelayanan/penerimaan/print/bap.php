<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORM BAP</title>
    <style>
        table {
            border: solid 1px black;
            border-collapse: collapse
        }

        table th {
            font-size: 12px;
            text-align: center;
            height: 20px;
        }

        p {
            text-align: justify;
        }
    </style>
</head>

<body>
    <div class="conthead">
        <table border="1">
            <tr>
                <td rowspan="4" width="110" align="center" valign="middle">
                    <img src="../../img/bppmhkp.png" width="100" align="center" />
                </td>
                <td rowspan="2" width="240" align="center" valign="middle">
                    <h2>FORMULIR KERJA</h2>
                </td>
                <td width="90">No. Dokumen</td>
                <td width="180">: FK 8.9.3/OK/SKI-MM</td>
            </tr>
            <tr>
                <td>Edisi/Revisi/tgl</td>
                <td>: 01/04/01 Maret 2024</td>
            </tr>
            <tr>
                <th rowspan="2" align="center" valign="middle" width="240"><strong>BERITA ACARA SERAH TERIMA SAMPEL</strong></th>
                <td>Berlaku Efektif</td>
                <td>: 01 Maret 2024</td>
            </tr>
            <tr>
                <td>Halaman</td>
                <td id="pageNumber">: [[page_cu]]/[[page_nb]] </td>
            </tr>
            <tr>
                <th colspan="4" align="center" valign="middle">STASIUN KARANTINA IKAN, PENGENDALIAN MUTU DAN KEAMANAN HASIL PERIKANAN MERAUKE</th>
            </tr>
        </table>
    </div>
    <br>
    <br>
    <p align="center"><u><strong>BERITA ACARA SERAH TERIMA SAMPEL</strong></u><br />
        <?php
        include '../../login/config.php';
        include 'fungsi_indotgl.php';

        // Query database
        $sql = sqlsrv_query($koneksi, "SELECT * FROM view_penerimaan_sample WHERE kd_sample='" . $_GET['kd_sample'] . "'");
        $r = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC);

        if (!$r) {
            die("Data tidak ditemukan atau query gagal.");
        }

        // Validasi tgl_terima
        $tgl_terima = $r['tgl_terima'];
        if (!$tgl_terima instanceof DateTime) {
            $tgl_terima = new DateTime($tgl_terima);
        }

        // Konversi tanggal
        $thn = intval($tgl_terima->format('Y'));
        $bln = intval($tgl_terima->format('m'));
        $tgl = intval($tgl_terima->format('d'));
        $hari = $tgl_terima->format('l');

        // Terjemahkan hari ke bahasa Indonesia
        $hari_indonesia = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];
        $hari = $hari_indonesia[$hari] ?? $hari;

        // Bulan dalam bahasa Indonesia
        $bulan = [
            1 => 'januari',
            2 => 'februari',
            3 => 'maret',
            4 => 'april',
            5 => 'mei',
            6 => 'juni',
            7 => 'juli',
            8 => 'agustus',
            9 => 'september',
            10 => 'oktober',
            11 => 'november',
            12 => 'desember',
        ];

        // Format kalimat
        $ket = $hari . ' tanggal ' . terbilang($tgl) . ' bulan ' . ucwords($bulan[$bln]) . ' tahun ' . terbilang($thn);
        ?>

    </p>
    <p><?php echo 'Pada hari ini ' . $ket . ', yang bertanda tangan di bawah ini:'; ?></p>
    <table>
        <tr>
            <td width="101">Nama</td>
            <td width="489">: <?php echo $r['p_sample']; ?></td>
        </tr>
        <tr>
            <td>Nip</td>
            <td>: <?php echo $r['nip_p_sample']; ?></td>
        </tr>
        <tr>
            <td colspan="2">Selaku petugas pengambil sampel / customer )*. </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>: <?php echo $r['p_pelayanan']; ?></td>
        </tr>
        <tr>
            <td>Nip</td>
            <td>: <?php echo $r['nip_p_pelayanan']; ?></td>
        </tr>
        <tr>
            <td colspan="2">Selaku petugas pelayanan.</td>
        </tr>
    </table>
    <p>
        Petugas pengambil sampel / customer )* telah menyerahkan sampel kepada petugas pelayanan dengan rincian sebagai berikut
    </p>
    <br>
    <table width="650" border="1">
        <tr>
            <th width="46" rowspan="2">No</th>
            <th colspan="2">Jenis Sampel</th>
            <th width="85" rowspan="2">Jumlah</th>
            <th width="135" rowspan="2">Kode Sampel</th>
        </tr>
        <tr>
            <th width="180">Nama Umum</th>
            <th width="180">Nama Latin</th>
        </tr>
        <tr>
            <td height="60" align="center">1</td>
            <td align="center"><?php echo $r['nama_sample']; ?></td>
            <td align="center"><i><!--?php echo $r['nm_latin']; ?--></i></td>
            <td align="center"><?php echo $r['jumlah'] . ' ' . $r['satuan']; ?></td>
            <td align="center"><?php echo $r['kd_sample']; ?></td>
        </tr>
    </table>
    <p> Demikian berita acara ini dibuat untuk dapat dipergunakan sebagaimana mestinya. </p>
    <p>&nbsp;</p>
    <table width="650">
        <tr>
            <td width="315">
                <p style="text-align: center;">Petugas Pengambil Sampel / Customer )* </p>
                <p>&nbsp;</p>
                <p style="text-align: center;"><span class="tebal"><strong><?php echo $r['p_sample']; ?></strong></span><br />
                    <?php echo 'NIP. ' . $r['nip_p_sample']; ?></p>
            </td>
            <td width="319">
                <p style="text-align: center;">Petugas Pelayanan</p>
                <p>&nbsp;</p>
                <p style="text-align: center;"><span class="tebal"><strong><?php echo $r['p_pelayanan']; ?></strong></span><br />
                    <?php echo 'NIP. ' . $r['nip_p_pelayanan']; ?></p>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <?php if ($r['nip_mt'] == '198107272005021001') {
                    echo 'Mengetahui';
                    echo '<br>';
                    echo 'Manajer Teknis';
                    echo '<br>';
                    echo '<img src="../../img/ttd/ttdfirhan.png" width="90" height="70"align="" />';
                    echo '<br>';
                    echo '<span class="tebal"><strong>' .
                        $r['mt'] .
                        '</strong></span>';
                    echo '<br>';
                    echo 'NIP. ' . $r['nip_mt'];
                } elseif ($r['nip_mt'] == '198304072005021001') {
                    echo 'Mengetahui';
                    echo '<br>';
                    echo 'Manajer Teknis';
                    echo '<br>';
                    echo '<img src="../../img/ttd/ttdlis.png" width="90" height="70"align="" />';
                    echo '<br>';
                    echo '<span class="tebal"><strong>' .
                        $r['mt'] .
                        '</strong></span>';
                    echo '<br>';
                    echo 'NIP. ' . $r['nip_mt'];
                } elseif ($r['nip_mt'] == '198303022007011001') {
                    echo 'Mengetahui';
                    echo '<br>';
                    echo 'Manajer Teknis';
                    echo '<br>';
                    echo '<img src="../../img/ttd/Ttd_Somingan.png" width="" height="60"align="" />';
                    echo '<br>';
                    echo '<span class="tebal"><strong>' .
                        $r['mt'] .
                        '</strong></span>';
                    echo '<br>';
                    echo 'NIP. ' . $r['nip_mt'];
                } elseif ($r['nip_mt'] == '197812132009121001') {
                    echo 'Mengetahui';
                    echo '<br>';
                    echo 'Manajer Teknis';
                    echo '<br>';
                    echo '<img src="../../img/ttd/fajar_f.png" width="" height="60"align="" />';
                    echo '<br>';
                    echo '<span class="tebal"><strong>' .
                        $r['mt'] .
                        '</strong></span>';
                    echo '<br>';
                    echo 'NIP. ' . $r['nip_mt'];
                } else {
                    echo 'Mengetahui';
                    echo '<br>';
                    echo 'Manajer Teknik';
                    echo '<br>';
                    echo '<br>';
                    echo '<br>';
                    echo '<br>';
                    echo '<br>';
                    echo '<span class="tebal"><strong>' .
                        $r['mt'] .
                        '</strong></span>';
                    echo '<br>';
                    echo 'NIP. ' . $r['nip_mt'];
                } ?>
            </td>
        </tr>
    </table>
</body>

</html>