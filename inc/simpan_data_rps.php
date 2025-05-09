<?php
// Koneksi ke database
$host = "localhost";
$username = "root"; // Username default MySQL di XAMPP
$password = ""; // Password default kosong di XAMPP
$dbname = "k12";

$koneksi = new mysqli($host, $username, $password, $dbname);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Mendapatkan data dari form
$Matakuliah = $_POST['Matakuliah'];
$Kode = $_POST['Kode'];
$Rumpun_MK = $_POST['Rumpun_MK'];
$Bobot_SKS = $_POST['Bobot_SKS'];
$Semester = $_POST['Semester'];
$Tanggal_Penyusunan = $_POST['Tanggal_Penyusunan'];
$OTORISASI = $_POST['OTORISASI'];
$Capaian_Pembelajaran = $_POST['Capaian_Pembelajaran'];
$Deskrisi_Singkat_MK = $_POST['Deskripsi_Singkat_MK'];
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
$Dosen = $_POST['Dosen'];

// tabel ke 2 start //
$Mg_Ke1 = $_POST['1Mg_Ke'];
$Sub_CPMK1 = $_POST['1Sub_CPMK'];
$Materi_Pembelajaran1 = $_POST['1Materi_Pembelajaran'];
$Metode1 = $_POST['1Metode'];
$Indikator1 = $_POST['1Indikator'];
$Bentuk1 = $_POST['1Bentuk'];
$Bobot1 = $_POST['1Bobot'];

$Mg_Ke2 = $_POST['2Mg_Ke'];
$Sub_CPMK2 = $_POST['2Sub_CPMK'];
$Materi_Pembelajaran2 = $_POST['2Materi_Pembelajaran'];
$Metode2 = $_POST['2Metode'];
$Indikator2 = $_POST['2Indikator'];
$Bentuk2 = $_POST['2Bentuk'];
$Bobot2 = $_POST['2Bobot'];

$Mg_Ke3 = $_POST['3Mg_Ke'];
$Sub_CPMK3 = $_POST['3Sub_CPMK'];
$Materi_Pembelajaran3 = $_POST['3Materi_Pembelajaran'];
$Metode3 = $_POST['3Metode'];
$Indikator3 = $_POST['3Indikator'];
$Bentuk3 = $_POST['3Bentuk'];
$Bobot3 = $_POST['3Bobot'];

$Mg_Ke4 = $_POST['4Mg_Ke'];
$Sub_CPMK4 = $_POST['4Sub_CPMK'];
$Materi_Pembelajaran4 = $_POST['4Materi_Pembelajaran'];
$Metode4 = $_POST['4Metode'];
$Indikator4 = $_POST['4Indikator'];
$Bentuk4 = $_POST['4Bentuk'];
$Bobot4 = $_POST['4Bobot'];

$Mg_Ke5 = $_POST['5Mg_Ke'];
$Sub_CPMK5 = $_POST['5Sub_CPMK'];
$Materi_Pembelajaran5 = $_POST['5Materi_Pembelajaran'];
$Metode5 = $_POST['5Metode'];
$Indikator5 = $_POST['5Indikator'];
$Bentuk5 = $_POST['5Bentuk'];
$Bobot5 = $_POST['5Bobot'];

$Mg_Ke6 = $_POST['6Mg_Ke'];
$Sub_CPMK6 = $_POST['6Sub_CPMK'];
$Materi_Pembelajaran6 = $_POST['6Materi_Pembelajaran'];
$Metode6 = $_POST['6Metode'];
$Indikator6 = $_POST['6Indikator'];
$Bentuk6 = $_POST['6Bentuk'];
$Bobot6 = $_POST['6Bobot'];

$Mg_Ke7 = $_POST['7Mg_Ke'];
$Sub_CPMK7 = $_POST['7Sub_CPMK'];
$Materi_Pembelajaran7 = $_POST['7Materi_Pembelajaran'];
$Metode7 = $_POST['7Metode'];
$Indikator7 = $_POST['7Indikator'];
$Bentuk7 = $_POST['7Bentuk'];
$Bobot7 = $_POST['7Bobot'];

