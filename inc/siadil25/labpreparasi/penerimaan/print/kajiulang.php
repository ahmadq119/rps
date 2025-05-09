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
                <th rowspan="2" align="center" valign="middle" width="300">KAJI ULANG PERMINTAAN, TENDER DAN KONTRAK</th>
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
    <p style="text-align: center; font-weight:bold;">KAJI ULANG PERMINTAAN/PERMOHONAN UNTUK PENGUJIAN</p>
    <br>
    <?php
    $sql = "select * from view_penerimaan_sample where kd_sample='" . $_GET['kd_sample'] . "'";
    $query = sqlsrv_query($koneksi, $sql);
    while ($r = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
    ?>
        <div class="conthead">
            <p>Nomor Registrasi : <?= $r['no_reg']; ?></p>
            <p>Tanggal Penerimaan : <?= date_format($r['tgl_terima'], 'd-m-Y'); ?></p>
            <table width="600" border="0">
                <tr>
                    <td width="15"><strong>A.</strong></td>
                    <td colspan="4"><strong>Informasi Permintaan Uji</strong></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td width="12">1.</td>
                    <td width="200">Nama Pelanggan / Customer</td>
                    <td width="3">:</td>
                    <td width="410"><?= $r['nama_customer']; ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>2.</td>
                    <td>Alamat</td>
                    <td>:</td>
                    <td><?= $r['alamat_customer']; ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>3.</td>
                    <td>Contact</td>
                    <td>:</td>
                    <td>..............</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>4.</td>
                    <td>Jenis Sampel</td>
                    <td>:</td>
                    <td><?= $r['nama_sample']; ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>5.</td>
                    <td>Jumlah Sampel</td>
                    <td>:</td>
                    <td><?= $r['jumlah']; ?> <?= $r['satuan']; ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>6.</td>
                    <td>Tanggal Permintaan Uji</td>
                    <td>:</td>
                    <td><?= date_format($r['tgl_terima'], 'd-m-Y'); ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>7.</td>
                    <td>Tanggal Terima Sampel</td>
                    <td>:</td>
                    <td><?= date_format($r['tgl_terima'], 'd-m-Y'); ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>8</td>
                    <td>Nomor Sampel</td>
                    <td>:</td>
                    <td><?= $r['kd_sample']; ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><strong>B.</strong></td>
                    <td colspan="4"><strong>Detail Permintaan Uji</strong></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>1.</td>
                    <td>Parameter yang diminta</td>
                    <td>:</td>
                    <td>
                        <p>
                            [...] <em>Salmonella sp.</em> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[...] Formalin
                        </p>
                        <p>
                            [...] <em>Eschericia coli</em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[...] Organoleptik
                        </p>
                        <p>
                            [...] <em>Vibrio parahaemolyticus</em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[...] Angka Lempeng Total
                        </p>
                        <p>
                            Parameter lain: __________________________________________
                        </p>
                    </td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td>2.</td>
                    <td>Tujuan Pengujian</td>
                    <td>:</td>
                    <td><!--?= $r['asal_sampel']; ?--></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>3.</td>
                    <td>Metode Pengujian</td>
                    <td>:</td>
                    <td>
                        <p>[...] Biokimia &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[...] PCR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[...] Sensori &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[...] Konvensional</p>
                        <p>[...] Mikroskopis &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [...] Test kit/kolorimetri</p>
                        <p>Lainnya: __________________________________________</p>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><strong>C.</strong></td>
                    <td colspan="4"><strong> Kaji Ulang Teknis</strong></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>1.</td>
                    <td>Kelengkapan dan Kejelasan Informasi</td>
                    <td>:</td>
                    <td>
                        <p>[...] Lengkap dan Jelas</p>
                        <p>[...] Tidak Lengkap / Tidak Jelas</p>
                        <p>Catatan: __________________________________________</p>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>2.</td>
                    <td width="200">Kesesuaian Sampel dengan Metode Uji</td>
                    <td>:</td>
                    <td>
                        <p>[...] Sesuai</p>
                        <p>[...] Tidak Sesuai</p>
                        <p>Catatan: __________________________________________</p>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>3.</td>
                    <td width="200">Kemampuan Laboratorium untuk Melakukan Uji</td>
                    <td>:</td>
                    <td>
                        <p>[...] Memenuhi</p>
                        <p>[...] Tidak Memenuhi</p>
                        <p>Catatan: __________________________________________</p>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>4.</td>
                    <td width="200">Kebutuhan Sumberdaya Tambahan (Alat, Bahan, Waktu, Tenaga, dll)</td>
                    <td>:</td>
                    <td>
                        <p>[...] Memenuhi</p>
                        <p>[...] Tidak Memenuhi</p>
                        <p>Catatan: __________________________________________</p>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>5.</td>
                    <td>Catatan atau Saran dari Tim Kaji Ulang</td>
                    <td>:</td>
                    <td>
                        <p>Catatan: __________________________________________</p>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><strong>D.</strong></td>
                    <td colspan="4"><strong> Keputusan Kaji Ulang</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td>1.</td>
                    <td>Status Permintaan Uji</td>
                    <td>:</td>
                    <td>
                        <p>[...] Diterima &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[...] Ditolak &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[...] Perlu Perbaikan</p>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>2.</td>
                    <td>Alasan Penolakan/Perbaikan (jika ada)</td>
                    <td>:</td>
                    <td>
                        <p>Catatan: __________________________________________</p>
                        <p>_________________________________________________</p>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: center;">
                        <br><br>
                        Tanda Tangan dan Persetujuan:<br>
                        Manajer Teknis<br>
                        <?php
                        if ($r['nip_mt'] == '198107272005021001') {
                            echo 'Merauke, ' .
                                date_format($r['tgl_terima'], 'd-m-Y');
                            echo '<br>';
                            echo '<img src="../../img/ttd/ttdfirhan.png" height="60"align="" />';
                            echo '<br>';
                            echo '<strong>' . $r['mt'] . '</strong>';
                            echo '<br>';
                            echo 'NIP ' . $r['nip_mt'];
                        } elseif ($r['nip_mt'] == '198304072005021001') {
                            echo 'Merauke, ' .
                                date_format($r['tgl_terima'], 'd-m-Y');
                            echo '<br>';
                            echo '<img src="../../img/ttd/ttdlis.png" width="" height="60"align="" />';
                            echo '<br>';
                            echo '<strong>' . $r['mt'] . '</strong>';
                            echo '<br>';
                            echo 'NIP ' . $r['nip_mt'];
                        } elseif ($r['nip_mt'] == '198303022007011001') {
                            echo 'Merauke, ' .
                                date_format($r['tgl_terima'], 'd-m-Y');
                            echo '<br>';
                            echo '<img src="../../img/ttd/Ttd_Somingan.png" width="" height="60"align="" />';
                            echo '<br>';
                            echo '<strong>' . $r['mt'] . '</strong>';
                            echo '<br>';
                            echo 'NIP ' . $r['nip_mt'];
                        } elseif ($r['nip_mt'] == '197812132009121001') {
                            echo 'Merauke, ' .
                                date_format($r['tgl_terima'], 'd-m-Y');
                            echo '<br>';
                            echo '<img src="../../img/ttd/fajar_f.png" width="" height="60"align="" />';
                            echo '<br>';
                            echo '<strong>' . $r['mt'] . '</strong>';
                            echo '<br>';
                            echo 'NIP ' . $r['nip_mt'];
                        } else {
                            echo 'Merauke, ' .
                                date_format($r['tgl_terima'], 'd-m-Y');
                            echo '<br>';
                            echo '<br>';
                            echo '<br>';
                            echo '<br>';
                            echo '<br>';
                            echo '<strong>' . $r['mt'] . '</strong>';
                            echo '<br>';
                            echo 'NIP ' . $r['nip_mt'];
                        }

                        ?>
                    </td>
                </tr>
            </table>
            <table>

            </table>
        </div>
    <?php } ?>

</body>

</html>
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
        margin-left: 10px;
        font-size: 12px;
    }

    div.conthead table th {
        font-size: 14px;
    }

    div.conthead table td {
        font-size: 12px;
    }

    p {
        margin: 3px 0;
    }
</style>