<?php
// Koneksi ke database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'k12';

$koneksi = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mengambil data RPS berdasarkan id
    $sql = "SELECT * FROM tb_rps_1 WHERE id = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika data ditemukan
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<p>Data tidak ditemukan.</p>";
    }
} else {
    echo "<p>ID tidak ditemukan.</p>";
}

// Tutup koneksi
$koneksi->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Dosen</title>
  
  <style>
 /* General Reset */
 * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      display: flex;
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
      height: 100vh;
    }

    /* Sidebar Styles */
    .sidebar {
      width: 250px;
      background-color: #343a40;
      color: white;
      padding: 20px;
      display: flex;
      flex-direction: column;
    }

    .sidebar h4 {
      margin-bottom: 20px;
    }

    .sidebar a {
      color: white;
      text-decoration: none;
      padding: 10px;
      margin: 10px 0;
      border-radius: 5px;
      display: block;
    }

    .sidebar a:hover {
      background-color: #495057;
    }

    .dropdown-btn {
      background: none;
      border: none;
      color: white;
      padding: 10px;
      width: 100%;
      text-align: left;
      cursor: pointer;
      border-radius: 5px;
    }

    .dropdown-btn:hover {
      background-color: #495057;
    }

    .dropdown-menu {
      display: none;
      margin-top: 5px;
      padding: 0;
      list-style: none;
      background-color: #495057;
      border-radius: 5px;
    }

    .dropdown-menu a {
      color: white;
      padding: 10px;
      text-decoration: none;
      display: block;
    }

    .dropdown-menu a:hover {
      background-color: #6c757d;
    }

    .dropdown-menu.active {
      display: block;
    }
.main-content {
  padding: 20px;
}
.card {
  border-radius: 10px;
}
.approved {
  background-color: green;
  color: white;
  padding: 10px;
  text-align: center;
  border-radius: 5px;
}
.rejected {
  background-color: red;
  color: white;
  padding: 10px;
  text-align: center;
  border-radius: 5px;
}


.main-content {
            display: flex;
            flex-direction: column;
            padding: 20px;
            overflow-y: auto;
            /* Tambahkan scrollbar vertikal */
            height: 90vh;
            /* Batasi tinggi agar pas dengan layar */
        }


        h1 {
            margin-bottom: 30px;
        }



        th,
        td {
            padding: 12px;
            text-align: left;
        }


        .btn {
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background-color: #4CAF50;
            color: white;
        }

        .btn-edit:hover {
            background-color: #45a049;
        }

        .btn-hapus {
            background-color: #e53e3e;
            color: white;
        }

        .btn-hapus:hover {
            background-color: #c53030;
        }

        .btn-preview {
            background-color: #3182ce;
            color: white;
        }

        .btn-preview:hover {
            background-color: #2b6cb0;
        }

        .btn-balik {
            background-color: darkgrey;
            color: white;
        }

        .btn-balik:hover {
            background-color: lightgray;
        }

        .head {
            text-align: center;
            margin-bottom: 30px;
            font-size: 20px;
        }

        .header h3 {
            font-family: 'Times New Roman', Times, serif;
            font-size: 17px;
        }

        

        img {
            width: 15%;
        }

        .tabel2 {
            margin-top: 30px;
        }

        .tabel2 th {
            text-align: center;
        }

        .tg {
            text-align: center;
        }

        .tabel2 table tr th {
            background-color: lightblue;
        }

