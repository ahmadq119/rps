<?php
include '../../login/config.php';
session_start();

$data = json_decode(file_get_contents("php://input"));
$request = $data->request;

//tampil awal
if ($request == 'tampil') {
    $sql = sqlsrv_query($koneksi, "SELECT tanggal, ruangid, nama_ruang FROM view_permintaan_bahan WHERE sts=1 ORDER BY tanggal ASC");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $row['tanggal'] = $row['tanggal']->format('Y-m-d');
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

//pencarian data
if ($request == 'read') {
    $searchQuery = $data->searchQuery;
    $sql = sqlsrv_query($koneksi, "SELECT * FROM view_permintaan_bahan WHERE nama_bahan+nama_alat LIKE '%$searchQuery%'");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $row['tanggal'] = $row['tanggal']->format('Y-m-d');
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

//update
if ($request == 'update') {
    $currentData = $data->currentData;
    $idbahan = $currentData->idbahan;
    $idpeg = $currentData->idpeg_bahan;
    $sts = 1;

    $sql = sqlsrv_query($koneksi, "UPDATE permintaan_bahan 
        SET idpeg_bahan='$idpeg', sts='$sts'
        WHERE idbahan=$idbahan");

    if ($sql) {
        echo json_encode($currentData);
    } else {
        http_response_code(500);
        echo json_encode(array('message' => 'Gagal mengupdate data.'));
    }
    exit;
}

//menampilkan seluruh data
if ($request == 'tampil_seluruh_data') {
    $sql = sqlsrv_query($koneksi, "SELECT * FROM view_permintaan_bahan ORDER BY tanggal DESC");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $row['tanggal'] = $row['tanggal']->format('Y-m-d');
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
