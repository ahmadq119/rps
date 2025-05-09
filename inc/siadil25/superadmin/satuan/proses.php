<?php
include '../../login/config.php';

$data = json_decode(file_get_contents("php://input"));
$request = $data->request;

//tampil awal
if ($request == 'tampil') {
    $sql = sqlsrv_query($koneksi, "SELECT * FROM satuan ORDER BY satuan ASC");
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
    $sql = sqlsrv_query($koneksi, "SELECT * FROM satuan WHERE satuan LIKE '%$searchQuery%'");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

//tambah data -- koding ini untuk menghindari sql injection
if ($request == 'create') {
    $satuan = $data->satuan;

    $sql = "INSERT INTO satuan (satuan) VALUES (?)";
    $params = array($satuan);
    $stmt = sqlsrv_query($koneksi, $sql, $params);

    if ($stmt) {
        $response = array(
            "satuan" => $satuan,
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
    $idsatuan = $currentData->idsatuan;
    $satuan = $data->satuan;

    $sql = sqlsrv_query($koneksi, "UPDATE satuan 
        SET satuan='$satuan' WHERE idsatuan=$idsatuan");

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
    $sql = sqlsrv_query($koneksi, "SELECT * FROM satuan ORDER BY satuan ASC");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}
