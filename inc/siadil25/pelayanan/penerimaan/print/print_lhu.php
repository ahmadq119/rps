<style>
    table {
        border: solid 1px black;
        border-collapse: collapse
    }

    table.tblket {
        border: solid 1px black;
        border-collapse: collapse;
        font-size: 8px;
    }

    table th {
        font-size: 12px;
        text-align: center;
        height: 20px;
    }

    table td {
        font-size: 10px;
    }

    table td.td1 {
        font-size: 9px;
    }

    div.container {
        width: 170px;
        height: 100px;
        font-size: 12px;
    }

    div.judul {
        font-size: 12px;
        font-weight: bold;
    }

    div.tebal {
        font-size: 12px;
        font-weight: bold;
    }

    div.subjudul {
        font-size: 12px;
    }

    div.label {
        font-size: 9px;
    }

    div.conthead {
        margin-left: 55px;
        font-size: 12px;
    }

    div.conthead table th {
        font-size: 14px;
    }

    div.conthead table td {
        font-size: 12px;
    }
</style>
<page backtop="35mm" backbottom="5mm" backleft="10mm" backright="10mm">
    <page_header>
        <div class="conthead">
            <table width="200" border="1">
                <tr>
                    <td rowspan="4" width="100" align="center" valign="middle"><img src="./img/bppmhkp.png" width="100" height="60" align="center" /></td>
                    <td rowspan="2" width="300" align="center" valign="middle">
                        <h2>FORMULIR KERJA</h2>
                    </td>
                    <td>No. Dokumen</td>
                    <td>: FK 8.12.7/OK/SKI-MM</td>
                </tr>
                <tr>
                    <td width="80">Edisi/Revisi/tgl</td>
                    <td width="150">: 01/04/01 Maret 2024</td>
                </tr>
                <tr>
                    <th rowspan="2" align="center" valign="middle" width="300">LAPORAN HASIL UJI</th>
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
    <page_footer></page_footer>
    <?php
    include '../include/config.php';
    $sql1 =
        "
SELECT DISTINCT
  tb_disposisi.no_disposisi,
  tb_registrasi.tgl_reg,
  tb_disposisi.tgl_disp,
  tb_disposisi.tgl_lhu,
  tb_registrasi.idmtd,
  tbl_metode.nama_metode,
  tb_registrasi.acuan,
  tbl_acuan_akreditasi.nama_acuan,
  tb_penerimaan_sample.tgl_terima,
  tb_penerimaan_sample.kd_sample,
  tb_penerimaan_sample.no_reg,
  tb_nama_sample.nm_sample,
  tb_registrasi.panjang,
  tb_registrasi.berat,
  tb_registrasi.ph,
  tb_registrasi.suhu,
  tb_registrasi.salinitas,
  tb_registrasi.sejarah,
  histori.keterangan,
  tb_customer.nama_customer,
  tb_customer.alamat,
  tb_penandatangan_lhu.nama AS contact_person
FROM
  tb_disposisi,
  tb_penerimaan_sample,
  tb_nama_sample,
  tb_registrasi,
  tbl_metode,
  tbl_acuan_akreditasi,
  histori,
  tb_customer,
  tb_penandatangan_lhu
