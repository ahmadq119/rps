<?php
include '../../login/config.php';

$data = json_decode(file_get_contents("php://input"));
$request = $data->request;

//tampil awal
if ($request == 'tampil') {
    $sql = sqlsrv_query($koneksi, "SELECT * FROM target_pengujian ORDER BY idtarget");
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
    $sql = sqlsrv_query($koneksi, "SELECT * FROM target_pengujian WHERE target_pengujian LIKE '%$searchQuery%'");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

//tambah data -- koding ini untuk menghindari sql injection
if ($request == 'create') {
    $target_pengujian = $data->target_pengujian;
    $metode_pengujian = $data->metode_pengujian;
    $ruangid = $data->ruangid;
    $sql = "INSERT INTO target_pengujian (target_pengujian, metode_pengujian, ruangid) VALUES (?, ?, ?)";
    $params = array($target_pengujian, $metode_pengujian, $ruangid);
    $stmt = sqlsrv_query($koneksi, $sql, $params);

    if ($stmt) {
        $response = array(
            "target_pengujian" => $target_pengujian,
            "metode_pengujian" => $metode_pengujian,
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
    $idtarget = $currentData->idtarget;
    $target_pengujian = $currentData->target_pengujian;
    $metode_pengujian = $currentData->metode_pengujian;
    $ruangid = $currentData->ruangid;

    $sql = "UPDATE target_pengujian 
                    SET target_pengujian = ?, metode_pengujian = ?, ruangid = ? 
                    WHERE idtarget = ?";
    $params = [$target_pengujian, $metode_pengujian, $ruangid, $idtarget];
    $stmt = sqlsrv_query($koneksi, $sql, $params);

    if ($stmt) {
        echo json_encode($currentData);
    } else {
        http_response_code(500);
        echo json_encode(["message" => "Gagal mengupdate data.", "error" => sqlsrv_errors()]);
    }
    exit;
}

if ($request == 'ambildataruang') {
    $sql = sqlsrv_query($koneksi, "SELECT * FROM ruangan ORDER BY nama_ruang ASC");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

//menampilkan seluruh data
if ($request == 'cari_seluruh_data') {
    $sql = sqlsrv_query($koneksi, "SELECT * FROM target_pengujian ORDER BY target_pengujian ASC");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}
