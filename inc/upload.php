<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload RPS</title>
  <link rel="icon" type="image/png" href="logo.jpg" ">  
  
  <style> 
  
  
  * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      display: flex;
      height: 100vh; /* Memastikan body memenuhi tinggi viewport */
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
    }

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
      display: block;
      margin: 10px 0;
      padding: 10px;
      border-radius: 5px;
    }

    .sidebar a:hover {
      background-color: #495057;
    }

    .dropdown {
      position: relative;
    }

    .dropdown-btn {
      background: none;
      border: none;
      color: white;
      text-align: left;
      padding: 10px;
      width: 100%;
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
      display: block;
      padding: 10px;
      color: white;
      text-decoration: none;
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



  .form-container {
    margin-top: 80px;
    margin-left: 80px;
    width: 355%;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    overflow-y: auto;
    max-height: 80vh;
    
    /* Supaya form tetap scrollable jika tinggi melebihi layar */
}

h1 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
    font-size: 24px;
}

form {
    display: flex;
    flex-direction: column;
    gap: 15px;
    

}

label {
    font-weight: bold;
    margin-bottom: 5px;
    font-size: 14px;
}

input[type="text"],
textarea,
input[type="number"],
input[type="date"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
}

textarea {
    resize: vertical;
    min-height: 80px;
}