</style>
</head>
<body>
  


    <!-- Main Content -->
    <main class="main-content">
            <h1>Preview RPS</h1>
            <?php if (isset($row)) { ?>


                <h2 class="head">RENCANA PEMBELAJARAN SEMESTER (RPS)</h2>
                <div class="header">
                    <h3>
                        Mata Kuliah : <?= $row['Matakuliah'] ?><span style="margin-left: 116px">Semester : <?= $row['Semester'] ?> </span> <span style="margin-left:100px">Kode : <?= $row['Kode'] ?></span> <span style="margin-left:100px">SKS : <?= $row['Bobot_(SKS)'] ?></span>
                    </h3>
                    <h3>
                        Jurusan <span style="margin-left: 32px;">: Informatika</span> <span style="margin-left: 100px; margin-left:170px">Dosen <span style="margin-left:28px"> : <?= $row['Dosen'] ?></span> </span>
                    </h3>
                </div>



                <table style='width:100%; border-collapse: collapse;' border='1'>
                    <tr>
                        <th style="width: 100px; text-align: center; vertical-align: middle;background-color: lightblue;">
                            <img src="logo.png" alt="Logo" style="height: 50px; width: auto;">
                        </th>
                        <td style="text-align:center;background-color: lightblue;">UNIVERSITAS MUSAMUS, FAKULTAS TEKNIK, JURUSAN TEKNIK INFORMATIKA</td>
                    </tr>
                </table>

                <table style='width:100%; border-collapse: collapse;background-color: lightblue;' border='1'>
                    <tr>
                        <td style="text-align:center">RENCANA PEMBELAJARAN SEMESTER</td>
                    </tr>
                </table>

                <table style='width:100%; border-collapse: collapse;' border='1'>
                    <tr>
                        <th>Matakuliah</th>
                        <th>Kode</th>
                        <th>Rumpun MK</th>
                        <th>Bobot (SKS)</th>
                        <th>Semester</th>
                        <th>Tanggal Penyusunan</th>
                    </tr>
                    <tr>
                        <td><?= $row['Matakuliah'] ?></td>
                        <td><?= $row['Kode'] ?></td>
                        <td><?= $row['Rumpun_MK'] ?></td>
                        <td><?= $row['Bobot_(SKS)'] ?></td>
                        <td><?= $row['Semester'] ?></td>
                        <td><?= $row['Tanggal_penyusunan'] ?></td>
                    </tr>
                </table>



                <table style='width:100%; border-collapse: collapse;' border='1'>
                    <tr>
                        <th style="text-align:center; width: 239px;" rowspan="2">OTORISASI</th>
                        <td>Pengembangan RPS</td>
                        <td>Koordinator MK</td>
                        <td>Ketua Prodi</td>
                    </tr>
                    <tr>
                        <td><?= $row['Pengembangan_RPS'] ?></td>
                        <td><?= $row['Koordinator_MK'] ?></td>
                        <td><?= $row['Ketua_Prodi'] ?></td>

                    </tr>
                </table>

                <table style='width:100%; border-collapse: collapse;' border='1'>
                    <tr>
                        <th rowspan="2" style="text-align:center; width: 239px;">Capaian Pembelajaran </th>
                        <td>(CPL Prodi)</td>
                        <td>CP Mata Kuliah (CPMK)</td>
                    </tr>
                    <tr>
                        <td><?= $row['CPLP'] ?></td>
                        <td><?= $row['CPMK'] ?></td>
                    </tr>
                </table>

                <table style='width:100%; border-collapse: collapse;' border='1'>
                    <tr>
                        <th style="text-align:center; width: 239px;">Deskripsi Singkat</th>
                        <td><?= $row['Deskrisi_Singkat_MK'] ?></td>
                    </tr>
                </table>

                <table style='width:100%; border-collapse: collapse;' border='1'>
                    <tr>
                        <th style="text-align:center; width: 239px;">Pustaka</th>
                        <td><?= $row['Pustaka'] ?></td>
                    </tr>
                </table>

                <table style='width:100%; border-collapse: collapse;' border='1'>
                    <tr>
                        <th rowspan="2" style="text-align:center; width: 239px;">Media Pembelajaran</th>
                        <td>Perangkat lunak (software):</td>
                        <td>Perangkat keras (hardware):</td>
                    </tr>
                    <tr>
                        <td><?= $row['Sofwer'] ?></td>
                        <td><?= $row['hardwer'] ?></td>
                    </tr>
                </table>

                <table style='width:100%; border-collapse: collapse;' border='1'>
                    <tr>
                        <th style="text-align:center; width: 239px;">Team Teaching</th>
                        <td><?= $row['Team_Teaching'] ?></td>
                    </tr>
                </table>

                <table style='width:100%; border-collapse: collapse;' border='1'>
                    <tr>
                        <th style="text-align:center; width: 239px;">Syarat Matakuliah</th>
                        <td><?= $row['Matakuliah_Syarat'] ?></td>

                    </tr>

                </table>

                <div class="tabel2">
                    <table style='width:100%; border-collapse: collapse;' border='1'>
                        <tr>
                            <th rowspan="2" style="text-align:center;">Minggu Ke </th>
                            <th rowspan="2" style="text-align:center;">Sub-CPMK (Kemampuan akhir tiap tahapan belajar)</th>
                            <th rowspan="2" style="text-align:center;">Materi Pembelajaran (Pokok bahasan) [Pustaka]</th>
                            <th rowspan="2" style="text-align:center;">Metode / Strategi Pembelajaran [Estimasi Waktu]</th>
                            <th colspan="3" style="text-align:center;">Assessment</th>

                        <tr>
                            <th>Indikator</th>
                            <th>Bentuk</th>
                            <th>Bobot</th>
                        </tr>

                        <tr>
                            <td class="tg"><?= $row['1Mg_Ke'] ?></td>
                            <td><?= $row['1Sub_CPMK'] ?></td>
                            <td><?= $row['1Materi_Pembelajaran'] ?></td>
                            <td><?= $row['1Metode'] ?></td>
                            <td><?= $row['1Indikator'] ?></td>
                            <td><?= $row['1Bentuk'] ?></td>
                            <td><?= $row['1Bobot'] ?></td>
                        </tr>

                        <tr>
                            <td class="tg"><?= $row['2Mg_Ke'] ?></td>
                            <td><?= $row['2Sub_CPMK'] ?></td>
                            <td><?= $row['2Materi_Pembelajaran'] ?></td>
                            <td><?= $row['2Metode'] ?></td>
                            <td><?= $row['2Indikator'] ?></td>
                            <td><?= $row['2Bentuk'] ?></td>
                            <td><?= $row['2Bobot'] ?></td>
                        </tr>
                        <tr>
                            <td class="tg"><?= $row['3Mg_Ke'] ?></td>
                            <td><?= $row['3Sub_CPMK'] ?></td>
                            <td><?= $row['3Materi_Pembelajaran'] ?></td>
                            <td><?= $row['3Metode'] ?></td>
                            <td><?= $row['3Indikator'] ?></td>
                            <td><?= $row['3Bentuk'] ?></td>
                            <td><?= $row['3Bobot'] ?></td>
                        </tr>
                        <tr>
                            <td class="tg"><?= $row['4Mg_Ke'] ?></td>
                            <td><?= $row['4Sub_CPMK'] ?></td>
                            <td><?= $row['4Materi_Pembelajaran'] ?></td>
                            <td><?= $row['4Metode'] ?></td>
                            <td><?= $row['4Indikator'] ?></td>
                            <td><?= $row['4Bentuk'] ?></td>
                            <td><?= $row['4Bobot'] ?></td>
                        </tr>
                        <tr>
                            <td class="tg"><?= $row['5Mg_Ke'] ?></td>
                            <td><?= $row['5Sub_CPMK'] ?></td>
                            <td><?= $row['5Materi_Pembelajaran'] ?></td>
                            <td><?= $row['5Metode'] ?></td>
                            <td><?= $row['5Indikator'] ?></td>
                            <td><?= $row['5Bentuk'] ?></td>
                            <td><?= $row['5Bobot'] ?></td>
                        </tr>
                        <tr>
                            <td class="tg"><?= $row['6Mg_Ke'] ?></td>
                            <td><?= $row['6Sub_CPMK'] ?></td>
                            <td><?= $row['6Materi_Pembelajaran'] ?></td>
                            <td><?= $row['6Metode'] ?></td>
                            <td><?= $row['6Indikator'] ?></td>
                            <td><?= $row['6Bentuk'] ?></td>
                            <td><?= $row['6Bobot'] ?></td>
                        </tr>
                        <tr>
                            <td class="tg"><?= $row['7Mg_Ke'] ?></td>
                            <td><?= $row['7Sub_CPMK'] ?></td>
                            <td><?= $row['7Materi_Pembelajaran'] ?></td>
                            <td><?= $row['7Metode'] ?></td>
                            <td><?= $row['7Indikator'] ?></td>
                            <td><?= $row['7Bentuk'] ?></td>
                            <td><?= $row['7Bobot'] ?></td>
                        </tr>
                        <tr>
                            <td class="tg"><?= $row['8Mg_Ke'] ?></td>
                            <td><?= $row['8Sub_CPMK'] ?></td>
                            <td><?= $row['8Materi_Pembelajaran'] ?></td>
                            <td><?= $row['8Metode'] ?></td>
                            <td><?= $row['8Indikator'] ?></td>
                            <td><?= $row['8Bentuk'] ?></td>
                            <td><?= $row['8Bobot'] ?></td>
                        </tr>
                        <tr>
                            <td class="tg"><?= $row['9Mg_Ke'] ?></td>
                            <td><?= $row['9Sub_CPMK'] ?></td>
                            <td><?= $row['9Materi_Pembelajaran'] ?></td>
                            <td><?= $row['9Metode'] ?></td>
                            <td><?= $row['9Indikator'] ?></td>
                            <td><?= $row['9Bentuk'] ?></td>
                            <td><?= $row['9Bobot'] ?></td>
                        </tr>
                        <tr>
                            <td class="tg"><?= $row['10Mg_Ke'] ?></td>
                            <td><?= $row['10Sub_CPMK'] ?></td>
                            <td><?= $row['10Materi_Pembelajaran'] ?></td>
                            <td><?= $row['10Metode'] ?></td>
                            <td><?= $row['10Indikator'] ?></td>
                            <td><?= $row['10Bentuk'] ?></td>
                            <td><?= $row['10Bobot'] ?></td>
                        </tr>
                        <tr>
                            <td class="tg"><?= $row['11Mg_Ke'] ?></td>
                            <td><?= $row['11Sub_CPMK'] ?></td>
                            <td><?= $row['11Materi_Pembelajaran'] ?></td>
                            <td><?= $row['11Metode'] ?></td>
                            <td><?= $row['11Indikator'] ?></td>
                            <td><?= $row['11Bentuk'] ?></td>
                            <td><?= $row['11Bobot'] ?></td>
                        </tr>
                        <tr>
                            <td class="tg"><?= $row['12Mg_Ke'] ?></td>
                            <td><?= $row['12Sub_CPMK'] ?></td>
                            <td><?= $row['12Materi_Pembelajaran'] ?></td>
                            <td><?= $row['12Metode'] ?></td>
                            <td><?= $row['12Indikator'] ?></td>
                            <td><?= $row['12Bentuk'] ?></td>
                            <td><?= $row['12Bobot'] ?></td>
                        </tr>
                        <tr>
                            <td class="tg"><?= $row['13Mg_Ke'] ?></td>
                            <td><?= $row['13Sub_CPMK'] ?></td>
                            <td><?= $row['13Materi_Pembelajaran'] ?></td>
                            <td><?= $row['13Metode'] ?></td>
                            <td><?= $row['13Indikator'] ?></td>
                            <td><?= $row['13Bentuk'] ?></td>
                            <td><?= $row['13Bobot'] ?></td>
                        </tr>
                        <tr>
                            <td class="tg"><?= $row['14Mg_Ke'] ?></td>
                            <td><?= $row['14Sub_CPMK'] ?></td>
                            <td><?= $row['14Materi_Pembelajaran'] ?></td>
                            <td><?= $row['14Metode'] ?></td>
                            <td><?= $row['14Indikator'] ?></td>
                            <td><?= $row['14Bentuk'] ?></td>
                            <td><?= $row['14Bobot'] ?></td>
                        </tr>
                        <tr>
                            <td class="tg"><?= $row['15Mg_Ke'] ?></td>
                            <td><?= $row['15Sub_CPMK'] ?></td>
                            <td><?= $row['15Materi_Pembelajaran'] ?></td>
                            <td><?= $row['15Metode'] ?></td>
                            <td><?= $row['15Indikator'] ?></td>
                            <td><?= $row['15Bentuk'] ?></td>
                            <td><?= $row['15Bobot'] ?></td>
                        </tr>
                        <tr>
                            <td class="tg"><?= $row['16Mg_Ke'] ?></td>
                            <td><?= $row['16Sub_CPMK'] ?></td>
                            <td><?= $row['16Materi_Pembelajaran'] ?></td>
                            <td><?= $row['16Metode'] ?></td>
                            <td><?= $row['16Indikator'] ?></td>
                            <td><?= $row['16Bentuk'] ?></td>
                            <td><?= $row['16Bobot'] ?></td>
                        </tr>


                    </table>
                </div>

                <div style="margin-top: 80px;">
                    <h2 class="head">Rencana Tugas</h2>
                    <div class="header">
                        <h3>
                            Mata Kuliah : <?= $row['Matakuliah'] ?><span style="margin-left: 116px">Semester : <?= $row['Semester'] ?> </span> <span style="margin-left:100px">Kode : <?= $row['Kode'] ?></span> <span style="margin-left:100px">SKS : <?= $row['Bobot_(SKS)'] ?></span>
                        </h3>
                        <h3>
                            Jurusan <span style="margin-left: 32px;">: Informatika</span> <span style="margin-left: 100px; margin-left:170px">Dosen <span style="margin-left:28px"> : <?= $row['Dosen'] ?></span> </span>
                        </h3>
                    </div>

                    <h3 style="font-size: 15px; margin-top:30px">Tugas Sesuai Pokok Bahasan</h3>

                    <table style='width:100%; border-collapse: collapse;' border='1'>
                        <tr>
                            <th>Capaian Pembelajaran MK :</th>
                        </tr>
                        <tr>
                            <td><?= $row['Capaian'] ?></td>
                        </tr>
                    </table>

                    <table style='width:100%; border-collapse: collapse;' border='1'>
                        <tr>
                            <th rowspan="2" style="width: 200px;" >Uraian Tugas</th>
                            <th>Objek garapan</th>
                            <th>Aktivitas</th>
                            <th>Metodologi & Cara pengerjaannya</th>
                            <th>Kriteria luaran tugas yang dihasilkan</th>
                        </tr>
                        <tr>
                            <td><?= $row['Obyek'] ?></td>
                            <td><?= $row['Aktivitas'] ?></td>
                            <td><?= $row['Metodologi'] ?></td>
                            <td><?= $row['Kriteria_tugas'] ?></td>
                        </tr>
                    </table>
                    <table style='width:100%; border-collapse: collapse;' border='1'>
                        <tr>
                            <th style="width: 200px;">Kriteria Penilaian</th>
                            <td><?= $row['Kriteria'] ?></td>
                        </tr>
                    </table>
                    <table style='width:100%; border-collapse: collapse;' border='1'>
                        <tr>
                            <th style="width: 200px;">Jadwal Pelaksanaan</th>
                            <td><?= $row['Jadwal'] ?></td>
                        </tr>
                    </table>
                </div>
                

                <div style="margin-top: 20px;">
                    <a href="index.php?id=<?= $row['id'] ?>" class="btn btn-balik">Kembali</a>
                </div>
            <?php } ?>
        </main>
    
    
  </div>
</body>
</html>
