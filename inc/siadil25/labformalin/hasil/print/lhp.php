<style>
    div.body {
        font-size: 11px;
    }

    table {
        border: solid 1px black;
        border-collapse: collapse
    }

    table th {
        font-size: 11px;
        text-align: center;
        height: 15px;
    }

    table td {
        font-size: 11px;
    }

    div.container {
        width: 300px;
        height: 150px;
    }

    div.judul {
        font-size: 14px;
        font-weight: bold;
    }

    div.tebal {
        font-size: 11px;
        font-weight: bold;
    }

    div.label {
        font-size: 11px;
        font-weight: bold;
    }
</style>

<page>
    <page_header>
    </page_header>
    <page_footer>
        <hr>
        <!--table "border: solid 0px #5544DD; border-collapse: collapse" align="center">
            <tr>
                <td style="border: 0px; text-align: left;    width: 15%">Page<br>Tanggal Terbit<br>Revisi</td>
				<td style="border: 0px; text-align: left;    width: 65%">: [[page_cu]]/[[page_nb]]<br>: 30 September 2013<br>: 4</td>
                <td style="border: 0px; text-align: right;    width: 20%">F/5.8.3a/SKI-MM</td>
            </tr>
        </table-->
        <table "border: solid 0px #5544DD; border-collapse: collapse" align="right">
            <tr>
                <td style="border: 0px; text-align: right;">[[page_cu]] of [[page_nb]]</td>
            </tr>
        </table>
    </page_footer>
    <?php
    include '../../login/config.php';
    //include 'fungsi_indotgl.php';
    session_start();
    $ruangid = $_SESSION['ruangid'];
    ?>

    <table style="border: solid 0px #5544DD; border-collapse: collapse" align="center">
        <tr>
            <td rowspan="5" style="border:0px; width: 15%; align: right"><img src="../../img/lgkkp.png" width="80" height="80" /></td>
            <td style="border:0px; font-size:12px; text-align: left;    width: 75%"><strong>KEMENTERIAN KELAUTAN DAN PERIKANAN</strong></td>
            <td rowspan="4" ; style="border:0px; width: 10%; align: right"></td>
        </tr>
        <tr>
            <td style="border:0px; font-size:12px; text-align: left;    width: 75%"><strong>BADAN PENGENDALIAN DAN PENGAWASAN MUTU HASIL KELAUTAN DAN PERIKANAN</strong></td>
        </tr>
        <tr>
            <td style="border:0px; font-size:13px; text-align: left;    width: 75%"><strong>STASIUN KARANTINA IKAN, PENGENDALIAN MUTU</strong></td>
        </tr>
        <tr>
            <td style="border:0px; font-size:13px; text-align: left;    width: 75%"><strong>DAN KEAMANAN HASIL PERIKANAN MERAUKE</strong></td>
        </tr>
        <tr>
            <td style="border:0px; font-size:13px; text-align: left;    width: 75%"><strong>LABORATORIUM UJI</strong></td>
        </tr>
        <br>
        <hr>
    </table>
    <br>
    <div class="judul">
        <p align="center">LAMPIRAN HASIL PENGUJIAN<br>MUTU DAN KEAMANAN HASIL PERIKANAN</p>
    </div>
    <br>
    <?php
    $kd_sample = $_REQUEST['kd_sample'];
    $sql = "SELECT * FROM view_penerimaan_sample_labformalin WHERE kd_sample='$kd_sample'";
    $sql1 = sqlsrv_query($koneksi, $sql);
    while ($r = sqlsrv_fetch_array($sql1, SQLSRV_FETCH_ASSOC)) { ?>

        <table width="550" border="1">
            <tr>
                <td width="100">No. Reg </td>
                <td width="300">: <?php echo $r['no_reg']; ?></td>
                <td width="150">Tanggal Terima Sampel </td>
                <td width="130">: <?php echo date_format($r['tgl_terima'], "d-m-Y"); ?></td>
            </tr>
            <tr>
                <td>Kode Sampel </td>
                <td>: <?php echo $r['kd_sample']; ?></td>
                <td>Tanggal Pengujian </td>
                <td>: <?php echo date_format($r['tgl_uji'], "d-m-Y"); ?></td>
            </tr>
        </table>
        <br>
        <table width="670" border="1">
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Jenis Komoditi</th>
                <th rowspan="2">Kode Sampel</th>
                <th rowspan="2">Jumlah</th>
                <th colspan="2">Ukuran</th>
                <th rowspan="2">Kondisi</th>
            </tr>
            <tr>
                <th>Panjang</th>
                <th>Berat</th>
            </tr>

            <tr>
                <td width="30" height="20" align="center">1</td>
                <td width="110"><?php echo $r['nama_sample']; ?></td>
                <td width="110"><?php echo $r['kd_sample']; ?></td>
                <td width="70" align="center"><?php echo $r['jumlah']; ?> <?php echo $r['satuan']; ?></td>
                <td width="120" align="center"><?php echo $r['panjang']; ?></td>
                <td width="120" align="center"><?php echo $r['berat']; ?></td>
                <td width="100"><?php echo $r['kondisi_sample']; ?></td>
            </tr>

        </table>
        <br>
        <table width="670" border="1">
            <tr>
                <th>No</th>
                <th>Jenis Pengujian</th>
                <th>Metode Pengujian</th>
                <th>Keterangan</th>
            </tr>

            <tr>
                <td width="30" height="20" align="center">1</td>
                <td width="200">Pengujian Kandungan Formalin</td>
                <td width="270"><?php echo $r['metode_pengujian']; ?></td>
                <td width="180" align="center"><!--img src='../img/centang-standard.png' width='10' height='10'--></td>
            </tr>
        </table>
        <br>
        <strong>A. HASIL PENGUJIAN KANDUNGAN FORMALIN</strong>
        <table width="670" border="1">
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Jenis Komoditi</th>
                <th rowspan="2">Kode Sampel</th>
                <th colspan="2">Uji Kandungan Formalin</th>
                <th rowspan="2">Kesimpulan</th>
            </tr>
            <tr>
                <th>Negatif</th>
                <th>Positif</th>
            </tr>

            <tr>
                <td width="30" height="20" align="center">1</td>
                <td width="110"><?php echo $r['nama_sample']; ?></td>
                <td width="110"><?php echo $r['kd_sample']; ?></td>
                <td width="120" align="center">

                    <?php
                    $hasil_pengujian = $r['hasil_pengujian'];

                    if (strpos(strtolower($hasil_pengujian), 'negatif') !== false) {
                        echo "✅"; // Tanda silang untuk negatif
                    } else {
                        echo "❌";
                    }
                    ?>

                </td>
                <td width="120" align="center">
                    <?php
                    $hasil_pengujian = $r['hasil_pengujian'];

                    if (strpos(strtolower($hasil_pengujian), 'positif') !== false) {
                        echo "✅"; // Tanda centang untuk positif
                    } else {
                        echo "❌";
                    }
                    ?>
                </td>
                <td width="175" align="center">
                    <?= $r['hasil_pengujian']; ?>
                </td>
            </tr>

        </table>

        <br>
        <div class="label">
            - Kandungan formalin pada bahan pangan tidak diperbolehkan pada taraf apapun.
        </div>
        <br>
        <strong>B. GAMBAR HASIL UJI</strong>
        <table width="670" border="1">
            <tr>
                <th>Uji Kandungan Formalin</th>
                <th>Keterangan</th>
            </tr>
            <tr>
                <td width="450">
                    <p align="center"><img src="../../file_labformalin/<?= $r['nama_file']; ?>" width="400" /></p>


                </td>
                <td width="240"><?= $r['ket_file']; ?></td>
            </tr>
        </table>

        <br>
        <div class="label"><em>Ket : Lampiran hasil pengujian ini hanya mewakili sampel yang diuji</em></div>
        <br>
        <br>

        <table align="center" border="0">
            <tr>
                <td width="200" align="center">
                    Mengetahui,<br>Manajer Teknik
                </td align="center">
                <td width="100" align="center"></td>
                <td width="200" align="center">Merauke, <?= date_format($r['tgl_hasil'], "d-m-Y"); ?><br>Petugas Pemeriksa</td>
            </tr>
            <tr>
                <td height="50" align="center"></td>
                <td width="100" align="center"></td>
                <td width="200" align="center"></td>
            </tr>
            <tr>
                <td width="200" align="center">
                    <?= $r['nama_mt'] . '<br>' . $r['nip_mt']; ?>
                </td align="center">
                <td width="100" align="center"></td>
                <td width="200" align="center">
                    <?= $r['nama_pegawai'] . '<br>' . $r['nip_pegawai']; ?>
                </td>
            </tr>
        </table>';
    <?php } ?>

</page>