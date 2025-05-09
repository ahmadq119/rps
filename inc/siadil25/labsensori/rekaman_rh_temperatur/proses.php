<?php
include '../../login/config.php';
session_start();

$data = json_decode(file_get_contents("php://input"));
$request = $data->request;

//tampil awal
if ($request == 'tampil') {
    $ruangid = $_SESSION['ruangid'];
    $sql = "SELECT * FROM view_rek_rh_temperatur Where ruangid=? ORDER BY tgl_kegiatan DESC";
    $params = array($ruangid);
    $query = sqlsrv_query($koneksi, $sql, $params);

    $response = array();
    while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $row['tgl_kegiatan'] = $row['tgl_kegiatan']->format('Y-m-d'); // Pastikan formatnya Y-m-d
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

//tampil awal
if ($request == 'tampil365') {
    $ruangid = $_SESSION['ruangid'];
    $jumlah = (int)$data->jumlah;
    //echo "Jumlah yang diminta: " . $jumlah . "\n"; // Cek jumlah yang diminta
    $sql = "SELECT TOP $jumlah * FROM view_rek_rh_temperatur Where ruangid=? ORDER BY tgl_kegiatan DESC";
    $params = array($ruangid);
    $query = sqlsrv_query($koneksi, $sql, $params);

    $response = array();
    while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $row['tgl_kegiatan'] = $row['tgl_kegiatan']->format('Y-m-d'); // Pastikan formatnya Y-m-d
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

//tambah data -- koding ini untuk menghindari sql injection
if ($request == 'create') {
    // Ambil data dari request    
    $ruangid = $data->ruangid ?? '';
    $tgl_kegiatan = $data->tgl_kegiatan ?? '';
    $nil_rh = $data->nil_rh ?? '';
    $nil_temp = $data->nil_temp ?? '';
    $nil_lx = $data->nil_lx ?? '';
    $idpeg = $data->idpeg ?? '';

    // Debug log untuk data yang diterima    
    //file_put_contents('debug.log', print_r($data, true), FILE_APPEND);

    $success = true; // Flag untuk status sukses

    // Check if the record already exists  
    $checkSql = "SELECT COUNT(*) AS count FROM rekaman_rh_temperatur   
                 WHERE tgl_kegiatan = ? AND ruangid = ?";
    $checkParams = array($tgl_kegiatan, $ruangid);
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
    $sql = "INSERT INTO rekaman_rh_temperatur     
                      (tgl_kegiatan, nil_rh, nil_temp, nil_lx, idpeg, ruangid)     
                      VALUES (?, ?, ?, ?, ?, ?)";
    $params = array($tgl_kegiatan, $nil_rh, $nil_temp, $nil_lx, $idpeg, $ruangid);
    $stmt = sqlsrv_query($koneksi, $sql, $params);
    if ($stmt) {
        $responseItems[] = array(
            "tgl_kegiatan" => $tgl_kegiatan,
            "nil_rh" => $nil_rh,
            "nil_temp" => $nil_temp,
            "nil_lx" => $nil_lx,
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
    $tgl_kegiatan = $currentData->tgl_kegiatan;
    $nil_rh = $currentData->nil_rh;
    $nil_temp = $currentData->nil_temp;
    $nil_lx = $currentData->nil_lx;
    $idpeg = $currentData->idpeg;
    $ruangid = $currentData->ruangid;

    $sql = sqlsrv_query($koneksi, "UPDATE rekaman_rh_temperatur 
        SET tgl_kegiatan='$tgl_kegiatan', nil_rh='$nil_rh', nil_temp='$nil_temp', nil_lx='$nil_lx', idpeg='$idpeg', ruangid='$ruangid'
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
