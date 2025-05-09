<?php
include('config.php');

$username = "";
$alamat = "";
$password = "";
$nip = "";
$level = "";
$no_hp = "";
$nama_lengkap = ""; // Variabel untuk nama lengkap
$sukses = "";
$eror = "";

if (isset($_POST['simpan'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $password_plain = $_POST['password']; // Mengambil password sebelum di-hash
    $nip = mysqli_real_escape_string($koneksi, $_POST['nip']);
    $level = mysqli_real_escape_string($koneksi, $_POST['level']);
    $no_hp = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']); // Ambil nama lengkap

    // Enkripsi password menggunakan MD5
    $password_md5 = md5($password_plain);

    // Validasi input
    if ($username && $alamat && $password_plain && $nip && $level && $no_hp && $nama_lengkap) {
        $sql1 = "INSERT INTO login (username, alamat, password, nip, level, no_hp, nama_lengkap) 
                 VALUES ('$username', '$alamat', '$password_md5', '$nip', '$level', '$no_hp', '$nama_lengkap')";
        $q1 = mysqli_query($koneksi, $sql1);

        if ($q1) {
            $sukses = "Berhasil memasukkan data baru";
            header('Location: admin.php');
            exit();
        } else {
            $eror = "Gagal memasukkan data: " . mysqli_error($koneksi);
        }
    } else {
        $eror = "Harap isi semua data!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengisian Data RPS</title>
    <style>
        /* Tambahkan gaya CSS Anda di sini */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 90vh;
            margin: 0;
        }

        .form-container {
            width: 100%;
            max-width: 600px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        input[type="text"], input[type="password"], select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }

        button:hover {
            background-color: #45a049;
        }

        .alert {
            margin-top: 15px;
            padding: 10px;
            color: white;
            border-radius: 5px;
        }

        .alert-danger {
            background-color: #f44336;
        }

        .alert-success {
            background-color: #4CAF50;
        }
    </style>
</head>
<body>

<div class="form-container">

    <h1>Penambahan User</h1>

    <form action="" method="POST">
        <?php if ($eror): ?>
            <div class="alert alert-danger">
                <?php echo $eror; ?>
            </div>
        <?php endif; ?>

        <?php if ($sukses): ?>
            <div class="alert alert-success">
                <?php echo $sukses; ?>
            </div>
        <?php endif; ?>

        <label for="username">User:</label>
        <input type="text" id="username" name="username" required>

        <label for="nama_lengkap">Nama Lengkap:</label>
        <input type="text" id="nama_lengkap" name="nama_lengkap" required>

        <label for="alamat">Alamat:</label>
        <input type="text" id="alamat" name="alamat" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="nip">NIP:</label>
        <input type="text" id="nip" name="nip" required>

        <label for="no_hp">No HP:</label>
        <input type="text" id="no_hp" name="no_hp" required>

        <label for="level">Level:</label>
        <select name="level" id="level" required>
            <option value="">-- Pilih Level --</option>
            <option value="admin">Admin</option>
            <option value="dosen">Dosen</option>
        </select>

        <button type="submit" name="simpan">Simpan Data</button>
    </form>
</div>

</body>
</html>