button {
    width: 100%;
    padding: 12px;
    background-color: #343a40;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

button:hover {
    background-color: lightgray;
}

/* Scroll styling (opsional) */
.form-container::-webkit-scrollbar {
    width: 8px;
}

.form-container::-webkit-scrollbar-thumb {
    background-color: #4CAF50;
    border-radius: 8px;
}</style>



</head>
<body>
  
    <!-- Sidebar -->
  <div class="sidebar">
    <h4><a href="dashboard_dosen.php">Dosen</a></h4>
    <hr>
    <!-- Dropdown RPS -->
    <div class="dropdown">
      <button class="dropdown-btn">RPS</button>
      <ul class="dropdown-menu">
        <li><a href="upload.php">Upload RPS</a></li>
        <li><a href="Akses_RPS.php">Akses RPS</a></li>
      </ul>
    </div>
    <hr>  
    <!-- Profil -->
    <a href="profil.php">Profil</a>
    <a href="Login.php" class="">Logout</a> 
  </div>

    <main>
      <header>
        
         
      </header>

      <div class="form-container">
          <h1>Form Pengisian Data RPS</h1>
          <form action="simpan_data_rps.php" method="POST">
              <label for="Matakuliah">Matakuliah:</label>
              <input type="text" id="Matakuliah" name="Matakuliah" value="<?= htmlspecialchars($row['Matakuliah'] ?? '') ?>" required>

              <label for="Kode">Kode:</label>
              <input type="text" id="Kode" name="Kode" value="<?= htmlspecialchars($row['Kode'] ?? '') ?>" required>

              <label for="Dosen">Dosen:</label>
              <input type="text" id="Dosen" name="Dosen" value="<?= htmlspecialchars($row['Dosen'] ?? '') ?>" required>

              <label for="Rumpun_MK">Rumpun MK:</label>
              <input type="text" id="Rumpun_MK" name="Rumpun_MK" value="<?= htmlspecialchars($row['Rumpun_MK'] ?? '') ?>" required>

              <label for="Bobot_SKS">Bobot (SKS):</label>
              <input type="number" id="Bobot_SKS" name="Bobot_SKS" value="<?= htmlspecialchars($row['Bobot_(SKS)'] ?? '') ?>" required>

              <label for="Semester">Semester:</label>
              <input type="text" id="Semester" name="Semester" value="<?= htmlspecialchars($row['Semester'] ?? '') ?>" required>

              <label for="Tanggal_Penyusunan">Tanggal Penyusunan:</label>
              <input type="date" id="Tanggal_Penyusunan" name="Tanggal_Penyusunan" value="<?= htmlspecialchars($row['Tanggal_Penyusunan'] ?? '') ?>" required>

              <label for="OTORISASI">Otorisasi:</label>
              <input type="text" id="OTORISASI" name="OTORISASI" value="<?= htmlspecialchars($row['OTORISASI'] ?? '') ?>" required>

              <label for="Capaian_Pembelajaran">Capaian Pembelajaran:</label>
              <textarea id="Capaian_Pembelajaran" name="Capaian_Pembelajaran" required><?= htmlspecialchars($row['Capaian_Pembelajaran'] ?? '') ?></textarea>

              <label for="Deskripsi_Singkat_MK">Deskripsi Singkat MK:</label>
              <textarea id="Deskripsi_Singkat_MK" name="Deskripsi_Singkat_MK" required><?= htmlspecialchars($row['Deskrisi_Singkat_MK'] ?? '') ?></textarea>

              <label for="Pustaka">Pustaka:</label>
              <textarea id="Pustaka" name="Pustaka" required><?= htmlspecialchars($row['Pustaka'] ?? '') ?></textarea>

              <label for="Media_Pembelajaran">Media Pembelajaran:</label>
              <textarea id="Media_Pembelajaran" name="Media_Pembelajaran" required><?= htmlspecialchars($row['Media_Pembelajaran'] ?? '') ?></textarea>

              <label for="Team_Teaching">Team Teaching:</label>
              <input type="text" id="Team_Teaching" name="Team_Teaching" value="<?= htmlspecialchars($row['Team_Teaching'] ?? '') ?>">

              <label for="Matakuliah_Syarat">Matakuliah Syarat:</label>
              <input type="text" id="Matakuliah_Syarat" name="Matakuliah_Syarat" value="<?= htmlspecialchars($row['Matakuliah_Syarat'] ?? '') ?>">

              <label for="Pengembangan_RPS">Pengembangan RPS:</label>
              <input type="text" id="Pengembangan_RPS" name="Pengembangan_RPS" value="<?= htmlspecialchars($row['Pengembangan_RPS'] ?? '') ?>" required>

              <label for="Koordinator_MK">Koordinator MK:</label>
              <input type="text" id="Koordinator_MK" name="Koordinator_MK" value="<?= htmlspecialchars($row['Koordinator_MK'] ?? '') ?>" required>

              <label for="Ketua_Prodi">Ketua Prodi:</label>
              <input type="text" id="Ketua_Prodi" name="Ketua_Prodi" value="<?= htmlspecialchars($row['Ketua_Prodi'] ?? '') ?>" required>

              <label for="CPLP">Pustaka:</label>
              <textarea id="CPLP" name="CPLP" required><?= htmlspecialchars($row['CPLP'] ?? '') ?></textarea>

              <label for="CPMK">CP Mata Kuliah (CPMK):</label>
              <textarea id="CPMK" name="CPMK" required><?= htmlspecialchars($row['CPMK'] ?? '') ?></textarea>

              <label for="Sofwer">Perangkat lunak (Software):</label>
              <input type="text" id="Sofwer" name="Sofwer" value="<?= htmlspecialchars($row['Sofwer'] ?? '') ?>" required>

              <label for="hardwer">Perangkat keras (Hardware):</label>
              <input type="text" id="hardwer" name="hardwer" value="<?= htmlspecialchars($row['hardwer'] ?? '') ?>" required>

              <form action="simpan_data_rps.php" method="POST">
                  <!-- Set 1 -->
                  <label for="1Mg_Ke">1 Mg_Ke:</label>
                  <input type="text" id="1Mg_Ke" name="1Mg_Ke" value="<?= htmlspecialchars($row['1Mg_Ke'] ?? '') ?>">

                  <label for="1Sub_CPMK">1. Sub_CPMK:</label>
                  <input type="text" id="1Sub_CPMK" name="1Sub_CPMK" value="<?= htmlspecialchars($row['1Sub_CPMK'] ?? '') ?>">

                  <label for="1Materi_Pembelajaran">1. Materi Pembelajaran:</label>
                  <input type="text" id="1Materi_Pembelajaran" name="1Materi_Pembelajaran" value="<?= htmlspecialchars($row['1Materi_Pembelajaran'] ?? '') ?>">

                  <label for="1Metode">1. Metode:</label>
                  <input type="text" id="1Metode" name="1Metode" value="<?= htmlspecialchars($row['1Metode'] ?? '') ?>">

                  <label for="1Indikator">1. Indikator:</label>
                  <input type="text" id="1Indikator" name="1Indikator" value="<?= htmlspecialchars($row['1Indikator'] ?? '') ?>">

                  <label for="1Bentuk">1. Bentuk:</label>
                  <input type="text" id="1Bentuk" name="1Bentuk" value="<?= htmlspecialchars($row['1Bentuk'] ?? '') ?>">

                  <label for="1Bobot">1. Bobot:</label>
                  <input type="text" id="1Bobot" name="1Bobot" value="<?= htmlspecialchars($row['1Bobot'] ?? '') ?>">

                  <!-- Set 2 -->
                  <label for="2Mg_Ke">2. Mg_Ke:</label>
                  <input type="text" id="2Mg_Ke" name="2Mg_Ke" value="<?= htmlspecialchars($row['2Mg_Ke'] ?? '') ?>">

                  <label for="2Sub_CPMK">2Sub_CPMK:</label>
                  <input type="text" id="2Sub_CPMK" name="2Sub_CPMK" value="<?= htmlspecialchars($row['2Sub_CPMK'] ?? '') ?>">

                  <label for="2Materi_Pembelajaran">2Materi Pembelajaran:</label>
                  <input type="text" id="2Materi_Pembelajaran" name="2Materi_Pembelajaran" value="<?= htmlspecialchars($row['2Materi_Pembelajaran'] ?? '') ?>">

                  <label for="2Metode">2Metode:</label>
                  <input type="text" id="2Metode" name="2Metode" value="<?= htmlspecialchars($row['2Metode'] ?? '') ?>">

                  <label for="2Indikator">2Indikator:</label>
                  <input type="text" id="2Indikator" name="2Indikator" value="<?= htmlspecialchars($row['2Indikator'] ?? '') ?>">

                  <label for="2Bentuk">2Bentuk:</label>
                  <input type="text" id="2Bentuk" name="2Bentuk" value="<?= htmlspecialchars($row['2Bentuk'] ?? '') ?>">

                  <label for="2Bobot">2Bobot:</label>
                  <input type="text" id="2Bobot" name="2Bobot" value="<?= htmlspecialchars($row['2Bobot'] ?? '') ?>">

                  <!-- Set 3 -->
                  <label for="3Mg_Ke">3Mg_Ke:</label>
                  <input type="text" id="3Mg_Ke" name="3Mg_Ke" value="<?= htmlspecialchars($row['3Mg_Ke'] ?? '') ?>">

                  <label for="3Sub_CPMK">3Sub_CPMK:</label>
                  <input type="text" id="3Sub_CPMK" name="3Sub_CPMK" value="<?= htmlspecialchars($row['3Sub_CPMK'] ?? '') ?>">

                  <label for="3Materi_Pembelajaran">3Materi Pembelajaran:</label>
                  <input type="text" id="3Materi_Pembelajaran" name="3Materi_Pembelajaran" value="<?= htmlspecialchars($row['3Materi_Pembelajaran'] ?? '') ?>">

                  <label for="3Metode">3Metode:</label>
                  <input type="text" id="3Metode" name="3Metode" value="<?= htmlspecialchars($row['3Metode'] ?? '') ?>">

                  <label for="3Indikator">3Indikator:</label>
                  <input type="text" id="3Indikator" name="3Indikator" value="<?= htmlspecialchars($row['3Indikator'] ?? '') ?>">

                  <label for="3Bentuk">3Bentuk:</label>
                  <input type="text" id="3Bentuk" name="3Bentuk" value="<?= htmlspecialchars($row['3Bentuk'] ?? '') ?>">

                  <label for="3Bobot">3Bobot:</label>
                  <input type="text" id="3Bobot" name="3Bobot" value="<?= htmlspecialchars($row['3Bobot'] ?? '') ?>">

                  <!-- Set 4 -->
                  <label for="4Mg_Ke">4Mg_Ke:</label>
                  <input type="text" id="4Mg_Ke" name="4Mg_Ke" value="<?= htmlspecialchars($row['4Mg_Ke'] ?? '') ?>">

                  <label for="4Sub_CPMK">4Sub_CPMK:</label>
                  <input type="text" id="4Sub_CPMK" name="4Sub_CPMK" value="<?= htmlspecialchars($row['4Sub_CPMK'] ?? '') ?>">

                  <label for="4Materi_Pembelajaran">4Materi Pembelajaran:</label>
                  <input type="text" id="4Materi_Pembelajaran" name="4Materi_Pembelajaran" value="<?= htmlspecialchars($row['4Materi_Pembelajaran'] ?? '') ?>">

                  <label for="4Metode">4Metode:</label>
                  <input type="text" id="4Metode" name="4Metode" value="<?= htmlspecialchars($row['4Metode'] ?? '') ?>">

                  <label for="4Indikator">4Indikator:</label>
                  <input type="text" id="4Indikator" name="4Indikator" value="<?= htmlspecialchars($row['4Indikator'] ?? '') ?>">

                  <label for="4Bentuk">4Bentuk:</label>
                  <input type="text" id="4Bentuk" name="4Bentuk" value="<?= htmlspecialchars($row['4Bentuk'] ?? '') ?>">

                  <label for="4Bobot">4Bobot:</label>
                  <input type="text" id="4Bobot" name="4Bobot" value="<?= htmlspecialchars($row['4Bobot'] ?? '') ?>">

                  <!-- Set 5 -->
                  <label for="5Mg_Ke">5Mg_Ke:</label>
                  <input type="text" id="5Mg_Ke" name="5Mg_Ke" value="<?= htmlspecialchars($row['5Mg_Ke'] ?? '') ?>">

                  <label for="5Sub_CPMK">5Sub_CPMK:</label>
                  <input type="text" id="5Sub_CPMK" name="5Sub_CPMK" value="<?= htmlspecialchars($row['5Sub_CPMK'] ?? '') ?>">

                  <label for="5Materi_Pembelajaran">5Materi Pembelajaran:</label>
                  <input type="text" id="5Materi_Pembelajaran" name="5Materi_Pembelajaran" value="<?= htmlspecialchars($row['5Materi_Pembelajaran'] ?? '') ?>">

                  <label for="5Metode">5Metode:</label>
                  <input type="text" id="5Metode" name="5Metode" value="<?= htmlspecialchars($row['5Metode'] ?? '') ?>">

                  <label for="5Indikator">5Indikator:</label>
                  <input type="text" id="5Indikator" name="5Indikator" value="<?= htmlspecialchars($row['5Indikator'] ?? '') ?>">

                  <label for="5Bentuk">5Bentuk:</label>
                  <input type="text" id="5Bentuk" name="5Bentuk" value="<?= htmlspecialchars($row['5Bentuk'] ?? '') ?>">

                  <label for="5Bobot">5Bobot:</label>
                  <input type="text" id="5Bobot" name="5Bobot" value="<?= htmlspecialchars($row['5Bobot'] ?? '') ?>">

                  <!-- Set 6 -->
                  <label for="6Mg_Ke">6Mg_Ke:</label>
                  <input type="text" id="6Mg_Ke" name="6Mg_Ke" value="<?= htmlspecialchars($row['6Mg_Ke'] ?? '') ?>">

                  <label for="6Sub_CPMK">6Sub_CPMK:</label>
                  <input type="text" id="6Sub_CPMK" name="6Sub_CPMK" value="<?= htmlspecialchars($row['6Sub_CPMK'] ?? '') ?>">

                  <label for="6Materi_Pembelajaran">6Materi Pembelajaran:</label>
                  <input type="text" id="6Materi_Pembelajaran" name="6Materi_Pembelajaran" value="<?= htmlspecialchars($row['6Materi_Pembelajaran'] ?? '') ?>">

                  <label for="6Metode">6Metode:</label>
                  <input type="text" id="6Metode" name="6Metode" value="<?= htmlspecialchars($row['6Metode'] ?? '') ?>">

                  <label for="6Indikator">6Indikator:</label>
                  <input type="text" id="6Indikator" name="6Indikator" value="<?= htmlspecialchars($row['6Indikator'] ?? '') ?>">

                  <label for="6Bentuk">6Bentuk:</label>
                  <input type="text" id="6Bentuk" name="6Bentuk" value="<?= htmlspecialchars($row['6Bentuk'] ?? '') ?>">

                  <label for="6Bobot">6Bobot:</label>
                  <input type="text" id="6Bobot" name="6Bobot" value="<?= htmlspecialchars($row['6Bobot'] ?? '') ?>">

                  <!-- Set 7 -->
                  <label for="7Mg_Ke">7Mg_Ke:</label>
                  <input type="text" id="7Mg_Ke" name="7Mg_Ke" value="<?= htmlspecialchars($row['7Mg_Ke'] ?? '') ?>">

                  <label for="7Sub_CPMK">7Sub_CPMK:</label>
                  <input type="text" id="7Sub_CPMK" name="7Sub_CPMK" value="<?= htmlspecialchars($row['7Sub_CPMK'] ?? '') ?>">

                  <label for="7Materi_Pembelajaran">7Materi Pembelajaran:</label>
                  <input type="text" id="7Materi_Pembelajaran" name="7Materi_Pembelajaran" value="<?= htmlspecialchars($row['7Materi_Pembelajaran'] ?? '') ?>">

                  <label for="7Metode">7Metode:</label>
                  <input type="text" id="7Metode" name="7Metode" value="<?= htmlspecialchars($row['7Metode'] ?? '') ?>">

                  <label for="7Indikator">7Indikator:</label>
                  <input type="text" id="7Indikator" name="7Indikator" value="<?= htmlspecialchars($row['7Indikator'] ?? '') ?>">

                  <label for="7Bentuk">7Bentuk:</label>
                  <input type="text" id="7Bentuk" name="7Bentuk" value="<?= htmlspecialchars($row['7Bentuk'] ?? '') ?>">

                  <label for="7Bobot">7Bobot:</label>
                  <input type="text" id="7Bobot" name="7Bobot" value="<?= htmlspecialchars($row['7Bobot'] ?? '') ?>">

                  <!-- Set 8 -->
                  <label for="8Mg_Ke">8Mg_Ke:</label>
                  <input type="text" id="8Mg_Ke" name="8Mg_Ke" value="<?= htmlspecialchars($row['8Mg_Ke'] ?? '') ?>">

                  <label for="8Sub_CPMK">8Sub_CPMK:</label>
                  <input type="text" id="8Sub_CPMK" name="8Sub_CPMK" value="<?= htmlspecialchars($row['8Sub_CPMK'] ?? '') ?>">

                  <label for="8Materi_Pembelajaran">8Materi Pembelajaran:</label>
                  <input type="text" id="8Materi_Pembelajaran" name="8Materi_Pembelajaran" value="<?= htmlspecialchars($row['8Materi_Pembelajaran'] ?? '') ?>">

                  <label for="8Metode">8Metode:</label>
                  <input type="text" id="8Metode" name="8Metode" value="<?= htmlspecialchars($row['8Metode'] ?? '') ?>">

                  <label for="8Indikator">8Indikator:</label>
                  <input type="text" id="8Indikator" name="8Indikator" value="<?= htmlspecialchars($row['8Indikator'] ?? '') ?>">

                  <label for="8Bentuk">8Bentuk:</label>
                  <input type="text" id="8Bentuk" name="8Bentuk" value="<?= htmlspecialchars($row['8Bentuk'] ?? '') ?>">

                  <label for="8Bobot">8Bobot:</label>
                  <input type="text" id="8Bobot" name="8Bobot" value="<?= htmlspecialchars($row['8Bobot'] ?? '') ?>">

                  <!-- Set 9 -->
                  <label for="9Mg_Ke">9Mg_Ke:</label>
                  <input type="text" id="9Mg_Ke" name="9Mg_Ke" value="<?= htmlspecialchars($row['9Mg_Ke'] ?? '') ?>">

                  <label for="9Sub_CPMK">9Sub_CPMK:</label>
                  <input type="text" id="9Sub_CPMK" name="9Sub_CPMK" value="<?= htmlspecialchars($row['9Sub_CPMK'] ?? '') ?>">

                  <label for="9Materi_Pembelajaran">9Materi Pembelajaran:</label>
                  <input type="text" id="9Materi_Pembelajaran" name="9Materi_Pembelajaran" value="<?= htmlspecialchars($row['9Materi_Pembelajaran'] ?? '') ?>">

                  <label for="9Metode">9Metode:</label>
                  <input type="text" id="9Metode" name="9Metode" value="<?= htmlspecialchars($row['9Metode'] ?? '') ?>">

                  <label for="9Indikator">9Indikator:</label>
                  <input type="text" id="9Indikator" name="9Indikator" value="<?= htmlspecialchars($row['9Indikator'] ?? '') ?>">

                  <label for="9Bentuk">9Bentuk:</label>
                  <input type="text" id="9Bentuk" name="9Bentuk" value="<?= htmlspecialchars($row['9Bentuk'] ?? '') ?>">

                  <label for="9Bobot">9Bobot:</label>
                  <input type="text" id="9Bobot" name="9Bobot" value="<?= htmlspecialchars($row['9Bobot'] ?? '') ?>">

                  <!-- Set 10 -->
                  <label for="10Mg_Ke">10Mg_Ke:</label>
                  <input type="text" id="10Mg_Ke" name="10Mg_Ke" value="<?= htmlspecialchars($row['10Mg_Ke'] ?? '') ?>">

                  <label for="10Sub_CPMK">10Sub_CPMK:</label>
                  <input type="text" id="10Sub_CPMK" name="10Sub_CPMK" value="<?= htmlspecialchars($row['10Sub_CPMK'] ?? '') ?>">

                  <label for="10Materi_Pembelajaran">10Materi Pembelajaran:</label>
                  <input type="text" id="10Materi_Pembelajaran" name="10Materi_Pembelajaran" value="<?= htmlspecialchars($row['10Materi_Pembelajaran'] ?? '') ?>">

                  <label for="10Metode">10Metode:</label>
                  <input type="text" id="10Metode" name="10Metode" value="<?= htmlspecialchars($row['10Metode'] ?? '') ?>">

                  <label for="10Indikator">10Indikator:</label>
                  <input type="text" id="10Indikator" name="10Indikator" value="<?= htmlspecialchars($row['10Indikator'] ?? '') ?>">

                  <label for="10Bentuk">10Bentuk:</label>
                  <input type="text" id="10Bentuk" name="10Bentuk" value="<?= htmlspecialchars($row['10Bentuk'] ?? '') ?>">

                  <label for="10Bobot">10Bobot:</label>
                  <input type="text" id="10Bobot" name="10Bobot" value="<?= htmlspecialchars($row['10Bobot'] ?? '') ?>">

                  <!-- Set 11 -->
                  <label for="11Mg_Ke">11Mg_Ke:</label>
                  <input type="text" id="11Mg_Ke" name="11Mg_Ke" value="<?= htmlspecialchars($row['11Mg_Ke'] ?? '') ?>">

                  <label for="11Sub_CPMK">11Sub_CPMK:</label>
                  <input type="text" id="11Sub_CPMK" name="11Sub_CPMK" value="<?= htmlspecialchars($row['11Sub_CPMK'] ?? '') ?>">

                  <label for="11Materi_Pembelajaran">11Materi Pembelajaran:</label>
                  <input type="text" id="11Materi_Pembelajaran" name="11Materi_Pembelajaran" value="<?= htmlspecialchars($row['11Materi_Pembelajaran'] ?? '') ?>">

                  <label for="11Metode">11Metode:</label>
                  <input type="text" id="11Metode" name="11Metode" value="<?= htmlspecialchars($row['11Metode'] ?? '') ?>">

                  <label for="11Indikator">11Indikator:</label>
                  <input type="text" id="11Indikator" name="11Indikator" value="<?= htmlspecialchars($row['11Indikator'] ?? '') ?>">

                  <label for="11Bentuk">11Bentuk:</label>
                  <input type="text" id="11Bentuk" name="11Bentuk" value="<?= htmlspecialchars($row['11Bentuk'] ?? '') ?>">

                  <label for="11Bobot">11Bobot:</label>
                  <input type="text" id="11Bobot" name="11Bobot" value="<?= htmlspecialchars($row['11Bobot'] ?? '') ?>">

                  <!-- Set 12 -->
                  <label for="12Mg_Ke">12Mg_Ke:</label>
                  <input type="text" id="12Mg_Ke" name="12Mg_Ke" value="<?= htmlspecialchars($row['12Mg_Ke'] ?? '') ?>">

                  <label for="12Sub_CPMK">12Sub_CPMK:</label>
                  <input type="text" id="12Sub_CPMK" name="12Sub_CPMK" value="<?= htmlspecialchars($row['12Sub_CPMK'] ?? '') ?>">

                  <label for="12Materi_Pembelajaran">12Materi Pembelajaran:</label>
                  <input type="text" id="12Materi_Pembelajaran" name="12Materi_Pembelajaran" value="<?= htmlspecialchars($row['12Materi_Pembelajaran'] ?? '') ?>">

                  <label for="12Metode">12Metode:</label>
                  <input type="text" id="12Metode" name="12Metode" value="<?= htmlspecialchars($row['12Metode'] ?? '') ?>">

                  <label for="12Indikator">12Indikator:</label>
                  <input type="text" id="12Indikator" name="12Indikator" value="<?= htmlspecialchars($row['12Indikator'] ?? '') ?>">

                  <label for="12Bentuk">12Bentuk:</label>
                  <input type="text" id="12Bentuk" name="12Bentuk" value="<?= htmlspecialchars($row['12Bentuk'] ?? '') ?>">

                  <label for="12Bobot">12Bobot:</label>
                  <input type="text" id="12Bobot" name="12Bobot" value="<?= htmlspecialchars($row['12Bobot'] ?? '') ?>">

                  <!-- Set 13 -->
                  <label for="13Mg_Ke">13Mg_Ke:</label>
                  <input type="text" id="13Mg_Ke" name="13Mg_Ke" value="<?= htmlspecialchars($row['13Mg_Ke'] ?? '') ?>">

                  <label for="13Sub_CPMK">13Sub_CPMK:</label>
                  <input type="text" id="13Sub_CPMK" name="13Sub_CPMK" value="<?= htmlspecialchars($row['13Sub_CPMK'] ?? '') ?>">

                  <label for="13Materi_Pembelajaran">13Materi Pembelajaran:</label>
                  <input type="text" id="13Materi_Pembelajaran" name="13Materi_Pembelajaran" value="<?= htmlspecialchars($row['13Materi_Pembelajaran'] ?? '') ?>">

                  <label for="13Metode">13Metode:</label>
                  <input type="text" id="13Metode" name="13Metode" value="<?= htmlspecialchars($row['13Metode'] ?? '') ?>">

                  <label for="13Indikator">13Indikator:</label>
                  <input type="text" id="13Indikator" name="13Indikator" value="<?= htmlspecialchars($row['13Indikator'] ?? '') ?>">

                  <label for="13Bentuk">13Bentuk:</label>
                  <input type="text" id="13Bentuk" name="13Bentuk" value="<?= htmlspecialchars($row['13Bentuk'] ?? '') ?>">

                  <label for="13Bobot">13Bobot:</label>
                  <input type="text" id="13Bobot" name="13Bobot" value="<?= htmlspecialchars($row['13Bobot'] ?? '') ?>">

                  <!-- Set 14 -->
                  <label for="14Mg_Ke">14Mg_Ke:</label>
                  <input type="text" id="14Mg_Ke" name="14Mg_Ke" value="<?= htmlspecialchars($row['14Mg_Ke'] ?? '') ?>">

                  <label for="14Sub_CPMK">14Sub_CPMK:</label>
                  <input type="text" id="14Sub_CPMK" name="14Sub_CPMK" value="<?= htmlspecialchars($row['14Sub_CPMK'] ?? '') ?>">

                  <label for="14Materi_Pembelajaran">14Materi Pembelajaran:</label>
                  <input type="text" id="14Materi_Pembelajaran" name="14Materi_Pembelajaran" value="<?= htmlspecialchars($row['14Materi_Pembelajaran'] ?? '') ?>">

                  <label for="14Metode">14Metode:</label>
                  <input type="text" id="14Metode" name="14Metode" value="<?= htmlspecialchars($row['14Metode'] ?? '') ?>">

                  <label for="14Indikator">14Indikator:</label>
                  <input type="text" id="14Indikator" name="14Indikator" value="<?= htmlspecialchars($row['14Indikator'] ?? '') ?>">

                  <label for="14Bentuk">14Bentuk:</label>
                  <input type="text" id="14Bentuk" name="14Bentuk" value="<?= htmlspecialchars($row['14Bentuk'] ?? '') ?>">

                  <label for="14Bobot">14Bobot:</label>
                  <input type="text" id="14Bobot" name="14Bobot" value="<?= htmlspecialchars($row['14Bobot'] ?? '') ?>">

                  <!-- Set 15 -->
                  <label for="15Mg_Ke">15Mg_Ke:</label>
                  <input type="text" id="15Mg_Ke" name="15Mg_Ke" value="<?= htmlspecialchars($row['15Mg_Ke'] ?? '') ?>">

                  <label for="15Sub_CPMK">15Sub_CPMK:</label>
                  <input type="text" id="15Sub_CPMK" name="15Sub_CPMK" value="<?= htmlspecialchars($row['15Sub_CPMK'] ?? '') ?>">

                  <label for="15Materi_Pembelajaran">15Materi Pembelajaran:</label>
                  <input type="text" id="15Materi_Pembelajaran" name="15Materi_Pembelajaran" value="<?= htmlspecialchars($row['15Materi_Pembelajaran'] ?? '') ?>">

                  <label for="15Metode">15Metode:</label>
                  <input type="text" id="15Metode" name="15Metode" value="<?= htmlspecialchars($row['15Metode'] ?? '') ?>">

                  <label for="15Indikator">15Indikator:</label>
                  <input type="text" id="15Indikator" name="15Indikator" value="<?= htmlspecialchars($row['15Indikator'] ?? '') ?>">

                  <label for="15Bentuk">15Bentuk:</label>
                  <input type="text" id="15Bentuk" name="15Bentuk" value="<?= htmlspecialchars($row['15Bentuk'] ?? '') ?>">

                  <label for="15Bobot">15Bobot:</label>
                  <input type="text" id="15Bobot" name="15Bobot" value="<?= htmlspecialchars($row['15Bobot'] ?? '') ?>">

                  <!-- Set 16 -->
                  <label for="16Mg_Ke">16Mg_Ke:</label>
                  <input type="text" id="16Mg_Ke" name="16Mg_Ke" value="<?= htmlspecialchars($row['16Mg_Ke'] ?? '') ?>">

                  <label for="16Sub_CPMK">16Sub_CPMK:</label>
                  <input type="text" id="16Sub_CPMK" name="16Sub_CPMK" value="<?= htmlspecialchars($row['16Sub_CPMK'] ?? '') ?>">

                  <label for="16Materi_Pembelajaran">16Materi Pembelajaran:</label>
                  <input type="text" id="16Materi_Pembelajaran" name="16Materi_Pembelajaran" value="<?= htmlspecialchars($row['16Materi_Pembelajaran'] ?? '') ?>">

                  <label for="16Metode">16Metode:</label>
                  <input type="text" id="16Metode" name="16Metode" value="<?= htmlspecialchars($row['16Metode'] ?? '') ?>">

                  <label for="16Indikator">16Indikator:</label>
                  <input type="text" id="16Indikator" name="16Indikator" value="<?= htmlspecialchars($row['16Indikator'] ?? '') ?>">

                  <label for="16Bentuk">16Bentuk:</label>
                  <input type="text" id="16Bentuk" name="16Bentuk" value="<?= htmlspecialchars($row['16Bentuk'] ?? '') ?>">

                  <label for="16Bobot">16Bobot:</label>
                  <input type="text" id="16Bobot" name="16Bobot" value="<?= htmlspecialchars($row['16Bobot'] ?? '') ?>">


                  <label for="Capaian">Capaian Pembelajaran MK  :</label>
                  <input type="text" id="Capaian" name="Capaian" value="<?= htmlspecialchars($row['Capaian'] ?? '') ?>" required>

                  <label for="Obyek">Object_Garapan :</label>
                  <input type="text" id="Obyek" name="Obyek" value="<?= htmlspecialchars($row['Obyek'] ?? '') ?>" required>

                  <label for="Aktivitas">Aktivitas :</label>
                  <input type="text" id="Aktivitas" name="Aktivitas" value="<?= htmlspecialchars($row['Aktivitas'] ?? '') ?>" required>
                  
                  <label for="Metodologi">Metodologi & Cara pengerjaannya :</label>
                  <input type="text" id="Metodologi" name="Metodologi" value="<?= htmlspecialchars($row['Metodologi'] ?? '') ?>" required>
                  
                  <label for="Kriteria_tugas">Kriteria luaran tugas yang dihasilkan :</label>
                  <input type="text" id="Kriteria_tugas" name="Kriteria_tugas" value="<?= htmlspecialchars($row['Kriteria_tugas'] ?? '') ?>" required>

                  <label for="Kriteria">Kriteria Penilaian :</label>
                  <input type="text" id="Kriteria" name="Kriteria" value="<?= htmlspecialchars($row['Kriteria'] ?? '') ?>" required>

                  <label for="Jadwal">Jadwal Pelaksanaan :</label>
                  <input type="text" id="Jadwal" name="Jadwal" value="<?= htmlspecialchars($row['Jadwal'] ?? '') ?>" required>


                  <button type="submit">Simpan Data</button>
              </form>


      </div>
  </main>
  <script>
    // Mengatur dropdown untuk membuka dan menutup menu
    document.querySelector('.dropdown-btn').addEventListener('click', function () {
      const dropdownMenu = this.nextElementSibling;
      dropdownMenu.classList.toggle('active');
    });
  </script>

</body>
</html>
