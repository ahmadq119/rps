<?php
require __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Konfigurasi database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'k12';

$koneksi = new mysqli($host, $username, $password, $database);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mengambil data
    $sql = "SELECT * FROM tb_rps_1 WHERE id = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        die("Data tidak ditemukan.");
    }
} else {
    die("ID tidak ditemukan.");
}

$koneksi->close();

// Buat konten HTML untuk PDF
$html = '
<!DOCTYPE html>
<html>
<head>
    <style>
        th, td {
            padding: 12px;
            text-align: left;
        }
        .head {
            text-align: center;
            margin-bottom: 30px;
            font-size: 20px;
        }
        .header h3 {
            font-family: \'Times New Roman\', Times, serif;
            font-size: 17px;
        }
        img {
            width: 15%;
        }

        .tabel2 {
            margin-top: 50px;
        {
    </style>
</head>
<body>
    <h2 class="head">RENCANA PEMBELAJARAN SEMESTER (RPS)</h2>
    <div class="header">
        <h3>
            Mata Kuliah: ' . htmlspecialchars($row['Matakuliah']) . '<span style="margin-left: 50px">Semester: ' . htmlspecialchars($row['Semester']) . '</span>
            <span style="margin-left:30px">Kode: ' . htmlspecialchars($row['Kode']) . '</span>
            <span style="margin-left:20px">SKS: ' . htmlspecialchars($row['Bobot_(SKS)']) . '</span>
        </h3>
        <h3>
            Jurusan<span style="margin-left: 32px;">: Informatika</span>
            <span style="margin-left: 100px; margin-left:170px">Dosen<span style="margin-left:28px">: ' . htmlspecialchars($row['Dosen']) . '</span></span>
        </h3>
    </div>
    <table style="width:100%; border-collapse: collapse;" border="1">
        <tr>
            <th style="width: 100px; text-align: center; vertical-align: middle; background-color: lightblue;">
                <img src="path/to/inc/logo.png" alt="Logo" style="height: 50px; width: auto; ">
            </th>
            <td style="text-align:center; background-color: lightblue;">UNIVERSITAS MUSAMUS, FAKULTAS TEKNIK, JURUSAN TEKNIK INFORMATIKA</td>
        </tr>
    </table>
    <table style="width:100%; border-collapse: collapse;" border="1">
        <tr>
            <td style="text-align:center;background-color: lightblue; ">RENCANA PEMBELAJARAN SEMESTER</td>
        </tr>
    </table>
    <table style="width:100%; border-collapse: collapse;" border="1">
        <tr>
            <th>Matakuliah</th>
            <th>Kode</th>
            <th>Rumpun MK</th>
            <th>Bobot (SKS)</th>
            <th>Semester</th>
            <th>Tanggal Penyusunan</th>
        </tr>
        <tr>
            <td>' . htmlspecialchars($row['Matakuliah']) . '</td>
            <td>' . htmlspecialchars($row['Kode']) . '</td>
            <td>' . htmlspecialchars($row['Rumpun_MK']) . '</td>
            <td>' . htmlspecialchars($row['Bobot_(SKS)']) . '</td>
            <td>' . htmlspecialchars($row['Semester']) . '</td>
            <td>' . htmlspecialchars($row['Tanggal_penyusunan']) . '</td>
        </tr>
    </table>
    <table style="width:100%; border-collapse: collapse;" border="1">
        <tr>
            <th style="text-align:center; width: 106px;" rowspan="2">OTORISASI</th>
            <td>Pengembangan RPS</td>
            <td>Koordinator MK</td>
            <td>Ketua Prodi</td>
        </tr>
        <tr>
            <td>' . htmlspecialchars($row['Pengembangan_RPS']) . '</td>
            <td>' . htmlspecialchars($row['Koordinator_MK']) . '</td>
            <td>' . htmlspecialchars($row['Ketua_Prodi']) . '</td>
        </tr>
    </table>

    <table style="width:100%; border-collapse: collapse;" border="1">
                    <tr>
                        <th rowspan="2" style="text-align:center; width: 100px;">Capaian Pembelajaran </th>
                        <td style="text-align:center; width: 300px;">(CPL Prodi)</td>
                        <td style="text-align:center; width: 200px;">CP Mata Kuliah (CPMK)</td>
                    </tr>
                    <tr>
                        <td>' . htmlspecialchars($row['CPLP']) . '</td>
                        <td>' . htmlspecialchars($row['CPMK']) . '</td>
                    </tr>
                </table>

    <table style="width:100%; border-collapse: collapse;" border="1">
        <tr> 
            <th style="text-align:center; width: 239px;">Deskripsi Singkat</th>
            <td>' . htmlspecialchars($row['Deskrisi_Singkat_MK']) . '</td>
        </tr>
    </table>
    <table style="width:100%; border-collapse: collapse;" border="1">
        <tr>
            <th style="text-align:center; width: 239px;">Pustaka</th>
            <td>' . htmlspecialchars($row['Pustaka']) . '</td>
        </tr>
    </table>

    <table style="width:100%; border-collapse: collapse;" border="1">
        <tr>
            <th rowspan="2" style="text-align:center; width: 239px;">Media Pembelajaran</th>
            <td>Perangkat lunak (software):</td>
            <td>Perangkat keras (hardware):</td>
        </tr>
        <tr>
            <td>' . htmlspecialchars($row['Sofwer']) . '</td>
            <td>' . htmlspecialchars($row['hardwer']) . '</td>
        </tr>
    </table>

    <table style="width:100%; border-collapse: collapse;" border="1">
        <tr>
            <th style="text-align:center; width: 239px;">Team Teaching</th>
            <td>' . htmlspecialchars($row['Team_Teaching']) . '</td>
        </tr>
    </table>

    <table style="width:100%; border-collapse: collapse;" border="1">
        <tr>
            <th style="text-align:center; width: 239px;">Syarat Matakuliah</th>
            <td>' . htmlspecialchars($row['Matakuliah_Syarat']) . '</td>
        </tr>
    </table>

    
    <div class="tabel2">
                    <table style="width:100%; border-collapse: collapse;   margin-top: 50px;" border="1">
                        <tr>
                            <th rowspan="2" style="text-align:center;background-color: lightblue;">Minggu Ke </th>
                            <th rowspan="2" style="text-align:center;background-color: lightblue;">Sub-CPMK (Kemampuan akhir tiap tahapan belajar)</th>
                            <th rowspan="2" style="text-align:center;background-color: lightblue;">Materi Pembelajaran (Pokok bahasan) [Pustaka]</th>
                            <th rowspan="2" style="text-align:center;background-color: lightblue;">Metode / Strategi Pembelajaran [Estimasi Waktu]</th>
                            <th colspan="3" style="text-align:center;background-color: lightblue;">Assessment</th>

                        <tr>
                            <th style="text-align:center;background-color: lightblue;">Indikator</th>
                            <th style="text-align:center;background-color: lightblue;">Bentuk</th>
                            <th style="text-align:center;background-color: lightblue;">Bobot</th>
                        </tr>

                        <tr>
                            <td class="tg">' . htmlspecialchars($row['1Mg_Ke']) . '</td>
                            <td>' . htmlspecialchars($row['1Sub_CPMK']) . '</td>
                            <td>' . htmlspecialchars($row['1Materi_Pembelajaran']) . '</td>
                            <td>' . htmlspecialchars($row['1Metode']) . '</td>
                            <td>' . htmlspecialchars($row['1Indikator']) . '</td>
                            <td>' . htmlspecialchars($row['1Bentuk']) . '</td>
                            <td>' . htmlspecialchars($row['1Bobot']) . '</td>
                        </tr>

<tr>
    <td>' . htmlspecialchars($row['2Mg_Ke']) . '</td>
    <td>' . htmlspecialchars($row['2Sub_CPMK']) . '</td>
    <td>' . htmlspecialchars($row['2Materi_Pembelajaran']) . '</td>
    <td>' . htmlspecialchars($row['2Metode']) . '</td>
    <td>' . htmlspecialchars($row['2Indikator']) . '</td>
    <td>' . htmlspecialchars($row['2Bentuk']) . '</td>
    <td>' . htmlspecialchars($row['2Bobot']) . '</td>
</tr>
<tr>
    <td>' . htmlspecialchars($row['3Mg_Ke']) . '</td>
    <td>' . htmlspecialchars($row['3Sub_CPMK']) . '</td>
    <td>' . htmlspecialchars($row['3Materi_Pembelajaran']) . '</td>
    <td>' . htmlspecialchars($row['3Metode']) . '</td>
    <td>' . htmlspecialchars($row['3Indikator']) . '</td>
    <td>' . htmlspecialchars($row['3Bentuk']) . '</td>
    <td>' . htmlspecialchars($row['3Bobot']) . '</td>
</tr>
<tr>
    <td>' . htmlspecialchars($row['4Mg_Ke']) . '</td>
    <td>' . htmlspecialchars($row['4Sub_CPMK']) . '</td>
    <td>' . htmlspecialchars($row['4Materi_Pembelajaran']) . '</td>
    <td>' . htmlspecialchars($row['4Metode']) . '</td>
    <td>' . htmlspecialchars($row['4Indikator']) . '</td>
    <td>' . htmlspecialchars($row['4Bentuk']) . '</td>
    <td>' . htmlspecialchars($row['4Bobot']) . '</td>
</tr>
<tr>
    <td>' . htmlspecialchars($row['5Mg_Ke']) . '</td>
    <td>' . htmlspecialchars($row['5Sub_CPMK']) . '</td>
    <td>' . htmlspecialchars($row['5Materi_Pembelajaran']) . '</td>
    <td>' . htmlspecialchars($row['5Metode']) . '</td>
    <td>' . htmlspecialchars($row['5Indikator']) . '</td>
    <td>' . htmlspecialchars($row['5Bentuk']) . '</td>
    <td>' . htmlspecialchars($row['5Bobot']) . '</td>
</tr>
<tr>
    <td>' . htmlspecialchars($row['6Mg_Ke']) . '</td>
    <td>' . htmlspecialchars($row['6Sub_CPMK']) . '</td>
    <td>' . htmlspecialchars($row['6Materi_Pembelajaran']) . '</td>
    <td>' . htmlspecialchars($row['6Metode']) . '</td>
    <td>' . htmlspecialchars($row['6Indikator']) . '</td>
    <td>' . htmlspecialchars($row['6Bentuk']) . '</td>
    <td>' . htmlspecialchars($row['6Bobot']) . '</td>
</tr>
<tr>
    <td>' . htmlspecialchars($row['7Mg_Ke']) . '</td>
    <td>' . htmlspecialchars($row['7Sub_CPMK']) . '</td>
    <td>' . htmlspecialchars($row['7Materi_Pembelajaran']) . '</td>
    <td>' . htmlspecialchars($row['7Metode']) . '</td>
    <td>' . htmlspecialchars($row['7Indikator']) . '</td>
    <td>' . htmlspecialchars($row['7Bentuk']) . '</td>
    <td>' . htmlspecialchars($row['7Bobot']) . '</td>
</tr>
<tr>
    <td>' . htmlspecialchars($row['8Mg_Ke']) . '</td>
    <td>' . htmlspecialchars($row['8Sub_CPMK']) . '</td>
    <td>' . htmlspecialchars($row['8Materi_Pembelajaran']) . '</td>
    <td>' . htmlspecialchars($row['8Metode']) . '</td>
    <td>' . htmlspecialchars($row['8Indikator']) . '</td>
    <td>' . htmlspecialchars($row['8Bentuk']) . '</td>
    <td>' . htmlspecialchars($row['8Bobot']) . '</td>
</tr>
<tr>
    <td>' . htmlspecialchars($row['9Mg_Ke']) . '</td>
    <td>' . htmlspecialchars($row['9Sub_CPMK']) . '</td>
    <td>' . htmlspecialchars($row['9Materi_Pembelajaran']) . '</td>
    <td>' . htmlspecialchars($row['9Metode']) . '</td>
    <td>' . htmlspecialchars($row['9Indikator']) . '</td>
    <td>' . htmlspecialchars($row['9Bentuk']) . '</td>
    <td>' . htmlspecialchars($row['9Bobot']) . '</td>
</tr>
<tr>
    <td>' . htmlspecialchars($row['10Mg_Ke']) . '</td>
    <td>' . htmlspecialchars($row['10Sub_CPMK']) . '</td>
    <td>' . htmlspecialchars($row['10Materi_Pembelajaran']) . '</td>
    <td>' . htmlspecialchars($row['10Metode']) . '</td>
    <td>' . htmlspecialchars($row['10Indikator']) . '</td>
    <td>' . htmlspecialchars($row['10Bentuk']) . '</td>
    <td>' . htmlspecialchars($row['10Bobot']) . '</td>
</tr>
<tr>
    <td>' . htmlspecialchars($row['11Mg_Ke']) . '</td>
    <td>' . htmlspecialchars($row['11Sub_CPMK']) . '</td>
    <td>' . htmlspecialchars($row['11Materi_Pembelajaran']) . '</td>
    <td>' . htmlspecialchars($row['11Metode']) . '</td>
    <td>' . htmlspecialchars($row['11Indikator']) . '</td>
    <td>' . htmlspecialchars($row['11Bentuk']) . '</td>
    <td>' . htmlspecialchars($row['11Bobot']) . '</td>
</tr>
<tr>
    <td>' . htmlspecialchars($row['12Mg_Ke']) . '</td>
    <td>' . htmlspecialchars($row['12Sub_CPMK']) . '</td>
    <td>' . htmlspecialchars($row['12Materi_Pembelajaran']) . '</td>
    <td>' . htmlspecialchars($row['12Metode']) . '</td>
    <td>' . htmlspecialchars($row['12Indikator']) . '</td>
    <td>' . htmlspecialchars($row['12Bentuk']) . '</td>
    <td>' . htmlspecialchars($row['12Bobot']) . '</td>
</tr>
<tr>
    <td>' . htmlspecialchars($row['13Mg_Ke']) . '</td>
    <td>' . htmlspecialchars($row['13Sub_CPMK']) . '</td>
    <td>' . htmlspecialchars($row['13Materi_Pembelajaran']) . '</td>
    <td>' . htmlspecialchars($row['13Metode']) . '</td>
    <td>' . htmlspecialchars($row['13Indikator']) . '</td>
    <td>' . htmlspecialchars($row['13Bentuk']) . '</td>
    <td>' . htmlspecialchars($row['13Bobot']) . '</td>
</tr>
<tr>
    <td>' . htmlspecialchars($row['14Mg_Ke']) . '</td>
    <td>' . htmlspecialchars($row['14Sub_CPMK']) . '</td>
    <td>' . htmlspecialchars($row['14Materi_Pembelajaran']) . '</td>
    <td>' . htmlspecialchars($row['14Metode']) . '</td>
    <td>' . htmlspecialchars($row['14Indikator']) . '</td>
    <td>' . htmlspecialchars($row['14Bentuk']) . '</td>
    <td>' . htmlspecialchars($row['14Bobot']) . '</td>
</tr>
<tr>
    <td>' . htmlspecialchars($row['15Mg_Ke']) . '</td>
    <td>' . htmlspecialchars($row['15Sub_CPMK']) . '</td>
    <td>' . htmlspecialchars($row['15Materi_Pembelajaran']) . '</td>
    <td>' . htmlspecialchars($row['15Metode']) . '</td>
    <td>' . htmlspecialchars($row['15Indikator']) . '</td>
    <td>' . htmlspecialchars($row['15Bentuk']) . '</td>
    <td>' . htmlspecialchars($row['15Bobot']) . '</td>
</tr>
<tr>
    <td>' . htmlspecialchars($row['16Mg_Ke']) . '</td>
    <td>' . htmlspecialchars($row['16Sub_CPMK']) . '</td>
    <td>' . htmlspecialchars($row['16Materi_Pembelajaran']) . '</td>
    <td>' . htmlspecialchars($row['16Metode']) . '</td>
    <td>' . htmlspecialchars($row['16Indikator']) . '</td>
    <td>' . htmlspecialchars($row['16Bentuk']) . '</td>
    <td>' . htmlspecialchars($row['16Bobot']) . '</td>
</tr>

                    </table>
                </div>





                <h2 class="head" style="margin-top: 100px;">RENCANA TUGAS</h2>
    <div class="header">
        <h3>
            Mata Kuliah: ' . htmlspecialchars($row['Matakuliah']) . '<span style="margin-left: 50px">Semester: ' . htmlspecialchars($row['Semester']) . '</span>
            <span style="margin-left:30px">Kode: ' . htmlspecialchars($row['Kode']) . '</span>
            <span style="margin-left:20px">SKS: ' . htmlspecialchars($row['Bobot_(SKS)']) . '</span>
        </h3>
        <h3>
            Jurusan<span style="margin-left: 32px;">: Informatika</span>
            <span style="margin-left: 100px; margin-left:170px">Dosen<span style="margin-left:28px">: ' . htmlspecialchars($row['Dosen']) . '</span></span>
        </h3>
    </div>

    <h3 style="font-size: 15px; margin-top:30px">Tugas Sesuai Pokok Bahasan</h3>

<table style="width:100%; border-collapse: collapse;" border="1">
    <tr>
        <th>Capaian Pembelajaran MK :</th>
    </tr>
    <tr>
        <td>' . htmlspecialchars($row['Capaian']) . '</td>
    </tr>
</table>

<table style="width:100%; border-collapse: collapse;" border="1">
    <tr>
        <th rowspan="2" style="width: 200px;" >Uraian Tugas</th>
        <th>Objek garapan</th>
        <th>Aktivitas</th>
        <th>Metodologi & Cara pengerjaannya</th>
        <th>Kriteria luaran tugas yang dihasilkan</th>
    </tr>
    <tr>
        <td>' . htmlspecialchars($row['Obyek']) . '</td>
        <td>' . htmlspecialchars($row['Aktivitas']) . '</td>
        <td>' . htmlspecialchars($row['Metodologi']) . '</td>
        <td>' . htmlspecialchars($row['Kriteria_tugas']) . '</td>
    </tr>

    </table>
                    <table style="width:100%; border-collapse: collapse;" border="1">
                        <tr>
                            <th style="width: 200px;">Jadwal Pelaksanaan</th>
                            <td>' . htmlspecialchars($row['Jadwal']) . '</td>
                        </tr>
                    </table>
                </div>
</table>




</body>
</html>
';

// Konfigurasi Dompdf
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

// Load HTML ke Dompdf
$dompdf->loadHtml($html);

// Set ukuran dan orientasi kertas
$dompdf->setPaper('A4', 'portrait');

// Render HTML menjadi PDF
$dompdf->render();

// Kirim PDF ke browser
$dompdf->stream("RPS_" . $row['Matakuliah'] . ".pdf", ["Attachment" => false]);
exit;
