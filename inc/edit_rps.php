<?php
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Koneksi ke database
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "k12";
    $koneksi = new mysqli($host, $username, $password, $dbname);

    if ($koneksi->connect_error) {
        die("Koneksi gagal: " . $koneksi->connect_error);
    }

    // Ambil data berdasarkan ID
    $sql = "SELECT * FROM tb_rps_1 WHERE id = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Data tidak ditemukan!";
        exit;
    }

    // Proses form jika ada POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Ambil data dari input form
        $Matakuliah = $_POST['Matakuliah'];
        $Kode = $_POST['Kode'];
        $Rumpun_MK = $_POST['Rumpun_MK'];
        $Bobot_SKS = $_POST['Bobot_SKS'];
        $Semester = $_POST['Semester'];
        $Tanggal_Penyusunan = $_POST['Tanggal_Penyusunan'];
        $OTORISASI = $_POST['OTORISASI'];
        $Capaian_Pembelajaran = $_POST['Capaian_Pembelajaran'];
        $Deskrisi_Singkat_MK = $_POST['Deskrisi_Singkat_MK'];
        $Pustaka = $_POST['Pustaka'];
        $Media_Pembelajaran = $_POST['Media_Pembelajaran'];
        $Team_Teaching = $_POST['Team_Teaching'];
        $Matakuliah_Syarat = $_POST['Matakuliah_Syarat'];
        $Pengembangan_RPS = $_POST['Pengembangan_RPS'];
        $Koordinator_MK = $_POST['Koordinator_MK'];
        $Ketua_Prodi = $_POST['Ketua_Prodi'];
        $CPLP = $_POST['CPLP'];
        $CPMK = $_POST['CPMK'];
        $Sofwer = $_POST['Sofwer'];
        $hardwer = $_POST['hardwer'];
        $Mg1 = $_POST['1Mg_Ke'];
        $Sub_CPMK1 = $_POST['1Sub_CPMK'];
        $Materi_Pembelajaran1 = $_POST['1Materi_Pembelajaran'];
        $Metode1 = $_POST['1Metode'];
        $Indikator1 = $_POST['1Indikator'];
        $Bentuk1 = $_POST['1Bentuk'];
        $Bobot1 = $_POST['1Bobot'];
        $Mg2 = $_POST['2Mg_Ke'];
        $Sub_CPMK2 = $_POST['2Sub_CPMK'];
        $Materi_Pembelajaran2 = $_POST['2Materi_Pembelajaran'];
        $Metode2 = $_POST['2Metode'];
        $Indikator2 = $_POST['2Indikator'];
        $Bentuk2 = $_POST['2Bentuk'];
        $Bobot2 = $_POST['2Bobot'];
        $Mg3 = $_POST['3Mg_Ke'];
        $Sub_CPMK3 = $_POST['3Sub_CPMK'];
        $Materi_Pembelajaran3 = $_POST['3Materi_Pembelajaran'];
        $Metode3 = $_POST['3Metode'];
        $Indikator3 = $_POST['3Indikator'];
        $Bentuk3 = $_POST['3Bentuk'];
        $Bobot3 = $_POST['3Bobot'];
        $Mg4 = $_POST['4Mg_Ke'];
        $Sub_CPMK4 = $_POST['4Sub_CPMK'];
        $Materi_Pembelajaran4 = $_POST['4Materi_Pembelajaran'];
        $Metode4 = $_POST['4Metode'];
        $Indikator4 = $_POST['4Indikator'];
        $Bentuk4 = $_POST['4Bentuk'];
        $Bobot4 = $_POST['4Bobot'];
        $Mg5 = $_POST['5Mg_Ke'];
        $Sub_CPMK5 = $_POST['5Sub_CPMK'];
        $Materi_Pembelajaran5 = $_POST['5Materi_Pembelajaran'];
        $Metode5 = $_POST['5Metode'];
        $Indikator5 = $_POST['5Indikator'];
        $Bentuk5 = $_POST['5Bentuk'];
        $Bobot5 = $_POST['5Bobot'];
        $Mg6 = $_POST['6Mg_Ke'];
        $Sub_CPMK6 = $_POST['6Sub_CPMK'];
        $Materi_Pembelajaran6 = $_POST['6Materi_Pembelajaran'];
        $Metode6 = $_POST['6Metode'];
        $Indikator6 = $_POST['6Indikator'];
        $Bentuk6 = $_POST['6Bentuk'];
        $Bobot6 = $_POST['6Bobot'];
        $Mg7 = $_POST['7Mg_Ke'];
        $Sub_CPMK7 = $_POST['7Sub_CPMK'];
        $Materi_Pembelajaran7 = $_POST['7Materi_Pembelajaran'];
        $Metode7 = $_POST['7Metode'];
        $Indikator7 = $_POST['7Indikator'];
        $Bentuk7 = $_POST['7Bentuk'];
        $Bobot7 = $_POST['7Bobot'];
        $Mg8 = $_POST['8Mg_Ke'];
        $Sub_CPMK8 = $_POST['8Sub_CPMK'];
        $Materi_Pembelajaran8 = $_POST['8Materi_Pembelajaran'];
        $Metode8 = $_POST['8Metode'];
        $Indikator8 = $_POST['8Indikator'];
        $Bentuk8 = $_POST['8Bentuk'];
        $Bobot8 = $_POST['8Bobot'];
        $Mg9 = $_POST['9Mg_Ke'];
        $Sub_CPMK9 = $_POST['9Sub_CPMK'];
        $Materi_Pembelajaran9 = $_POST['9Materi_Pembelajaran'];
        $Metode9 = $_POST['9Metode'];
        $Indikator9 = $_POST['9Indikator'];
        $Bentuk9 = $_POST['9Bentuk'];
        $Bobot9 = $_POST['9Bobot'];
        $Mg10 = $_POST['10Mg_Ke'];
        $Sub_CPMK10 = $_POST['10Sub_CPMK'];
        $Materi_Pembelajaran10 = $_POST['10Materi_Pembelajaran'];
        $Metode10 = $_POST['10Metode'];
        $Indikator10 = $_POST['10Indikator'];
        $Bentuk10 = $_POST['10Bentuk'];
        $Bobot10 = $_POST['10Bobot'];
        $Mg11 = $_POST['11Mg_Ke'];
        $Sub_CPMK11 = $_POST['11Sub_CPMK'];
        $Materi_Pembelajaran11 = $_POST['11Materi_Pembelajaran'];
        $Metode11 = $_POST['11Metode'];
        $Indikator11 = $_POST['11Indikator'];
        $Bentuk11 = $_POST['11Bentuk'];
        $Bobot11 = $_POST['11Bobot'];
        $Mg12 = $_POST['12Mg_Ke'];
        $Sub_CPMK12 = $_POST['12Sub_CPMK'];
        $Materi_Pembelajaran12 = $_POST['12Materi_Pembelajaran'];
        $Metode12 = $_POST['12Metode'];
        $Indikator12 = $_POST['12Indikator'];
        $Bentuk12 = $_POST['12Bentuk'];
        $Bobot12 = $_POST['12Bobot'];
        $Mg13 = $_POST['13Mg_Ke'];
        $Sub_CPMK13 = $_POST['13Sub_CPMK'];
        $Materi_Pembelajaran13 = $_POST['13Materi_Pembelajaran'];
        $Metode13 = $_POST['13Metode'];
        $Indikator13 = $_POST['13Indikator'];
        $Bentuk13 = $_POST['13Bentuk'];
        $Bobot13 = $_POST['13Bobot'];
        $Mg14 = $_POST['14Mg_Ke'];
        $Sub_CPMK14 = $_POST['14Sub_CPMK'];
        $Materi_Pembelajaran14 = $_POST['14Materi_Pembelajaran'];
        $Metode14 = $_POST['14Metode'];
        $Indikator14 = $_POST['14Indikator'];
        $Bentuk14 = $_POST['14Bentuk'];
        $Bobot14 = $_POST['14Bobot'];
        $Mg15 = $_POST['15Mg_Ke'];
        $Sub_CPMK15 = $_POST['15Sub_CPMK'];
        $Materi_Pembelajaran15 = $_POST['15Materi_Pembelajaran'];
        $Metode15 = $_POST['15Metode'];
        $Indikator15 = $_POST['15Indikator'];
        $Bentuk15 = $_POST['15Bentuk'];
        $Bobot15 = $_POST['15Bobot'];
        $Mg16 = $_POST['16Mg_Ke'];
        $Sub_CPMK16 = $_POST['16Sub_CPMK'];
        $Materi_Pembelajaran16 = $_POST['16Materi_Pembelajaran'];
        $Metode16 = $_POST['16Metode'];
        $Indikator16 = $_POST['16Indikator'];
        $Bentuk16 = $_POST['16Bentuk'];
        $Bobot16 = $_POST['16Bobot'];

        
        $Obyek = $_POST['Obyek'];
        $Aktivitas = $_POST['Aktivitas'];
        $Metodologi = $_POST['Metodologi'];
        $Kriteria_tugas = $_POST['Kriteria_tugas'];
        $Kriteria = $_POST['Kriteria'];
        $Jadwal = $_POST['Jadwal'];
        $Capaian = $_POST['Capaian'];







        // Query untuk update data
        $updateSql = "UPDATE tb_rps_1 SET 
                        Matakuliah=?, Kode=?, Rumpun_MK=?, `Bobot_(SKS)`=?, Semester=?, 
                        Tanggal_Penyusunan=?, OTORISASI=?, Capaian_Pembelajaran=?, 
                        Deskrisi_Singkat_MK=?, Pustaka=?, Media_Pembelajaran=?, 
                        Team_Teaching=?, Matakuliah_Syarat=?, Pengembangan_RPS=?, Koordinator_MK=?, Ketua_Prodi=?, CPLP=?,CPMK=?, Sofwer=?, hardwer=?, 
                        1Mg_Ke=?, 1Sub_CPMK=?, 1Materi_Pembelajaran=?, 1Metode=?, 1Indikator=?, 1Bentuk=?, 1Bobot=?,
                        2Mg_Ke=?, 2Sub_CPMK=?, 2Materi_Pembelajaran=?, 2Metode=?, 2Indikator=?, 2Bentuk=?, 2Bobot=?,
                        3Mg_Ke=?, 3Sub_CPMK=?, 3Materi_Pembelajaran=?, 3Metode=?, 3Indikator=?, 3Bentuk=?, 3Bobot=?,
                        4Mg_Ke=?, 4Sub_CPMK=?, 4Materi_Pembelajaran=?, 4Metode=?, 4Indikator=?, 4Bentuk=?, 4Bobot=?,
                        5Mg_Ke=?, 5Sub_CPMK=?, 5Materi_Pembelajaran=?, 5Metode=?, 5Indikator=?, 5Bentuk=?, 5Bobot=?,
                        6Mg_Ke=?, 6Sub_CPMK=?, 6Materi_Pembelajaran=?, 6Metode=?, 6Indikator=?, 6Bentuk=?, 6Bobot=?,
                        7Mg_Ke=?, 7Sub_CPMK=?, 7Materi_Pembelajaran=?, 7Metode=?, 7Indikator=?, 7Bentuk=?, 7Bobot=?,
                        8Mg_Ke=?, 8Sub_CPMK=?, 8Materi_Pembelajaran=?, 8Metode=?, 8Indikator=?, 8Bentuk=?, 8Bobot=?,
                        9Mg_Ke=?, 9Sub_CPMK=?, 9Materi_Pembelajaran=?, 9Metode=?, 9Indikator=?, 9Bentuk=?, 9Bobot=?,
                        10Mg_Ke=?, 10Sub_CPMK=?, 10Materi_Pembelajaran=?, 10Metode=?, 10Indikator=?, 10Bentuk=?, 10Bobot=?,
                        11Mg_Ke=?, 11Sub_CPMK=?, 11Materi_Pembelajaran=?, 11Metode=?, 11Indikator=?, 11Bentuk=?, 11Bobot=?,
                        12Mg_Ke=?, 12Sub_CPMK=?, 12Materi_Pembelajaran=?, 12Metode=?, 12Indikator=?, 12Bentuk=?, 12Bobot=?,
                        13Mg_Ke=?, 13Sub_CPMK=?, 13Materi_Pembelajaran=?, 13Metode=?, 13Indikator=?, 13Bentuk=?, 13Bobot=?,
                        14Mg_Ke=?, 14Sub_CPMK=?, 14Materi_Pembelajaran=?, 14Metode=?, 14Indikator=?, 14Bentuk=?, 14Bobot=?,
                        15Mg_Ke=?, 15Sub_CPMK=?, 15Materi_Pembelajaran=?, 15Metode=?, 15Indikator=?, 15Bentuk=?, 15Bobot=?,
                        16Mg_Ke=?, 16Sub_CPMK=?, 16Materi_Pembelajaran=?, 16Metode=?, 16Indikator=?, 16Bentuk=?, 16Bobot=?,
                        
                        Obyek=?, Aktivitas=?, Metodologi=?, Kriteria_tugas=?, Kriteria=?, Jadwal=?, Capaian=? WHERE id=?";

        $updateStmt = $koneksi->prepare($updateSql);
        $updateStmt->bind_param(
            "sssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssi",
            $Matakuliah,
            $Kode,
            $Rumpun_MK,
            $Bobot_SKS,
            $Semester,
            $Tanggal_Penyusunan,
            $OTORISASI,
            $Capaian_Pembelajaran,
            $Deskrisi_Singkat_MK,
            $Pustaka,
            $Media_Pembelajaran,
            $Team_Teaching,
            $Matakuliah_Syarat,
            $Pengembangan_RPS,
            $Koordinator_MK,
            $Ketua_Prodi,
            $CPLP,
            $CPMK,
            $Sofwer,
            $hardwer,
            $Mg1,
            $Sub_CPMK1,
            $Materi_Pembelajaran1,
            $Metode1,
            $Indikator1,
            $Bentuk1,
            $Bobot1,
            $Mg2,
            $Sub_CPMK2,
            $Materi_Pembelajaran2,
            $Metode2,
            $Indikator2,
            $Bentuk2,
            $Bobot2,
            $Mg3,
            $Sub_CPMK3,
            $Materi_Pembelajaran3,
            $Metode3,
            $Indikator3,
            $Bentuk3,
            $Bobot3,
            $Mg4,
            $Sub_CPMK4,
            $Materi_Pembelajaran4,
            $Metode4,
            $Indikator4,
            $Bentuk4,
            $Bobot4,
            $Mg5,
            $Sub_CPMK5,
            $Materi_Pembelajaran5,
            $Metode5,
            $Indikator5,
            $Bentuk5,
            $Bobot5,
            $Mg6,
            $Sub_CPMK6,
            $Materi_Pembelajaran6,
            $Metode6,
            $Indikator6,
            $Bentuk6,
            $Bobot6,
            $Mg7,
            $Sub_CPMK7,
            $Materi_Pembelajaran7,
            $Metode7,
            $Indikator7,
            $Bentuk7,
            $Bobot7,
            $Mg8,
            $Sub_CPMK8,
            $Materi_Pembelajaran8,
            $Metode8,
            $Indikator8,
            $Bentuk8,
            $Bobot8,
            $Mg9,
            $Sub_CPMK9,
            $Materi_Pembelajaran9,
            $Metode9,
            $Indikator9,
            $Bentuk9,
            $Bobot9,
            $Mg10,
            $Sub_CPMK10,
            $Materi_Pembelajaran10,
            $Metode10,
            $Indikator10,
            $Bentuk10,
            $Bobot10,
            $Mg11,
            $Sub_CPMK11,
            $Materi_Pembelajaran11,
            $Metode11,
            $Indikator11,
            $Bentuk11,
            $Bobot11,
            $Mg12,
            $Sub_CPMK12,
            $Materi_Pembelajaran12,
            $Metode12,
            $Indikator12,
            $Bentuk12,
            $Bobot12,
            $Mg13,
            $Sub_CPMK13,
            $Materi_Pembelajaran13,
            $Metode13,
            $Indikator13,
            $Bentuk13,
            $Bobot13,
            $Mg14,
            $Sub_CPMK14,
            $Materi_Pembelajaran14,
            $Metode14,
            $Indikator14,
            $Bentuk14,
            $Bobot14,
            $Mg15,
            $Sub_CPMK15,
            $Materi_Pembelajaran15,
            $Metode15,
            $Indikator15,
            $Bentuk15,
            $Bobot15,
            $Mg16,
            $Sub_CPMK16,
            $Materi_Pembelajaran16,
            $Metode16,
            $Indikator16,
            $Bentuk16,
            $Bobot16,
            $Obyek, $Aktivitas, $Metodologi ,$Kriteria_tugas, $Kriteria, $Jadwal, $Capaian,
            $id);
        $updateStmt->execute();

        echo "Data berhasil diperbarui.";
        header("Location: Dashboard_Dosen.php"); // Redirect setelah update
        exit;
    }

    $koneksi->close();
} else {
    echo "ID tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data RPS</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
            color: #555;
        }

        input,
        textarea {
            margin-bottom: 12px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            padding: 12px 20px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Edit Data RPS</h1>
        <form method="POST">
            <label for="Matakuliah">Matakuliah:</label>
            <input type="text" name="Matakuliah" value="<?= htmlspecialchars($row['Matakuliah']) ?>">

            <label for="Kode">Kode:</label>
            <input type="text" name="Kode" value="<?= htmlspecialchars($row['Kode']) ?>">

            <label for="Rumpun_MK">Rumpun MK:</label>
            <input type="text" name="Rumpun_MK" value="<?= htmlspecialchars($row['Rumpun_MK']) ?>">

            <label for="Bobot_SKS">Bobot (SKS):</label>
            <input type="number" name="Bobot_SKS" value="<?= htmlspecialchars($row['Bobot_(SKS)']) ?>">

            <label for="Semester">Semester:</label>
            <input type="text" name="Semester" value="<?= htmlspecialchars($row['Semester']) ?>">

            <label for="Tanggal_Penyusunan">Tanggal Penyusunan:</label>
            <input type="date" name="Tanggal_Penyusunan" value="<?= htmlspecialchars($row['Tanggal_penyusunan']) ?>">

            <label for="OTORISASI">OTORISASI:</label>
            <input type="text" name="OTORISASI" value="<?= htmlspecialchars($row['OTORISASI']) ?>">

            <label for="Capaian_Pembelajaran">Capaian Pembelajaran:</label>
            <textarea name="Capaian_Pembelajaran"><?= htmlspecialchars($row['Capaian_Pembelajaran']) ?></textarea>

            <label for="Deskrisi_Singkat_MK">Deskripsi Singkat MK:</label>
            <textarea name="Deskrisi_Singkat_MK"><?= htmlspecialchars($row['Deskrisi_Singkat_MK']) ?></textarea>

            <label for="Pustaka">Pustaka:</label>
            <textarea name="Pustaka"><?= htmlspecialchars($row['Pustaka']) ?></textarea>

            <label for="Media_Pembelajaran">Media Pembelajaran:</label>
            <textarea name="Media_Pembelajaran"><?= htmlspecialchars($row['Media_Pembelajaran']) ?></textarea>

            <label for="Team_Teaching">Team Teaching:</label>
            <input type="text" name="Team_Teaching" value="<?= htmlspecialchars($row['Team_Teaching']) ?>">

            <label for="Matakuliah_Syarat">Matakuliah Syarat:</label>
            <input type="text" name="Matakuliah_Syarat" value="<?= htmlspecialchars($row['Matakuliah_Syarat']) ?>">

            <label for="Pengembangan_RPS">Pengembangan_RPS:</label>
            <input type="text" name="Pengembangan_RPS" value="<?= htmlspecialchars($row['Pengembangan_RPS']) ?>">

            <label for="Koordinator_MK">Koordinator_MK:</label>
            <input type="text" name="Koordinator_MK" value="<?= htmlspecialchars($row['Koordinator_MK']) ?>">

            <label for="Ketua_Prodi">Ketua_Prodi:</label>
            <input type="text" name="Ketua_Prodi" value="<?= htmlspecialchars($row['Ketua_Prodi']) ?>">

            <label for="CPLP">CPLP:</label>
            <input type="text" name="CPLP" value="<?= htmlspecialchars($row['CPLP']) ?>">

            <label for="CPMK">CPMK:</label>
            <input type="text" name="CPMK" value="<?= htmlspecialchars($row['CPMK']) ?>">

            <label for="Sofwer">Sofwer :</label>
            <input type="text" name="Sofwer" value="<?= htmlspecialchars($row['Sofwer']) ?>">

            <label for="hardwer">hardwer :</label>
            <input type="text" name="hardwer" value="<?= htmlspecialchars($row['hardwer']) ?>">

            <label for="1Mg_Ke">Minggu Ke :</label>
            <input type="text" name="1Mg_Ke" value="<?= htmlspecialchars($row['1Mg_Ke']) ?>">

            <label for="1Sub_CPMK">Sub-CPMK (Kemampuan akhir tiap tahapan belajar) :</label>
            <input type="text" name="1Sub_CPMK" value="<?= htmlspecialchars($row['1Sub_CPMK']) ?>">

            <label for="1Materi_Pembelajaran">Materi Pembelajaran (Pokok bahasan) [Pustaka] :</label>
            <input type="text" name="1Materi_Pembelajaran" value="<?= htmlspecialchars($row['1Materi_Pembelajaran']) ?>">

            <label for="1Metode">Metode / Strategi Pembelajaran [Estimasi Waktu] :</label>
            <input type="text" name="1Metode" value="<?= htmlspecialchars($row['1Metode']) ?>">

            <label for="1Indikator">Indikator :</label>
            <input type="text" name="1Indikator" value="<?= htmlspecialchars($row['1Indikator']) ?>">

            <label for="1Bentuk">Bentuk :</label>
            <input type="text" name="1Bentuk" value="<?= htmlspecialchars($row['1Bentuk']) ?>">

            <label for="1Bobot">Bobot :</label>
            <input type="text" name="1Bobot" value="<?= htmlspecialchars($row['1Bobot']) ?>">

            <label for="2Mg_Ke">Minggu Ke :</label>
            <input type="text" name="2Mg_Ke" value="<?= htmlspecialchars($row['2Mg_Ke']) ?>">

            <label for="2Sub_CPMK">Sub-CPMK (Kemampuan akhir tiap tahapan belajar) :</label>
            <input type="text" name="2Sub_CPMK" value="<?= htmlspecialchars($row['2Sub_CPMK']) ?>">

            <label for="2Materi_Pembelajaran">Materi Pembelajaran (Pokok bahasan) [Pustaka] :</label>
            <input type="text" name="2Materi_Pembelajaran" value="<?= htmlspecialchars($row['2Materi_Pembelajaran']) ?>">

            <label for="2Metode">Metode / Strategi Pembelajaran [Estimasi Waktu] :</label>
            <input type="text" name="2Metode" value="<?= htmlspecialchars($row['2Metode']) ?>">

            <label for="2Indikator">Indikator :</label>
            <input type="text" name="2Indikator" value="<?= htmlspecialchars($row['2Indikator']) ?>">

            <label for="2Bentuk">Bentuk :</label>
            <input type="text" name="2Bentuk" value="<?= htmlspecialchars($row['2Bentuk']) ?>">

            <label for="2Bobot">Bobot :</label>
            <input type="text" name="2Bobot" value="<?= htmlspecialchars($row['2Bobot']) ?>">

            <label for="3Mg_Ke">Minggu Ke :</label>
            <input type="text" name="3Mg_Ke" value="<?= htmlspecialchars($row['3Mg_Ke']) ?>">

            <label for="3Sub_CPMK">Sub-CPMK (Kemampuan akhir tiap tahapan belajar) :</label>
            <input type="text" name="3Sub_CPMK" value="<?= htmlspecialchars($row['3Sub_CPMK']) ?>">

            <label for="3Materi_Pembelajaran">Materi Pembelajaran (Pokok bahasan) [Pustaka] :</label>
            <input type="text" name="3Materi_Pembelajaran" value="<?= htmlspecialchars($row['3Materi_Pembelajaran']) ?>">

            <label for="3Metode">Metode / Strategi Pembelajaran [Estimasi Waktu] :</label>
            <input type="text" name="3Metode" value="<?= htmlspecialchars($row['3Metode']) ?>">

            <label for="3Indikator">Indikator :</label>
            <input type="text" name="3Indikator" value="<?= htmlspecialchars($row['3Indikator']) ?>">

            <label for="3Bentuk">Bentuk :</label>
            <input type="text" name="3Bentuk" value="<?= htmlspecialchars($row['3Bentuk']) ?>">

            <label for="3Bobot">Bobot :</label>
            <input type="text" name="3Bobot" value="<?= htmlspecialchars($row['3Bobot']) ?>">

            <label for="4Mg_Ke">Minggu Ke :</label>
            <input type="text" name="4Mg_Ke" value="<?= htmlspecialchars($row['4Mg_Ke']) ?>">

            <label for="4Sub_CPMK">Sub-CPMK (Kemampuan akhir tiap tahapan belajar) :</label>
            <input type="text" name="4Sub_CPMK" value="<?= htmlspecialchars($row['4Sub_CPMK']) ?>">

            <label for="4Materi_Pembelajaran">Materi Pembelajaran (Pokok bahasan) [Pustaka] :</label>
            <input type="text" name="4Materi_Pembelajaran" value="<?= htmlspecialchars($row['4Materi_Pembelajaran']) ?>">

            <label for="4Metode">Metode / Strategi Pembelajaran [Estimasi Waktu] :</label>
            <input type="text" name="4Metode" value="<?= htmlspecialchars($row['4Metode']) ?>">

            <label for="4Indikator">Indikator :</label>
            <input type="text" name="4Indikator" value="<?= htmlspecialchars($row['4Indikator']) ?>">

            <label for="4Bentuk">Bentuk :</label>
            <input type="text" name="4Bentuk" value="<?= htmlspecialchars($row['4Bentuk']) ?>">

            <label for="4Bobot">Bobot :</label>
            <input type="text" name="4Bobot" value="<?= htmlspecialchars($row['4Bobot']) ?>">

            <label for="5Mg_Ke">Minggu Ke :</label>
            <input type="text" name="5Mg_Ke" value="<?= htmlspecialchars($row['5Mg_Ke']) ?>">

            <label for="5Sub_CPMK">Sub-CPMK (Kemampuan akhir tiap tahapan belajar) :</label>
            <input type="text" name="5Sub_CPMK" value="<?= htmlspecialchars($row['5Sub_CPMK']) ?>">

            <label for="5Materi_Pembelajaran">Materi Pembelajaran (Pokok bahasan) [Pustaka] :</label>
            <input type="text" name="5Materi_Pembelajaran" value="<?= htmlspecialchars($row['5Materi_Pembelajaran']) ?>">

            <label for="5Metode">Metode / Strategi Pembelajaran [Estimasi Waktu] :</label>
            <input type="text" name="5Metode" value="<?= htmlspecialchars($row['5Metode']) ?>">

            <label for="5Indikator">Indikator :</label>
            <input type="text" name="5Indikator" value="<?= htmlspecialchars($row['5Indikator']) ?>">

            <label for="5Bentuk">Bentuk :</label>
            <input type="text" name="5Bentuk" value="<?= htmlspecialchars($row['5Bentuk']) ?>">

            <label for="5Bobot">Bobot :</label>
            <input type="text" name="5Bobot" value="<?= htmlspecialchars($row['5Bobot']) ?>">

            <label for="6Mg_Ke">Minggu Ke :</label>
            <input type="text" name="6Mg_Ke" value="<?= htmlspecialchars($row['6Mg_Ke']) ?>">

            <label for="6Sub_CPMK">Sub-CPMK (Kemampuan akhir tiap tahapan belajar) :</label>
            <input type="text" name="6Sub_CPMK" value="<?= htmlspecialchars($row['6Sub_CPMK']) ?>">

            <label for="6Materi_Pembelajaran">Materi Pembelajaran (Pokok bahasan) [Pustaka] :</label>
            <input type="text" name="6Materi_Pembelajaran" value="<?= htmlspecialchars($row['6Materi_Pembelajaran']) ?>">

            <label for="6Metode">Metode / Strategi Pembelajaran [Estimasi Waktu] :</label>
            <input type="text" name="6Metode" value="<?= htmlspecialchars($row['6Metode']) ?>">

            <label for="6Indikator">Indikator :</label>
            <input type="text" name="6Indikator" value="<?= htmlspecialchars($row['6Indikator']) ?>">

            <label for="6Bentuk">Bentuk :</label>
            <input type="text" name="6Bentuk" value="<?= htmlspecialchars($row['6Bentuk']) ?>">

            <label for="6Bobot">Bobot :</label>
            <input type="text" name="6Bobot" value="<?= htmlspecialchars($row['6Bobot']) ?>">

            <label for="7Mg_Ke">Minggu Ke :</label>
            <input type="text" name="7Mg_Ke" value="<?= htmlspecialchars($row['7Mg_Ke']) ?>">

            <label for="7Sub_CPMK">Sub-CPMK (Kemampuan akhir tiap tahapan belajar) :</label>
            <input type="text" name="7Sub_CPMK" value="<?= htmlspecialchars($row['7Sub_CPMK']) ?>">

            <label for="7Materi_Pembelajaran">Materi Pembelajaran (Pokok bahasan) [Pustaka] :</label>
            <input type="text" name="7Materi_Pembelajaran" value="<?= htmlspecialchars($row['7Materi_Pembelajaran']) ?>">

            <label for="7Metode">Metode / Strategi Pembelajaran [Estimasi Waktu] :</label>
            <input type="text" name="7Metode" value="<?= htmlspecialchars($row['7Metode']) ?>">

            <label for="7Indikator">Indikator :</label>
            <input type="text" name="7Indikator" value="<?= htmlspecialchars($row['7Indikator']) ?>">

            <label for="7Bentuk">Bentuk :</label>
            <input type="text" name="7Bentuk" value="<?= htmlspecialchars($row['7Bentuk']) ?>">

            <label for="7Bobot">Bobot :</label>
            <input type="text" name="7Bobot" value="<?= htmlspecialchars($row['7Bobot']) ?>">

            <label for="8Mg_Ke">Minggu Ke :</label>
            <input type="text" name="8Mg_Ke" value="<?= htmlspecialchars($row['8Mg_Ke']) ?>">

            <label for="8Sub_CPMK">Sub-CPMK (Kemampuan akhir tiap tahapan belajar) :</label>
            <input type="text" name="8Sub_CPMK" value="<?= htmlspecialchars($row['8Sub_CPMK']) ?>">

            <label for="8Materi_Pembelajaran">Materi Pembelajaran (Pokok bahasan) [Pustaka] :</label>
            <input type="text" name="8Materi_Pembelajaran" value="<?= htmlspecialchars($row['8Materi_Pembelajaran']) ?>">

            <label for="8Metode">Metode / Strategi Pembelajaran [Estimasi Waktu] :</label>
            <input type="text" name="8Metode" value="<?= htmlspecialchars($row['8Metode']) ?>">

            <label for="8Indikator">Indikator :</label>
            <input type="text" name="8Indikator" value="<?= htmlspecialchars($row['8Indikator']) ?>">

            <label for="8Bentuk">Bentuk :</label>
            <input type="text" name="8Bentuk" value="<?= htmlspecialchars($row['8Bentuk']) ?>">

            <label for="8Bobot">Bobot :</label>
            <input type="text" name="8Bobot" value="<?= htmlspecialchars($row['8Bobot']) ?>">

            <label for="9Mg_Ke">Minggu Ke :</label>
            <input type="text" name="9Mg_Ke" value="<?= htmlspecialchars($row['9Mg_Ke']) ?>">

            <label for="9Sub_CPMK">Sub-CPMK (Kemampuan akhir tiap tahapan belajar) :</label>
            <input type="text" name="9Sub_CPMK" value="<?= htmlspecialchars($row['9Sub_CPMK']) ?>">

            <label for="9Materi_Pembelajaran">Materi Pembelajaran (Pokok bahasan) [Pustaka] :</label>
            <input type="text" name="9Materi_Pembelajaran" value="<?= htmlspecialchars($row['9Materi_Pembelajaran']) ?>">

            <label for="9Metode">Metode / Strategi Pembelajaran [Estimasi Waktu] :</label>
            <input type="text" name="9Metode" value="<?= htmlspecialchars($row['9Metode']) ?>">

            <label for="9Indikator">Indikator :</label>
            <input type="text" name="9Indikator" value="<?= htmlspecialchars($row['9Indikator']) ?>">

            <label for="9Bentuk">Bentuk :</label>
            <input type="text" name="9Bentuk" value="<?= htmlspecialchars($row['9Bentuk']) ?>">

            <label for="9Bobot">Bobot :</label>
            <input type="text" name="9Bobot" value="<?= htmlspecialchars($row['9Bobot']) ?>">

            <label for="10Mg_Ke">Minggu Ke :</label>
            <input type="text" name="10Mg_Ke" value="<?= htmlspecialchars($row['10Mg_Ke']) ?>">

            <label for="10Sub_CPMK">Sub-CPMK (Kemampuan akhir tiap tahapan belajar) :</label>
            <input type="text" name="10Sub_CPMK" value="<?= htmlspecialchars($row['10Sub_CPMK']) ?>">

            <label for="10Materi_Pembelajaran">Materi Pembelajaran (Pokok bahasan) [Pustaka] :</label>
            <input type="text" name="10Materi_Pembelajaran" value="<?= htmlspecialchars($row['10Materi_Pembelajaran']) ?>">

            <label for="10Metode">Metode / Strategi Pembelajaran [Estimasi Waktu] :</label>
            <input type="text" name="10Metode" value="<?= htmlspecialchars($row['10Metode']) ?>">

            <label for="10Indikator">Indikator :</label>
            <input type="text" name="10Indikator" value="<?= htmlspecialchars($row['10Indikator']) ?>">

            <label for="10Bentuk">Bentuk :</label>
            <input type="text" name="10Bentuk" value="<?= htmlspecialchars($row['10Bentuk']) ?>">

            <label for="10Bobot">Bobot :</label>
            <input type="text" name="10Bobot" value="<?= htmlspecialchars($row['10Bobot']) ?>">

            <label for="11Mg_Ke">Minggu Ke :</label>
            <input type="text" name="11Mg_Ke" value="<?= htmlspecialchars($row['11Mg_Ke']) ?>">

            <label for="11Sub_CPMK">Sub-CPMK (Kemampuan akhir tiap tahapan belajar) :</label>
            <input type="text" name="11Sub_CPMK" value="<?= htmlspecialchars($row['11Sub_CPMK']) ?>">

            <label for="11Materi_Pembelajaran">Materi Pembelajaran (Pokok bahasan) [Pustaka] :</label>
            <input type="text" name="11Materi_Pembelajaran" value="<?= htmlspecialchars($row['11Materi_Pembelajaran']) ?>">

            <label for="11Metode">Metode / Strategi Pembelajaran [Estimasi Waktu] :</label>
            <input type="text" name="11Metode" value="<?= htmlspecialchars($row['11Metode']) ?>">

            <label for="11Indikator">Indikator :</label>
            <input type="text" name="11Indikator" value="<?= htmlspecialchars($row['11Indikator']) ?>">

            <label for="11Bentuk">Bentuk :</label>
            <input type="text" name="11Bentuk" value="<?= htmlspecialchars($row['11Bentuk']) ?>">

            <label for="11Bobot">Bobot :</label>
            <input type="text" name="11Bobot" value="<?= htmlspecialchars($row['11Bobot']) ?>">

            <label for="12Mg_Ke">Minggu Ke :</label>
            <input type="text" name="12Mg_Ke" value="<?= htmlspecialchars($row['12Mg_Ke']) ?>">

            <label for="12Sub_CPMK">Sub-CPMK (Kemampuan akhir tiap tahapan belajar) :</label>
            <input type="text" name="12Sub_CPMK" value="<?= htmlspecialchars($row['12Sub_CPMK']) ?>">

            <label for="12Materi_Pembelajaran">Materi Pembelajaran (Pokok bahasan) [Pustaka] :</label>
            <input type="text" name="12Materi_Pembelajaran" value="<?= htmlspecialchars($row['12Materi_Pembelajaran']) ?>">

            <label for="12Metode">Metode / Strategi Pembelajaran [Estimasi Waktu] :</label>
            <input type="text" name="12Metode" value="<?= htmlspecialchars($row['12Metode']) ?>">

            <label for="12Indikator">Indikator :</label>
            <input type="text" name="12Indikator" value="<?= htmlspecialchars($row['12Indikator']) ?>">

            <label for="12Bentuk">Bentuk :</label>
            <input type="text" name="12Bentuk" value="<?= htmlspecialchars($row['12Bentuk']) ?>">

            <label for="12Bobot">Bobot :</label>
            <input type="text" name="12Bobot" value="<?= htmlspecialchars($row['12Bobot']) ?>">

            <label for="13Mg_Ke">Minggu Ke :</label>
            <input type="text" name="13Mg_Ke" value="<?= htmlspecialchars($row['13Mg_Ke']) ?>">

            <label for="13Sub_CPMK">Sub-CPMK (Kemampuan akhir tiap tahapan belajar) :</label>
            <input type="text" name="13Sub_CPMK" value="<?= htmlspecialchars($row['13Sub_CPMK']) ?>">

            <label for="13Materi_Pembelajaran">Materi Pembelajaran (Pokok bahasan) [Pustaka] :</label>
            <input type="text" name="13Materi_Pembelajaran" value="<?= htmlspecialchars($row['13Materi_Pembelajaran']) ?>">

            <label for="13Metode">Metode / Strategi Pembelajaran [Estimasi Waktu] :</label>
            <input type="text" name="13Metode" value="<?= htmlspecialchars($row['13Metode']) ?>">

            <label for="13Indikator">Indikator :</label>
            <input type="text" name="13Indikator" value="<?= htmlspecialchars($row['13Indikator']) ?>">

            <label for="13Bentuk">Bentuk :</label>
            <input type="text" name="13Bentuk" value="<?= htmlspecialchars($row['13Bentuk']) ?>">

            <label for="13Bobot">Bobot :</label>
            <input type="text" name="13Bobot" value="<?= htmlspecialchars($row['13Bobot']) ?>">

            <label for="14Mg_Ke">Minggu Ke :</label>
            <input type="text" name="14Mg_Ke" value="<?= htmlspecialchars($row['14Mg_Ke']) ?>">

            <label for="14Sub_CPMK">Sub-CPMK (Kemampuan akhir tiap tahapan belajar) :</label>
            <input type="text" name="14Sub_CPMK" value="<?= htmlspecialchars($row['14Sub_CPMK']) ?>">

            <label for="14Materi_Pembelajaran">Materi Pembelajaran (Pokok bahasan) [Pustaka] :</label>
            <input type="text" name="14Materi_Pembelajaran" value="<?= htmlspecialchars($row['14Materi_Pembelajaran']) ?>">

            <label for="14Metode">Metode / Strategi Pembelajaran [Estimasi Waktu] :</label>
            <input type="text" name="14Metode" value="<?= htmlspecialchars($row['14Metode']) ?>">

            <label for="14Indikator">Indikator :</label>
            <input type="text" name="14Indikator" value="<?= htmlspecialchars($row['14Indikator']) ?>">

            <label for="14Bentuk">Bentuk :</label>
            <input type="text" name="14Bentuk" value="<?= htmlspecialchars($row['14Bentuk']) ?>">

            <label for="14Bobot">Bobot :</label>
            <input type="text" name="14Bobot" value="<?= htmlspecialchars($row['14Bobot']) ?>">

            <label for="15Mg_Ke">Minggu Ke :</label>
            <input type="text" name="15Mg_Ke" value="<?= htmlspecialchars($row['15Mg_Ke']) ?>">

            <label for="15Sub_CPMK">Sub-CPMK (Kemampuan akhir tiap tahapan belajar) :</label>
            <input type="text" name="15Sub_CPMK" value="<?= htmlspecialchars($row['15Sub_CPMK']) ?>">

            <label for="15Materi_Pembelajaran">Materi Pembelajaran (Pokok bahasan) [Pustaka] :</label>
            <input type="text" name="15Materi_Pembelajaran" value="<?= htmlspecialchars($row['15Materi_Pembelajaran']) ?>">

            <label for="15Metode">Metode / Strategi Pembelajaran [Estimasi Waktu] :</label>
            <input type="text" name="15Metode" value="<?= htmlspecialchars($row['15Metode']) ?>">

            <label for="15Indikator">Indikator :</label>
            <input type="text" name="15Indikator" value="<?= htmlspecialchars($row['15Indikator']) ?>">

            <label for="15Bentuk">Bentuk :</label>
            <input type="text" name="15Bentuk" value="<?= htmlspecialchars($row['15Bentuk']) ?>">

            <label for="15Bobot">Bobot :</label>
            <input type="text" name="15Bobot" value="<?= htmlspecialchars($row['15Bobot']) ?>">

            <label for="16Mg_Ke">Minggu Ke :</label>
            <input type="text" name="16Mg_Ke" value="<?= htmlspecialchars($row['16Mg_Ke']) ?>">

            <label for="16Sub_CPMK">Sub-CPMK (Kemampuan akhir tiap tahapan belajar) :</label>
            <input type="text" name="16Sub_CPMK" value="<?= htmlspecialchars($row['16Sub_CPMK']) ?>">

            <label for="16Materi_Pembelajaran">Materi Pembelajaran (Pokok bahasan) [Pustaka] :</label>
            <input type="text" name="16Materi_Pembelajaran" value="<?= htmlspecialchars($row['16Materi_Pembelajaran']) ?>">

            <label for="16Metode">Metode / Strategi Pembelajaran [Estimasi Waktu] :</label>
            <input type="text" name="16Metode" value="<?= htmlspecialchars($row['16Metode']) ?>">

            <label for="16Indikator">Indikator :</label>
            <input type="text" name="16Indikator" value="<?= htmlspecialchars($row['16Indikator']) ?>">

            <label for="16Bentuk">Bentuk :</label>
            <input type="text" name="16Bentuk" value="<?= htmlspecialchars($row['16Bentuk']) ?>">

            <label for="16Bobot">Bobot :</label>
            <input type="text" name="16Bobot" value="<?= htmlspecialchars($row['16Bobot']) ?>">



            <label for="Capaian">Capaian Pembelajaran MK :</label>
            <input type="text" name="Capaian" value="<?= htmlspecialchars($row['Capaian']) ?>">

            <label for="Obyek">Objek garapan :</label>
            <input type="text" name="Obyek" value="<?= htmlspecialchars($row['Obyek']) ?>">
            
            <label for="Aktivitas">Aktivitas :</label>
            <input type="text" name="Aktivitas" value="<?= htmlspecialchars($row['Aktivitas']) ?>">

            <label for="Metodologi">Metodologi & Cara pengerjaannya :</label>
            <input type="text" name="Metodologi" value="<?= htmlspecialchars($row['Metodologi']) ?>">

            <label for="Kriteria_tugas">Kriteria luaran tugas yang dihasilkan :</label>
            <input type="text" name="Kriteria_tugas" value="<?= htmlspecialchars($row['Kriteria_tugas']) ?>">

            <label for="Kriteria">Kriteria Penilaian :</label>
            <input type="text" name="Kriteria" value="<?= htmlspecialchars($row['Kriteria']) ?>">

            <label for="Jadwal">Jadwal Pelaksanaan :</label>
            <input type="text" name="Jadwal" value="<?= htmlspecialchars($row['Jadwal']) ?>">

            <input type="submit" value="Simpan Perubahan">
        </form>
    </div>
</body>

</html>