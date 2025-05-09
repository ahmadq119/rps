<?php
include '../../login/config.php';
session_start();

$data = json_decode(file_get_contents("php://input"));
$request = $data->request;

//tampil awal
if ($request == 'tampil') {
    $ruangid = $_SESSION['ruangid'];
    $sql = "SELECT TOP (20) * FROM view_rek_uv_ruangan Where ruangid=? ORDER BY tgl_kegiatan DESC";
    $params = array($ruangid);
    $query = sqlsrv_query($koneksi, $sql, $params);

    $response = array();
    while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $row['tgl_kegiatan'] = $row['tgl_kegiatan']->format('Y-m-d'); // Format tanggal  
        $row['pra_mulai'] = $row['pra_mulai']->format('H:i:s'); // Perbaiki format menit  
        $row['pra_selesai'] = $row['pra_selesai']->format('H:i:s'); // Perbaiki format menit  
        $row['pasca_mulai'] = $row['pasca_mulai']->format('H:i:s'); // Tambahkan format untuk pasca_mulai  
        $row['pasca_selesai'] = $row['pasca_selesai']->format('H:i:s'); // Tambahkan format untuk pasca_selesai  
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
    $pra_mulai = $data->pra_mulai ?? '';
    $pra_selesai = $data->pra_selesai ?? '';
    $pasca_mulai = $data->pasca_mulai ?? '';
    $pasca_selesai = $data->pasca_selesai ?? '';
    $idpeg = $data->idpeg ?? '';

    // Debug log untuk data yang diterima    
    //file_put_contents('debug.log', print_r($data, true), FILE_APPEND);

    $success = true; // Flag untuk status sukses    

    // Check if the record already exists  
    $checkSql = "SELECT COUNT(*) AS count FROM rekaman_uv_ruang   
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

    $sql = "INSERT INTO rekaman_uv_ruang     
                      (tgl_kegiatan, pra_mulai, pra_selesai, pasca_mulai, pasca_selesai, idpeg, ruangid)     
                      VALUES (?, ?, ?, ?, ?, ?, ?)";
    $params = array($tgl_kegiatan, $pra_mulai, $pra_selesai, $pasca_mulai, $pasca_selesai, $idpeg, $ruangid);
    $stmt = sqlsrv_query($koneksi, $sql, $params);
    if ($stmt) {
        $responseItems[] = array(
            "tgl_kegiatan" => $tgl_kegiatan,
            "pra_mulai" => $pra_mulai,
            "pra_selesai" => $pra_selesai,
            "pasca_mulai" => $pasca_mulai,
            "pasca_selesai" => $pasca_selesai,
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
    $pra_mulai = $currentData->pra_mulai;
    $pra_selesai = $currentData->pra_selesai;
    $pasca_mulai = $currentData->pasca_mulai;
    $pasca_selesai = $currentData->pasca_selesai;
    $idpeg = $currentData->idpeg;
    $ruangid = $currentData->ruangid;

    $sql = sqlsrv_query($koneksi, "UPDATE rekaman_uv_ruang 
        SET tgl_kegiatan='$tgl_kegiatan', pra_mulai='$pra_mulai', pra_selesai='$pra_selesai', pasca_mulai='$pasca_mulai', pasca_selesai='$pasca_selesai', idpeg='$idpeg', ruangid='$ruangid'
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
    $sql = sqlsrv_query($koneksi, "SELECT * FROM view_rek_uv_ruangan ORDER BY tgl_kegiatan DESC");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

///mengambil data pegawai
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
