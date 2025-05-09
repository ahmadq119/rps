<?php
include '../../login/config.php';

$data = json_decode(file_get_contents("php://input"));
$request = $data->request;

//tampil awal
if ($request == 'tampil') {
    $sql = sqlsrv_query($koneksi, "SELECT * FROM View_jenis_sample ORDER BY nama_sample ASC");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

//pencarian data
if ($request == 'read') {
    $searchQuery = $data->searchQuery;
    $sql = sqlsrv_query($koneksi, "SELECT * FROM View_jenis_sample WHERE nama_sample+satuan+kelompok LIKE '%$searchQuery%'");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

//tambah data -- koding ini untuk menghindari sql injection
if ($request == 'create') {
    $nama_sample = $data->nama_sample;
    $idsatuan = $data->idsatuan;
    $idkelompok = $data->idkelompok;

    $sql = "INSERT INTO jenis_sample (nama_sample, idsatuan, idkelompok) VALUES (?, ?, ?)";
    $params = array($nama_sample, $idsatuan, $idkelompok);
    $stmt = sqlsrv_query($koneksi, $sql, $params);

    if ($stmt) {
        $response = array(
            "nama_sample" => $nama_sample,
            "idsatuan" => $idsatuan,
            "idkelompok" => $idkelompok,
        );
        echo json_encode($response);
    } else {
        http_response_code(500);
        echo json_encode(array('message' => 'Gagal menyimpan data user.'));
    }
    exit;
}


//update
if ($request == 'update') {
    $currentData = $data->currentData;
    $idsample = $currentData->idsample;
    $nama_sample = $data->nama_sample;
    $idsatuan = $data->idsatuan;
    $idkelompok = $data->idkelompok;

    $sql = sqlsrv_query($koneksi, "UPDATE jenis_sample 
        SET nama_sample='$nama_sample', idsatuan='$idsatuan', idkelompok='$idkelompok'
        WHERE idsample=$idsample");

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
    $sql = sqlsrv_query($koneksi, "SELECT * FROM View_jenis_sample ORDER BY nama_sample ASC");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

//Mengambil Data Satuan
if ($request == 'ambildatasatuan') {
    $sql = sqlsrv_query($koneksi, "SELECT * FROM satuan ORDER BY satuan ASC");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

//Mengambil Data Kelompok
if ($request == 'ambildatakelompok') {
    $sql = sqlsrv_query($koneksi, "SELECT * FROM kelompok_sample ORDER BY kelompok ASC");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}