$Mg_Ke8 = $_POST['8Mg_Ke'];
$Sub_CPMK8 = $_POST['8Sub_CPMK'];
$Materi_Pembelajaran8 = $_POST['8Materi_Pembelajaran'];
$Metode8 = $_POST['8Metode'];
$Indikator8 = $_POST['8Indikator'];
$Bentuk8 = $_POST['8Bentuk'];
$Bobot8 = $_POST['8Bobot'];

$Mg_Ke9 = $_POST['9Mg_Ke'];
$Sub_CPMK9 = $_POST['9Sub_CPMK'];
$Materi_Pembelajaran9 = $_POST['9Materi_Pembelajaran'];
$Metode9 = $_POST['9Metode'];
$Indikator9 = $_POST['9Indikator'];
$Bentuk9 = $_POST['9Bentuk'];
$Bobot9 = $_POST['9Bobot'];

$Mg_Ke10 = $_POST['10Mg_Ke'];
$Sub_CPMK10 = $_POST['10Sub_CPMK'];
$Materi_Pembelajaran10 = $_POST['10Materi_Pembelajaran'];
$Metode10 = $_POST['10Metode'];
$Indikator10 = $_POST['10Indikator'];
$Bentuk10 = $_POST['10Bentuk'];
$Bobot10 = $_POST['10Bobot'];

$Mg_Ke11 = $_POST['11Mg_Ke'];
$Sub_CPMK11 = $_POST['11Sub_CPMK'];
$Materi_Pembelajaran11 = $_POST['11Materi_Pembelajaran'];
$Metode11 = $_POST['11Metode'];
$Indikator11 = $_POST['11Indikator'];
$Bentuk11 = $_POST['11Bentuk'];
$Bobot11 = $_POST['11Bobot'];

$Mg_Ke12 = $_POST['12Mg_Ke'];
$Sub_CPMK12 = $_POST['12Sub_CPMK'];
$Materi_Pembelajaran12 = $_POST['12Materi_Pembelajaran'];
$Metode12 = $_POST['12Metode'];
$Indikator12 = $_POST['12Indikator'];
$Bentuk12 = $_POST['12Bentuk'];
$Bobot12 = $_POST['12Bobot'];

$Mg_Ke13 = $_POST['13Mg_Ke'];
$Sub_CPMK13 = $_POST['13Sub_CPMK'];
$Materi_Pembelajaran13 = $_POST['13Materi_Pembelajaran'];
$Metode13 = $_POST['13Metode'];
$Indikator13 = $_POST['13Indikator'];
$Bentuk13 = $_POST['13Bentuk'];
$Bobot13 = $_POST['13Bobot'];

$Mg_Ke14 = $_POST['14Mg_Ke'];
$Sub_CPMK14 = $_POST['14Sub_CPMK'];
$Materi_Pembelajaran14 = $_POST['14Materi_Pembelajaran'];
$Metode14 = $_POST['14Metode'];
$Indikator14 = $_POST['14Indikator'];
$Bentuk14 = $_POST['14Bentuk'];
$Bobot14 = $_POST['14Bobot'];

$Mg_Ke15 = $_POST['15Mg_Ke'];
$Sub_CPMK15 = $_POST['15Sub_CPMK'];
$Materi_Pembelajaran15 = $_POST['15Materi_Pembelajaran'];
$Metode15 = $_POST['15Metode'];
$Indikator15 = $_POST['15Indikator'];
$Bentuk15 = $_POST['15Bentuk'];
$Bobot15 = $_POST['15Bobot'];
 
$Mg_Ke16 = $_POST['16Mg_Ke'];
$Sub_CPMK16 = $_POST['16Sub_CPMK'];
$Materi_Pembelajaran16 = $_POST['16Materi_Pembelajaran'];
$Metode16 = $_POST['16Metode'];
$Indikator16 = $_POST['16Indikator'];
$Bentuk16 = $_POST['16Bentuk'];
$Bobot16 = $_POST['16Bobot'];

