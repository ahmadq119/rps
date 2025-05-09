<?php
include '../../login/config.php';

$data = json_decode(file_get_contents("php://input"));
//Penanganan Upload
// Enable error reporting  
error_reporting(E_ALL);
ini_set('display_errors', 1);
$request = $_POST['request'] ?? ''; // Gunakan $_POST, karena FormData tidak dikirim sebagai JSON

if ($request == "updateFileUpload") {
    if (!isset($_FILES['file'])) {
        echo json_encode(["success" => false, "message" => "File tidak ditemukan."]);
        exit;
    }

    $kd_sample = $_POST['kd_sample'] ?? '';
    $ket_file = $_POST['ket_file'] ?? '';
    $file = $_FILES['file'];

    // Validasi hanya menerima file gambar  
    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
    $allowedExtensions = ['jpeg', 'png', 'jpg', 'gif'];

    // Periksa MIME Type  
    if (!in_array($file['type'], $allowedTypes)) {
        echo json_encode(["success" => false, "message" => "Format file tidak didukung. Hanya gambar diperbolehkan."]);
        exit;
    }

    // Periksa Ukuran File (Maksimal 5MB)  
    if ($file['size'] > 5 * 1024 * 1024) {
        echo json_encode(["success" => false, "message" => "Ukuran file terlalu besar, maksimal 5MB."]);
        exit;
    }

    // Dapatkan ekstensi file yang valid  
    $fileNameParts = explode('.', $file['name']);
    $fileExtension = strtolower(end($fileNameParts));

    if (!in_array($fileExtension, $allowedExtensions)) {
        echo json_encode(["success" => false, "message" => "Ekstensi file tidak valid."]);
        exit;
    }

    // Buat folder jika belum ada  
    $uploadDir = '../../file_labformalin/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Ubah nama file sesuai kd_sample  
    $new_kd_sample = str_replace('/', '', $kd_sample);
    $new_filename = $new_kd_sample . '-' . basename($file['name']);
    $filePath = $uploadDir . $new_filename;

    // Pindahkan file ke lokasi yang diinginkan  
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        // Simpan nama file ke database  
        $sql = "UPDATE sample_labformalin SET nama_file = ?, ket_file = ? WHERE kd_sample = ?";
        $params = array($new_filename, $ket_file, $kd_sample);

        $stmt = sqlsrv_query($koneksi, $sql, $params);

        if ($stmt === false) {
            echo json_encode(["success" => false, "message" => "Gagal menyimpan ke database.", "error" => sqlsrv_errors()]);
        } else {
            echo json_encode(["success" => true, "message" => "File berhasil diunggah!", "file_url" => $uploadDir . $new_filename]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Gagal mengunggah file ke server."]);
    }
    exit;
}
