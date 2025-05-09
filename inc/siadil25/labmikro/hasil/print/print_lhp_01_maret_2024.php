<style>
    table {
        border: solid 0px #5544DD;
        border-collapse: collapse;
        font-size: 10px;
    }

    table td {
        font-size: 10;
        height: 10px;
    }

    table th {
        height: 30px;
        padding: 0 0 0 5px;
        text-align: center;
    }

    div.judul {
        font-size: 14px;
        font-weight: bold;
    }

    div.tebal {
        font-weight: bold;
    }

    div.label {
        font-size: 10px;
        font-style: italic;
    }

    .tengah {
        text-align: center;
    }

    .ratakirikanan {
        text-align: justify;
    }

    .tulisankecil {
        font-size: 10px;
    }

    div.conthead {
        font-size: 12px;
    }

    div.conthead table th {
        font-size: 14px;
    }

    div.conthead table td {
        font-size: 12px;
        text-align: left;
    }
</style>

<page backtop="37mm">
    <page_header>
        <div class="conthead">
            <table width="200" border="1">
                <tr>
                    <td rowspan="4" width="100" align="center" valign="middle"><img src="../../img/bppmhkp.png" width="100" align="center" /></td>
                    <td rowspan="2" width="300" align="center" valign="middle">
                        <h2>FORMULIR KERJA</h2>
                    </td>
                    <td>No. Dokumen</td>
                    <td>: FK 8.12.5b/OK/SKI-MM</td>
                </tr>
                <tr>
                    <td width="80">Edisi/Revisi/tgl</td>
                    <td width="150">: 01/04/01 Maret 2024</td>
                </tr>
                <tr>
                    <th rowspan="2" align="center" valign="middle" width="300">LAMPIRAN HASIL PENGUJIAN BAKTERI</th>
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
    //include 'fungsi_indotgl.php';
    session_start();
    $ruangid = $_SESSION['ruangid'];
    ?>
    <br>
    <div class="judul">
        <p align="center">LAMPIRAN HASIL PENGUJIAN BAKTERI</p>
    </div>
    <div class="judul">
        <p>A. Informasi Umum</p>
    </div>
    <?php
    $query = "SELECT 
    kd_sample,
    no_reg,
    STUFF((
        SELECT DISTINCT ', ' + target_pengujian
        FROM View_penerimaan_sample_mikrobiologi AS sub
        WHERE sub.kd_sample = main.kd_sample
        FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 2, '') AS target_pengujian,
    STUFF((
        SELECT DISTINCT ', ' + acuan
        FROM View_penerimaan_sample_mikrobiologi AS sub
        WHERE sub.kd_sample = main.kd_sample
        FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 2, '') AS acuan,
    nama_ruang,
    tgl_terima,
    tgl_uji,
    tgl_hasil,
    idmtd_isolasi,
    metode_isolasi,
    bahan,
    suhu_inkubasi,
    hasil_isolasi_awal,
    nama_bakteri_ditemukan,
    metode_pengujian,
    idpeg_analis,
    idpeg_penyelia,
    analis,
    nip_analis,
    penyelia,
    nip_penyelia,
    nama_sample,
    jumlah,
    satuan,
    panjang,
    berat,
    no_reg,
    tgl_terima_dipelayanan,
    tgl_harus_uji,
    sts_terima,
    nama_mt,
    nip_mt
FROM View_penerimaan_sample_mikrobiologi AS main
WHERE kd_sample = ?
GROUP BY 
    kd_sample, no_reg, nama_ruang, tgl_terima, tgl_uji, tgl_hasil, 
    idmtd_isolasi, metode_isolasi, bahan, suhu_inkubasi, hasil_isolasi_awal, 
    nama_bakteri_ditemukan, metode_pengujian, idpeg_analis, idpeg_penyelia, 
    analis, nip_analis, penyelia, nip_penyelia, nama_sample, jumlah, satuan, 
    panjang, berat, no_reg, tgl_terima_dipelayanan, tgl_harus_uji, sts_terima,
    nama_mt, nip_mt";

    $stmt = sqlsrv_query($koneksi, $query, [$_GET['kd_sample']]);
    while ($r = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) { ?>
        <table width="500" border="0">
            <tr>
                <td width="150">No. Reg </td>
                <td width="250">: <?= $r['no_reg']; ?></td>
                <td width="100">Pemeriksa </td>
                <td>: <?= $r['analis']; ?></td>
            </tr>
            <tr>
                <td width="150">Kode Sampel </td>
                <td width="250">: <?= $r['kd_sample']; ?></td>
                <td width="100">Paraf </td>
                <td>: .....................</td>
            </tr>
            <tr>
                <td width="150">Nama Sampel </td>
                <td width="250">: <?= $r['nama_sample']; ?></td>
                <td width="100"> </td>
                <td></td>
            </tr>
            <tr>
                <td width="150">Jumlah Sampel </td>
                <td width="250">: <?= $r['jumlah']; ?> <?= $r['satuan']; ?></td>
                <td width="100"> </td>
                <td></td>
            </tr>
            <tr>
                <td width="150">Panjang </td>
                <td width="250">: <?= $r['panjang']; ?></td>
                <td width="100"></td>
                <td></td>
            </tr>
            <tr>
                <td width="150">Berat </td>
                <td width="250">: <?= $r['berat']; ?></td>
                <td width="100"> </td>
                <td></td>
            </tr>
            <tr>
                <td width="150">Tanggal Terima Sample </td>
                <td width="250">: <?php echo date_format(
                                        $r['tgl_terima'],
                                        'd-m-Y'
                                    ); ?></td>
                <td width="100"> </td>
                <td></td>
            </tr>
            <tr>
                <td width="150">Tanggal Pengujian </td>
                <td width="250">: <?php echo date_format(
                                        $r['tgl_uji'],
                                        'd-m-Y'
                                    ); ?></td>
                <td width="100"> </td>
                <td></td>
            </tr>
        </table>

        <div class="judul">
            <p>B. Preparasi Awal Bakteri</p>
        </div>
        <table width="500" border="0">
            <tr>
                <td width="170">1. Metode Isolasi</td>
                <td width="510">: <?= $r['metode_isolasi']; ?></td>
            </tr>
            <tr>
                <td width="170">2. Bahan yang digunakan</td>
                <td width="150">: <?= $r['bahan']; ?></td>
            </tr>
            <tr>
                <td width="170">3. Suhu inkubasi</td>
                <td width="150">: <?= $r['suhu_inkubasi']; ?> &deg;C</td>
            </tr>
            <tr>
                <td width="170">4. Hasil isolasi awal</td>
                <td width="150">: <?= $r['hasil_isolasi_awal']; ?></td>
            </tr>
        </table>
        <!--i style="font-size:9px">Keterangan : *) Beri tanda centang pada pilihan yang sesuai</i-->
        <br>
        <div class="judul">
            <p>C. Hasil Pengujian</p>
        </div>
        <table width="500" border="0">
            <tr>
                <td width="180">1. Metode Pengujian)</td>
                <td width="500">: <?= $r['metode_pengujian']; ?></td>
            </tr>
            <tr>
                <td>2. Acuan Dokumen Terakreditasi</td>
                <td width="500">: <?= $r['acuan']; ?></td>
            </tr>
            <tr>
                <td>3. Kontrol Positif</td>
                <td>:</td>
            </tr>
            <tr>
                <td>3. Hasil identifikasi</td>
                <td>: &#32;<?= $r['nama_bakteri_ditemukan']; ?></td>
            </tr>

        </table>
        <!--tABEL ISI--->
        <table width="688" border="1">
            <thead>
                <tr>
                    <td width="20" valign="middle">No</td>
                    <td width="112" valign="middle">Parameter yang diuji</td>
                    <td width="89" valign="middle">Hasil Sample</td>
                    <td width="140" align="center" valign="middle">IKM 8.2.1</td>
                    <td width="140" align="center" valign="middle">IKM 8.2.3</td>
                    <td width="140" align="center" valign="middle">IKM 8.2.8</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="20" valign="middle">&nbsp;</td>
                    <td width="112" valign="middle">&nbsp;</td>
                    <td width="89" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle"><em>Salmonella sp</em></td>
                    <td width="140" align="center" valign="middle"><em>Escherchia coli</em></td>
                    <td width="140" align="center" valign="middle"><em>Vibrio parahaemolyticus</em></td>
                </tr>
                <tr>
                    <td width="20" valign="middle">1</td>
                    <td width="112" valign="middle">Warna dan Bentuk Koloni</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">Krem</td>
                    <td width="140" align="center" valign="middle">Krem</td>
                    <td width="140" align="center" valign="middle">Krem</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">2</td>
                    <td width="112" valign="middle">BSA</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">+</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">3</td>
                    <td width="112" valign="middle">HE AGAR</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">+</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">4</td>
                    <td width="112" valign="middle">XLD AGAR</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">+</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">5</td>
                    <td width="112" valign="middle">LEMB</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle"></td>
                    <td width="140" align="center" valign="middle">+</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">6</td>
                    <td width="112" valign="middle">Mc. Conkey</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">7</td>
                    <td width="112" valign="middle">Uji GRAM</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">-</td>
                    <td width="140" align="center" valign="middle">-</td>
                    <td width="140" align="center" valign="middle">-</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">8</td>
                    <td width="112" valign="middle">Bentuk Sel</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">Batang Pendek</td>
                    <td width="140" align="center" valign="middle">Batang pendek</td>
                    <td width="140" align="center" valign="middle">Batang melengkung</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">9</td>
                    <td width="112" valign="middle">Katalase</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">-</td>
                    <td width="140" align="center" valign="middle">+</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">10</td>
                    <td width="112" valign="middle">Oksidase</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">+</td>
                    <td width="140" align="center" valign="middle">-</td>
                    <td width="140" align="center" valign="middle">+</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">11</td>
                    <td width="112" valign="middle">Oksidase - Fermentatif (OF)</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">F</td>
                    <td width="140" align="center" valign="middle">F</td>
                    <td width="140" align="center" valign="middle">O atau F</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">12</td>
                    <td width="112" valign="middle">Motility</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">+</td>
                    <td width="140" align="center" valign="middle">+</td>
                    <td width="140" align="center" valign="middle">+</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">13</td>
                    <td width="112" valign="middle">Motility 30°C</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">14</td>
                    <td width="112" valign="middle">Media rimler-Shoots</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">15</td>
                    <td width="112" valign="middle">TSIA</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">Alkalin/Asam</td>
                    <td width="140" align="center" valign="middle">Asam/Asam</td>
                    <td width="140" align="center" valign="middle">A/K</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">16</td>
                    <td width="112" valign="middle">Indole</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">-</td>
                    <td width="140" align="center" valign="middle">V</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">17</td>
                    <td width="112" valign="middle">Metil Red</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">+</td>
                    <td width="140" align="center" valign="middle">+</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">18</td>
                    <td width="112" valign="middle">Voges Proskuler</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">-</td>
                    <td width="140" align="center" valign="middle">-</td>
                    <td width="140" align="center" valign="middle">-</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">19</td>
                    <td width="112" valign="middle">Citrat</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">v</td>
                    <td width="140" align="center" valign="middle">-</td>
                    <td width="140" align="center" valign="middle">+</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">20</td>
                    <td width="112" valign="middle">Urease</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">-</td>
                    <td width="140" align="center" valign="middle">-</td>
                    <td width="140" align="center" valign="middle">-</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">21</td>
                    <td width="112" valign="middle">Ornithin</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">+</td>
                    <td width="140" align="center" valign="middle">V</td>
                    <td width="140" align="center" valign="middle">+</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">22</td>
                    <td width="112" valign="middle">Lysin Decarboxilase</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">+</td>
                    <td width="140" align="center" valign="middle">+</td>
                    <td width="140" align="center" valign="middle">+</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">23</td>
                    <td width="112" valign="middle">Lysin Diaminase</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">24</td>
                    <td width="112" valign="middle">KCN</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">-</td>
                    <td width="140" align="center" valign="middle">-</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">25</td>
                    <td width="112" valign="middle">Reduksi Nitrat</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">+</td>
                    <td width="140" align="center" valign="middle">+</td>
                    <td width="140" align="center" valign="middle">+</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">26</td>
                    <td width="112" valign="middle">Produksi Gas</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">+</td>
                    <td width="140" align="center" valign="middle">+</td>
                    <td width="140" align="center" valign="middle">+</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">27</td>
                    <td width="112" valign="middle">produksi H2S</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">+</td>
                    <td width="140" align="center" valign="middle">-</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">28</td>
                    <td width="112" valign="middle">Gelatin</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">+</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">29</td>
                    <td width="112" valign="middle">Arginin Dihidrolase</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">+</td>
                    <td width="140" align="center" valign="middle">-</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">30</td>
                    <td width="112" valign="middle">TSA 37°C</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">31</td>
                    <td width="112" valign="middle">TSA NaCL 4%</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">32</td>
                    <td width="112" valign="middle">Trehalose</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">+</td>
                    <td width="140" align="center" valign="middle">+</td>
                    <td width="140" align="center" valign="middle">+</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">33</td>
                    <td width="112" valign="middle">Malonate</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">-</td>
                    <td width="140" align="center" valign="middle">-</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">34</td>
                    <td width="112" valign="middle">Glucose</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">+</td>
                    <td width="140" align="center" valign="middle">+</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">35</td>
                    <td width="112" valign="middle">Sucrose</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">+</td>
                    <td width="140" align="center" valign="middle">-</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">36</td>
                    <td width="112" valign="middle">Lactose</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">-</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">37</td>
                    <td width="112" valign="middle">Maltose</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">+</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">38</td>
                    <td width="112" valign="middle">Xylose</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">+</td>
                    <td width="140" align="center" valign="middle">-</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">39</td>
                    <td width="112" valign="middle">Arabinose</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">+</td>
                    <td width="140" align="center" valign="middle">-</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">40</td>
                    <td width="112" valign="middle">Sorbitol</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">-</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">41</td>
                    <td width="112" valign="middle">Inositol</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">42</td>
                    <td width="112" valign="middle">Mannitol</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">-</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">43</td>
                    <td width="112" valign="middle">Dulcitol</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">+</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">44</td>
                    <td width="112" valign="middle">Rafinose</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">45</td>
                    <td width="112" valign="middle">Haemolisis</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">46</td>
                    <td width="112" valign="middle">Aesculin Hydrolysis</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">47</td>
                    <td width="112" valign="middle">Bile Salt 40%</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">48</td>
                    <td width="112" valign="middle">EIM Medium</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">49</td>
                    <td width="112" valign="middle">Facultative Anaerob</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">50</td>
                    <td width="112" valign="middle">TCBS</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">+</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">51</td>
                    <td width="112" valign="middle"><img src="../../img/betha.JPG" height="10" align="center" />-galactosidase (ONPG)</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" valign="middle">52</td>
                    <td width="112" valign="middle">Aesculin hydrolisis</td>
                    <td width="89" valign="middle"></td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                    <td width="140" align="center" valign="middle">&nbsp;</td>
                </tr>
            </tbody>
        </table>
        <br>
        <br>
        <table align="center" border="1">
            <tr>
                <td width="200" align="center"><?= date_format($r['tgl_hasil'], 'd-m-Y'); ?></td align="center">
                <td width="100" align="center">Tanggal Verifikasi</td>
                <td width="200" align="center"><?= date_format($r['tgl_hasil'], 'd-m-Y'); ?></td>
            </tr>
            <tr>
                <td align="center">Manajer Teknis</td>
                <td align="center">Diverifikasi oleh<br>(Fungsi Personel)</td>
                <td align="center">Penyelia/Analis</td>
            </tr>
            <tr>
                <td height="60" align="center" valign="bottom">
                    <?php
                    if ($r['nip_mt'] == '197812132009121001') {
                        echo '<img src="../img/ttd/fajar_f.png" width="" height="60"align="" />';
                        echo '<br>';
                        echo '<strong>' . $r['nama_mt'] . '</strong>';
                        echo '<br>';
                        echo 'NIP ' . $r['nip_mt'];
                    } else {
                        echo '<br>';
                        echo '<br>';
                        echo '<br>';
                        echo '<br>';
                        echo '<strong>' . $r['nama_mt'] . '</strong>';
                        echo '<br>';
                        echo 'NIP ' . $r['nip_mt'];
                    }
                    ?>

                </td>
                <td align="center"></td>
                <td height="60" align="center" valign="bottom">
                    <?php
                    if ($r['nip_penyelia'] == '197812132009121001') {
                        echo '<img src="../img/ttd/fajar_f.png" width="" height="60"align="" />';
                        echo '<br>';
                        echo '<strong>' . $r['penyelia'] . '</strong>';
                        echo '<br>';
                        echo 'NIP ' . $r['nip_penyelia'];
                    } else {
                        echo '<br>';
                        echo '<br>';
                        echo '<br>';
                        echo '<br>';
                        echo '<strong>' . $r['penyelia'] . '</strong>';
                        echo '<br>';
                        echo 'NIP ' . $r['nip_penyelia'];
                    }
                    ?>

                </td>
            </tr>
        </table>
    <?php } ?>
    <page_footer></page_footer>
</page>