$Capaian = $_POST['Capaian'];
$Obyek = $_POST['Obyek'];
$Aktivitas = $_POST['Aktivitas'];
$Metodologi = $_POST['Metodologi'];
$Kriteria_tugas = $_POST['Kriteria_tugas'];
$Kriteria = $_POST['Kriteria'];
$Jadwal = $_POST['Jadwal'];



// tabel ke 2 end //

// Query untuk menyimpan data
$sql = "INSERT INTO tb_rps_1 (Matakuliah, Kode, Rumpun_MK, `Bobot_(SKS)`, Semester, Tanggal_Penyusunan, OTORISASI, 
        Capaian_Pembelajaran, Deskrisi_Singkat_MK, Pustaka, Media_Pembelajaran, Team_Teaching, Matakuliah_Syarat, Dosen, Pengembangan_RPS, Koordinator_MK, Ketua_Prodi, CPLP, CPMK, Sofwer, hardwer, 
        1Mg_Ke,1Sub_CPMK,
1Materi_Pembelajaran,
1Metode,
1Indikator,
1Bentuk,
1Bobot,

2Mg_Ke,
2Sub_CPMK,
2Materi_Pembelajaran,
2Metode,
2Indikator,
2Bentuk,
2Bobot,

3Mg_Ke,
3Sub_CPMK,
3Materi_Pembelajaran,
3Metode,
3Indikator,
3Bentuk,
3Bobot,

4Mg_Ke,
4Sub_CPMK,
4Materi_Pembelajaran,
4Metode,
4Indikator,
4Bentuk,
4Bobot,

5Mg_Ke,
5Sub_CPMK,
5Materi_Pembelajaran,
5Metode,
5Indikator,
5Bentuk,
5Bobot,

6Mg_Ke,
6Sub_CPMK,
6Materi_Pembelajaran,
6Metode,
6Indikator,
6Bentuk,
6Bobot,

7Mg_Ke,
7Sub_CPMK,
7Materi_Pembelajaran,
7Metode,
7Indikator,
7Bentuk,
7Bobot,

8Mg_Ke,
8Sub_CPMK,
8Materi_Pembelajaran,
8Metode,
8Indikator,
8Bentuk,
8Bobot,

9Mg_Ke,
9Sub_CPMK,
9Materi_Pembelajaran,
9Metode,
9Indikator,
9Bentuk,
9Bobot,

10Mg_Ke,
10Sub_CPMK,
10Materi_Pembelajaran,
10Metode,
10Indikator,
10Bentuk,
10Bobot,

11Mg_Ke,
11Sub_CPMK,
11Materi_Pembelajaran,
11Metode,
11Indikator,
11Bentuk,
11Bobot,

12Mg_Ke,
12Sub_CPMK,
12Materi_Pembelajaran,
12Metode,
12Indikator,
12Bentuk,
12Bobot,

13Mg_Ke,
13Sub_CPMK,
13Materi_Pembelajaran,
13Metode,
13Indikator,
13Bentuk,
13Bobot,

14Mg_Ke,
14Sub_CPMK,
14Materi_Pembelajaran,
14Metode,
14Indikator,
14Bentuk,
14Bobot,

15Mg_Ke,
15Sub_CPMK,
15Materi_Pembelajaran,
15Metode,
15Indikator,
15Bentuk,
15Bobot,

