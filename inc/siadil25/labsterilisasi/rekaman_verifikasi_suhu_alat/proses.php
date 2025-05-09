<?php
include '../../login/config.php';
session_start();

$data = json_decode(file_get_contents("php://input"));
$request = $data->request;

//tampil awal
if ($request == 'tampil') {
    $ruangid = $_SESSION['ruangid'];
    //ambil data, asumsi 30 hari
    $sql = "SELECT TOP (30) * FROM View_rek_verifikasi_suhu_alat Where ruangid=? ORDER BY tanggal DESC";
    $params = array($ruangid);
    $query = sqlsrv_query($koneksi, $sql, $params);

    $response = array();
    while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $row['tanggal'] = $row['tanggal']->format('Y-m-d'); // Pastikan formatnya Y-m-d
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

//tambah data -- koding ini untuk menghindari sql injection
if ($request == 'create') {
    // Ambil data dari request    
    $ruangid = $data->ruangid ?? '';
    $tanggal = $data->tanggal ?? '';
    $alat = $data->nama_alat ?? '';
    $hasil = $data->hasil_pengukuran ?? '';
    $nilai_set = $data->nilai_set ?? '';
    $idpeg = $data->idpeg ?? '';

    // Debug log untuk data yang diterima    
    //file_put_contents('debug.log', print_r($data, true), FILE_APPEND);

    $success = true; // Flag untuk status sukses

    // Check if the record already exists  
    $checkSql = "SELECT COUNT(*) AS count FROM View_rek_verifikasi_suhu_alat   
                 WHERE tanggal = ? AND ruangid = ?";
    $checkParams = array($tanggal, $ruangid);
    $checkStmt = sqlsrv_query($koneksi, $checkSql, $checkParams);

    if ($checkStmt === false) {
        http_response_code(500);
        echo json_encode(array('message' => 'Gagal memeriksa data yang ada.'));
        exit;
    }

    $checkRow = sqlsrv_fetch_array($checkStmt, SQLSRV_FETCH_ASSOC);
    if ($checkRow['count'] > 0) {
        http_response_code(400);
        echo json_encode(array('message' => 'Anda sudah memasukan data yang sama sebelumnya.'));
        exit;
    }

    // Proceed with the insertion if no duplicate is found
    $sql = "INSERT INTO rekaman_verifikasi_suhu_alat     
                      (nama_alat, tanggal, hasil_pengukuran, nilai_set, idpeg, ruangid)     
                      VALUES (?, ?, ?, ?, ?, ?)";
    $params = array($alat, $tanggal, $hasil, $nilai_set, $idpeg, $ruangid);
    $stmt = sqlsrv_query($koneksi, $sql, $params);
    if ($stmt) {
        $responseItems[] = array(
            "nama_alat" => $alat,
            "tanggal" => $tanggal,
            "hasil_pengukuran" => $hasil,
            "nilai_set" => $nilai_set,
            "idpeg" => $idpeg,
            "ruangid" => $ruangid,
        );
        echo json_encode($response);
    } else {
        http_response_code(500);
        echo json_encode(array('message' => 'Gagal menyimpan data rekaman.'));
    }
    exit;
}

//update
if ($request == 'update') {
    $currentData = $data->currentData;
    $id = $currentData->id;
    $alat = $currentData->nama_alat;
    $tanggal = $currentData->tanggal;
    $hasil = $currentData->hasil_pengukuran;
    $nilai_set = $currentData->nilai_set;
    $idpeg = $currentData->idpeg;
    $ruangid = $currentData->ruangid;

    $sql = sqlsrv_query($koneksi, "UPDATE rekaman_verifikasi_suhu_alat 
        SET nama_alat='$alat', tanggal='$tanggal', hasil_pengukuran='$hasil', nilai_set='$nilai_set', idpeg='$idpeg', ruangid='$ruangid'
        WHERE id=$id");

    if ($sql) {
        echo json_encode($currentData);
    } else {
        http_response_code(500);
        echo json_encode(array('message' => 'Gagal mengupdate data.'));
    }
    exit;
}

//menampilkan seluruh data
if ($request == 'cari_seluruh_data') {
    $sql = sqlsrv_query($koneksi, "SELECT * FROM view_rek_rh_temperatur ORDER BY tgl_kegiatan DESC");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

//mengambil data pegawai
if ($request == 'ambildatapegawai') {
    $query = $data->query;
    $sql = sqlsrv_query($koneksi, "SELECT * FROM pegawai WHERE nama_pegawai LIKE '%$query%'");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

//mengambil data alat
if ($request == 'ambildataalat') {
    $query = $data->query;
    $sql = sqlsrv_query($koneksi, "SELECT nama_alat FROM rekaman_verifikasi_suhu_alat WHERE nama_alat LIKE '%$query%'");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}