WHERE
  tb_penerimaan_sample.idsample = tb_nama_sample.idsample AND
  tb_penerimaan_sample.kd_sample = tb_registrasi.kd_sample AND
  tb_registrasi.kd_sample = tb_disposisi.kd_sample AND
  tb_registrasi.idmtd = tbl_metode.idmtd AND
  tb_registrasi.acuan = tbl_acuan_akreditasi.acuan AND
  tb_registrasi.sejarah = histori.sejarah AND
  tb_penerimaan_sample.idcus = tb_customer.idcus AND
  tb_penerimaan_sample.kd_sample = tb_penandatangan_lhu.kd_sample AND 
  tb_penerimaan_sample.kd_sample = '" .
        $_REQUEST['kd_sample'] .
        "'";

    $query = sqlsrv_query($dbconnect, $sql1);
    $data = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    if ($data['idmtd'] == 1) {
        $acak = "<img src='./img/check-box.png' width='15' height='15'>";
    } else {
        $acak = "<img src='./img/box.png' width='15' height='15'>";
    }
    if ($data['idmtd'] == 2) {
        $prev = "<img src='./img/check-box.png' width='15' height='15'>";
    } else {
        $prev = "<img src='./img/box.png' width='15' height='15'>";
    }
    if ($data['acuan'] == 1) {
        $acn511 = "<img src='./img/check-box.png' width='15' height='15'>";
    } else {
        $acn511 = "<img src='./img/box.png' width='15' height='15'>";
    }
    if ($data['acuan'] == 2) {
        $acn512 = "<img src='./img/check-box.png' width='15' height='15'>";
    } else {
        $acn512 = "<img src='./img/box.png' width='15' height='15'>";
    }
    if ($data['sejarah'] == 1) {
        $ws = "<img src='./img/check-box.png' width='15' height='15'>";
    } else {
        $ws = "<img src='./img/box.png' width='15' height='15'>";
    }
    if ($data['sejarah'] == 2) {
        $cs = "<img src='./img/check-box.png' width='15' height='15'>";
    } else {
        $cs = "<img src='./img/box.png' width='15' height='15'>";
    }
    ?>
    <div class="judul">
        <p align="center"><u>LAPORAN HASIL UJI</u><br />
            <i style="font-size:11px">Refort of Analysis</i>
        </p>
    </div>
    <div class="subjudul" align="center"> <strong>Nomor : <?php echo $data['no_reg']; ?></strong> </div>
    <div class="subjudul" align="center">Tanggal Laporan : <strong><?php echo date_format(
                                                                        $data['tgl_lhu'],
                                                                        'd-m-Y'
                                                                    ); ?></strong><br />
        <i style="font-size:11px">Date of Report&#32;&#32;&#32;&#32;&#32;&#32;&#32;&#32;&#32;&#32;&#32;&#32;&#32;&#32;&#32;&#32;&#32;&#32;</i>
    </div>
    <table width="600" border="0">
        <tr>
            <td width="180"><u>Nama Customer</u> <br />
                <i>Customer Name</i>
            </td>
            <td colspan="3">: <strong><?php echo strtoupper(
                                            $data['nama_customer']
                                        ); ?></strong></td>
        </tr>
        <tr>
            <td><u>Pejabat yang dihubungi</u> <br />
                <i>Contact Person</i>
            </td>
            <td colspan="3">: <strong><?php echo $data['contact_person']; ?></strong></td>
        </tr>
        <tr>
            <td><u>Alamat Customer</u> <br />
                <i>Address of Customer</i>
            </td>
            <td colspan="3">: <strong><?php echo $data['alamat']; ?></strong></td>
        </tr>
        <tr>
            <td><u>Tanggal Terima Contoh</u> <br />
                <i>Date of Receive Sampel</i>
            </td>
            <td width="180">: <strong><?php echo date_format(
                                            $data['tgl_terima'],
                                            'd-m-Y'
                                        ); ?></strong></td>
            <td width="180"><u>Tanggal Pengujian Contoh</u> <br />
                <i>Date of Testing Sampel</i>
            </td>
            <td width="160">: <strong><?php echo date_format(
                                            $data['tgl_disp'],
                                            'd-m-Y'
                                        ); ?></strong></td>
        </tr>
    </table>
    <br />
    <table width="600" border="1">
        <tr>
            <td colspan="4" align="center"><u><strong>I. Data Pendukung</strong></u> <br />
                <i>Supporting of data sample</i>
            </td>
        </tr>
        <tr>
            <td width="180"><u>Tanggal Pengambilan Contoh</u> <br />
                <i>Date of Removal Sampel</i>
            </td>
            <td colspan="3">: <?php echo date_format(
                                    $data['tgl_terima'],
                                    'd-m-Y'
                                ); ?></td>
        </tr>
        <tr>
            <td><u>Metode Pengambilan Contoh</u> <br />
                <i>Method of Removal Sampel</i>
            </td>
            <td width="180">
                <table>
                    <tr>
                        <td><?php echo $acak; ?></td>
                        <td><u>Acak</u> <br />
                            <i>Random</i>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="180">
                <table>
                    <tr>
                        <td><?php echo $prev; ?></td>
                        <td><u>Statistik Nilai Prevalensi</u> <br />
                            <i>Statistic Value of Prevalence</i>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="150">&nbsp;</td>
        </tr>
        <tr>
            <td><u>Acuan Pengambilan Contoh</u> <br />
                <i>Reference of Removal Sampel</i>
            </td>
            <td>
                <table>
                    <tr>
                        <td><?php echo $acn511; ?></td>
                        <td>IKP/8.4.1/SKI-MM ; Sub point 5.1.1</td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <td><?php echo $acn512; ?></td>
                        <td>IKP/8.4.1/SKI-MM ; Sub point 5.1.2</td>
                    </tr>
                </table>
            </td>
            <td>&nbsp;</td>
        </tr>
    </table>
    <table width="600" border="1">
        <tr>
            <td rowspan="2"><u>Kode Contoh</u> <br />
                <i>Code of Sample</i>
            </td>
            <td rowspan="2"><u>Jenis Contoh</u> <br />
                <i>Type of Sample</i>
            </td>
            <td colspan="2"><u>Ukuran Contoh</u> <br />
                <i>Size of Sample</i>
            </td>
            <td rowspan="2" width="120"><u>Target Organ/Gejala Klinis</u> <br />
                <i>Target of Organ/Clinical Sign</i>
            </td>
            <td colspan="3"><u>Kondisi Lingkungan</u> <br />
                <i>Environmental Condition</i>
            </td>
            <td colspan="2"><u>Sejarah</u> <br />
                <i>History</i>
            </td>
        </tr>
        <tr>
            <td><u>Panjang</u> <br />
                <i>Lenght</i>
            </td>
            <td><u>Berat</u> <br />
                Weight</td>
            <td>pH</td>
            <td>Suhu</td>
            <td>Salinity</td>
            <td width="30">Wild Stock</td>
            <td width="30">Culture Stock</td>
        </tr>
        <tr>
            <td width="100" height="30"><?php echo $data['kd_sample']; ?></td>
            <td width="100"><?php echo $data['nm_sample']; ?></td>
            <td width="70"><?php echo $data['panjang']; ?></td>
            <td width="70"><?php echo $data['berat']; ?></td>
            <td width="100">
                <?php
                $sqlorg =
                    "SELECT DISTINCT kd_sample, organ_target = substring ((SELECT ', ' + nama_organ FROM v_organ_target S2
			WHERE S2.kd_sample = S1.kd_sample FOR XML path(''), elements), 3, 500)
			FROM v_organ_target S1
			WHERE S1.kd_sample = '" .
                    $_REQUEST['kd_sample'] .
                    "' ";
                $qrorg = sqlsrv_query($dbconnect, $sqlorg);
                while (
                    $dtorg = sqlsrv_fetch_array($qrorg, SQLSRV_FETCH_ASSOC)
                ) {
                    echo $dtorg['organ_target'];
                }
                ?>
            </td>
            <td width="50"><?php echo $data['ph']; ?></td>
            <td width="50"><?php echo $data['suhu']; ?></td>
            <td><?php echo $data['salinitas']; ?></td>
            <td align="center"><?php echo $ws; ?></td>
            <td align="center"><?php echo $cs; ?></td>
        </tr>
    </table>
    <br>
    <table width="600" border="1">
        <tr>
            <td colspan="7" align="center"><u><strong>II. Hasil Pengujian</strong></u> <br />
                <i>Test Result</i>
            </td>
        </tr>
        <tr>
            <td align="center">No</td>
            <td align="center"><u>Kode Contoh</u> <br />
                <i>Code of Sample</i>
            </td>
            <td align="center"><u>Jenis Contoh</u> <br />
                <i>Type of Sample</i>
            </td>
            <td align="center" width="80"><u>Target Pengujian</u> <br />
                <i>Target of Testing</i>
            </td>
            <td align="center"><u>Hasil Pengujian</u> <br />
                <i>Test Result</i>
            </td>
            <td width="100" align="center"><u>Spesifikasi Metode</u> <br />
                <i>Specification of Methode</i>
            </td>
            <td width="100" align="center"><u>Acuan Standard Metode yang Terakreditasi</u> <br />
                <i>Standard Reference of acreditation</i>
            </td>
        </tr>
        <?php
        $sqllhu =
            "SELECT DISTINCT * FROM v_hasil_pengujian WHERE kd_sample='" .
            $_REQUEST['kd_sample'] .
            "'";
        $query = sqlsrv_query($dbconnect, $sqllhu);
        $no = 1;
        //$rowcount=sqlsrv_num_rows($query);
        while ($dtlhu = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) { ?>
            <tr>
                <td width="15" height="20" align="center"><?php echo $no++; ?></td>
                <td width="90"><?php echo $dtlhu['kd_sample']; ?></td>
                <td width="100"><?php echo $dtlhu['nm_sample']; ?></td>
                <td width="80" align="center"><?php echo $dtlhu['target_uji']; ?></td>
                <td width="190"><?php echo $dtlhu['organ_target']; ?>: <i><?php echo $dtlhu['hasil_uji']; ?></i></td>
                <td width="100"><?php echo $dtlhu['spesifikasi_metode']; ?></td>
                <td width="100"><?php echo $dtlhu['acuan_standart']; ?></td>
            </tr>
        <?php }
        ?>
    </table>
    <br />
    <table width="600" border="1">
        <?php
        $sqlkes = sqlsrv_query(
            $dbconnect,
            "SELECT DISTINCT * FROM tb_kesimpulan_lhus Where kd_sample = '" .
                $_REQUEST['kd_sample'] .
                "'"
        );
        while ($rkes = sqlsrv_fetch_array($sqlkes, SQLSRV_FETCH_ASSOC)) { ?>
            <tr>
                <td colspan="3" align="center"><u><strong>III. Kesimpulan/Saran/Rekomendasi</strong></u> <br />
                    <i>Conclution/Sugestion/Recomendation</i>
                </td>
            </tr>
            <tr>
                <td width="15" valign="top">1.</td>
                <td width="150" valign="top"><u>Kesimpulan</u> <br />
                    <i>Conclution</i>
                </td>
                <td width="530"><?php echo $rkes['kesimpulan']; ?></td>
            </tr>
            <tr>
                <td valign="top">2.</td>
                <td valign="top"><u>Saran/Rekomendasi</u> <br />
                    <i>Suggestion/Recomendation</i>
                </td>
                <td><?php echo $rkes['rekomendasi']; ?></td>
            </tr>
        <?php }
        ?>
    </table>
    <table width="600" border="0">
        <tr>
            <td colspan="2" valign="top"><u><strong>Catatan :</strong></u> <br />
                <i>Note</i>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td width="15" valign="top" class="td1">1.</td>
            <td width="450" valign="top" class="td1"><u>Hasil uji ini hanya berlaku untuk contoh yang diuji;</u> <br />
                <i>This analitycal result are only valid for the tested sample</i>
            </td>
            <td rowspan="4" width="230" align="center">
                <div class="container" align="center">
                    <span class="td1">
                        <?php
                        $sql = sqlsrv_query(
                            $dbconnect,
                            "SELECT DISTINCT * FROM tb_penandatangan_lhu Where kd_sample = '" .
                                $_REQUEST['kd_sample'] .
                                "'"
                        );
                        while (
                            $row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)
                        ) {
                            if ($row['nip'] == '198107272005021001') {
                                echo 'Merauke, ' .
                                    date_format($row['tanggal_lhus'], 'd-m-Y');
                                echo '<br>';
                                echo '<img src="./img/ttd/ttdfirhan.png" height="60"align="" />';
                                echo '<br>';
                                echo '<strong>' . $row['nama'] . '</strong>';
                                echo '<br>';
                                echo 'NIP ' . $row['nip'];
                            } elseif ($row['nip'] == '198304072005021001') {
                                echo 'Merauke, ' .
                                    date_format($row['tanggal_lhus'], 'd-m-Y');
                                echo '<br>';
                                echo '<img src="./img/ttd/ttdlis.png" width="" height="60"align="" />';
                                echo '<br>';
                                echo '<strong>' . $row['nama'] . '</strong>';
                                echo '<br>';
                                echo 'NIP ' . $row['nip'];
                            } elseif ($row['nip'] == '198303022007011001') {
                                echo 'Merauke, ' .
                                    date_format($row['tanggal_lhus'], 'd-m-Y');
                                echo '<br>';
                                echo '<img src="../img/ttd/Ttd_Somingan.png" width="" height="60"align="" />';
                                echo '<br>';
                                echo '<strong>' . $row['nama'] . '</strong>';
                                echo '<br>';
                                echo 'NIP ' . $row['nip'];
                            } elseif ($row['nip'] == '197812132009121001') {
                                echo 'Merauke, ' .
                                    date_format($row['tanggal_lhus'], 'd-m-Y');
                                echo '<br>';
                                echo '<img src="../img/ttd/fajar_f.png" width="" height="60"align="" />';
                                echo '<br>';
                                echo '<strong>' . $row['nama'] . '</strong>';
                                echo '<br>';
                                echo 'NIP ' . $row['nip'];
                            } else {
                                echo 'Merauke, ' .
                                    date_format($row['tanggal_lhus'], 'd-m-Y');
                                echo '<br>';
                                echo '<br>';
                                echo '<br>';
                                echo '<br>';
                                echo '<br>';
                                echo '<strong>' . $row['nama'] . '</strong>';
                                echo '<br>';
                                echo 'NIP ' . $row['nip'];
                            }
                        }
                        ?>
                    </span>
                </div>
            </td>
        </tr>
        <tr>
            <td valign="top" class="td1">2.</td>
            <td width="450" valign="top" class="td1"><u>Laporan Hasil Uji ini terdiri dari 1 (satu) lembar asli (Stempel asli);</u> <br />
                <i>This report of analysis consist of 1 (one) page original (oroginal sign)</i>
            </td>
        </tr>
        <tr>
            <td valign="top" class="td1">3.</td>
            <td width="450" valign="top" class="td1"><u>Laporan Hasil Uji ini tidak boleh digandakan, kecuali secara lengkap dan seijin tertulis dari Ka. SKIPM Merauke dengan stempel copy;</u> <br />
                <i>This Test Result Report may not be duplicated, except in full and with written permission from Ka. SKIPM Merauke with copy stamp</i>
            </td>
        </tr>
        <tr>
            <td valign="top" class="td1">4.</td>
            <td width="450" valign="top" class="td1"><u>Hasil Pengujian Terlampir</u> <br />
                <i>Test Results Attached</i>
            </td>
        </tr>
        <tr>
            <td colspan="3"><u><strong>Dasar Hukum</strong></u> <br />
                <i>Reference of regulation</i>
            </td>
        </tr>
        <tr>
            <td valign="top" class="td1">1.</td>
            <td width="450" valign="top" class="td1">Undang-undang No. 21/2019 tentang Karantina Ikan, Hewan dan Tumbuhan;</td>
            <td width="230">&nbsp;</td>
        </tr>
        <tr>
            <td valign="top" class="td1">2.</td>
            <td width="450" valign="top" class="td1">PP no. 15/2002 tentang Karantina Ikan;</td>
            <td width="230">&nbsp;</td>
        </tr>
        <tr>
            <td valign="top" class="td1">3.</td>
            <td width="450" valign="top" class="td1">PP No. 85/2021 tentang Perubahan Penerimaan Negara Bukan Pajak di Kemeterian Kelautan dan Perikanan;</td>
            <td width="230">&nbsp;</td>
        </tr>
        <tr class="label">
            <td valign="top" class="td1">4.</td>
            <td width="450" valign="top" class="td1">KEPMEN KP No. 17/KEPMEN-KP/2021 tentang Penetapan Jenis-Jenis Penyakit Ikan Karantina, Golongan, dan Media Pembawa.</td>
            <td width="230">&nbsp;</td>
        </tr>
    </table>
    <div class="label">
        <p align="center"><strong>Register Laboratorium terakreditasi/Ruang Lingkup Akreditasi : LP-550-IDN</strong><br />
            Pengujian <i>Aeromonas hydrophila</i>, Pengujian <i>Streptococcus iniae</i>, Pengujian <i>Edwarsiella ictalurii</i>, <br />
            Pengujian Taura Syndrome Virus (TSV),
            Pengujian <i>Salmonella sp.</i>, Pengujian <i>Escherichia coli</i>, <br />Pengujian Koi Herpes Virus (KHV), Pengujian White Spot Syndrome Virus (WSSV)</p>
    </div>
</page>