16Mg_Ke,
16Sub_CPMK,
16Materi_Pembelajaran,
16Metode,
16Indikator,
16Bentuk,
16Bobot,Capaian, Obyek,Aktivitas,Metodologi,Kriteria_tugas,Kriteria,Jadwal) 
        VALUES ('$Matakuliah', '$Kode', '$Rumpun_MK', '$Bobot_SKS', '$Semester', '$Tanggal_Penyusunan', 
                '$OTORISASI', '$Capaian_Pembelajaran', '$Deskrisi_Singkat_MK', '$Pustaka', '$Media_Pembelajaran', 
                '$Team_Teaching', '$Matakuliah_Syarat', '$Pengembangan_RPS','$Dosen', '$Koordinator_MK', '$Ketua_Prodi', '$CPLP', '$CPMK', '$Sofwer', '$hardwer',
                '$Mg_Ke1','$Sub_CPMK1','$Materi_Pembelajaran1','$Metode1','$Indikator1','$Bentuk1','$Bobot1',

                '$Mg_Ke2',
                '$Sub_CPMK2',
                '$Materi_Pembelajaran2',
                '$Metode2',
                '$Indikator2',
                '$Bentuk2',
                '$Bobot2',
                
'$Mg_Ke3',
'$Sub_CPMK3',
'$Materi_Pembelajaran3',
'$Metode3',
'$Indikator3',
'$Bentuk3',
'$Bobot3',

'$Mg_Ke4',
'$Sub_CPMK4',
'$Materi_Pembelajaran4',
'$Metode4',
'$Indikator4',
'$Bentuk4',
'$Bobot4',

'$Mg_Ke5',
'$Sub_CPMK5',
'$Materi_Pembelajaran5',
'$Metode5',
'$Indikator5',
'$Bentuk5',
'$Bobot5',

'$Mg_Ke6',
'$Sub_CPMK6',
'$Materi_Pembelajaran6',
'$Metode6',
'$Indikator6',
'$Bentuk6',
'$Bobot6',

'$Mg_Ke7',
'$Sub_CPMK7',
'$Materi_Pembelajaran7',
'$Metode7',
'$Indikator7',
'$Bentuk7',
'$Bobot7',

'$Mg_Ke8',
'$Sub_CPMK8',
'$Materi_Pembelajaran8',
'$Metode8',
'$Indikator8',
'$Bentuk8',
'$Bobot8',

'$Mg_Ke9',
'$Sub_CPMK9',
'$Materi_Pembelajaran9',
'$Metode9',
'$Indikator9',
'$Bentuk9',
'$Bobot9',

'$Mg_Ke10',
'$Sub_CPMK10',
'$Materi_Pembelajaran10',
'$Metode10',
'$Indikator10',
'$Bentuk10',
'$Bobot10',

'$Mg_Ke11',
'$Sub_CPMK11',
'$Materi_Pembelajaran11',
'$Metode11',
'$Indikator11',
'$Bentuk11',
'$Bobot11',

'$Mg_Ke12',
'$Sub_CPMK12',
'$Materi_Pembelajaran12',
'$Metode12',
'$Indikator12',
'$Bentuk12',
'$Bobot12',

'$Mg_Ke13',
'$Sub_CPMK13',
'$Materi_Pembelajaran13',
'$Metode13',
'$Indikator13',
'$Bentuk13',
'$Bobot13',

'$Mg_Ke14',
'$Sub_CPMK14',
'$Materi_Pembelajaran14',
'$Metode14',
'$Indikator14',
'$Bentuk14',
'$Bobot14',

'$Mg_Ke15',
'$Sub_CPMK15',
'$Materi_Pembelajaran15',
'$Metode15',
'$Indikator15',
'$Bentuk15',
'$Bobot15',

'$Mg_Ke16',
'$Sub_CPMK16',
'$Materi_Pembelajaran16',
'$Metode16',
'$Indikator16',
'$Bentuk16',
'$Bobot16',

'$Obyek', '$Aktivitas', '$Metodologi' ,'$Kriteria_tugas', '$Kriteria', '$Jadwal', '$Capaian')";

if ($koneksi->query($sql) === TRUE) {
    echo "Data berhasil disimpan!";
} else {
    echo "Error: " . $sql . "<br>" . $koneksi->error;
}

$koneksi->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berhasil</title>
</head>

<body>
    <h1><a href="dashboard_dosen.php">Ke Dashboard RPS</a></h1>
</body>

</html>