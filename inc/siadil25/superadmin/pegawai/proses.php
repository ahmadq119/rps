<?php
include '../../login/config.php';

$data = json_decode(file_get_contents("php://input"));
$request = $data->request;

//tampil awal
if ($request == 'tampil') {
    $sql = sqlsrv_query($koneksi, "SELECT TOP (10) * FROM pegawai ORDER BY nama_pegawai ASC");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}
//hapus record yang dipilih
if ($request == 'delete') {
    $idcus = $data->idpeg;
    $sql = sqlsrv_query($koneksi, "DELETE FROM pegawai WHERE idpeg=$idpeg");
    exit;
}
//pencarian data
if ($request == 'cari') {
    $searchQuery = $data->searchQuery;
    $sql = sqlsrv_query($koneksi, "SELECT * FROM pegawai WHERE nama_pegawai LIKE '%$searchQuery%'");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

//Tambah Data
if ($request == 'create') {
    $nama_pegawai = $data->nama_pegawai;
    $nip_pegawai = $data->nip_pegawai;

    $sql = "INSERT INTO pegawai (nama_pegawai, nip_pegawai) VALUES (?, ?)";
    $params = array($nama_pegawai, $nip_pegawai);
    $stmt = sqlsrv_query($koneksi, $sql, $params);
    if ($stmt) {
        $response = array(
            "nama_pegawai" => $nama_pegawai,
            "nip_pegawai" => $nip_pegawai,
        );
        echo json_encode($response);
    } else {
        http_response_code(500);
        echo json_encode(array('message' => 'Gagal menyimpan data user.'));
    }
    exit;
}

if ($request == 'edit') {
    $currentData = $data->currentData;
    $idpeg = $currentData->idpeg;
    $nama_pegawai = $currentData->nama_pegawai;
    $nip_pegawai = $currentData->nip_pegawai;

    $sql = sqlsrv_query($koneksi, "UPDATE pegawai 
        SET nama_pegawai='$nama_pegawai', nip_pegawai='$nip_pegawai'
        WHERE idpeg=$idpeg");

    if ($sql) {
        echo json_encode($currentData);
    } else {
        http_response_code(500);
        echo json_encode(array('message' => 'Gagal mengupdate data.'));
    }
    exit;
}

//menampilkan seluruh data
if ($request == 'tampil_all') {
    $sql = sqlsrv_query($koneksi, "SELECT * FROM pegawai ORDER BY nama_pegawai DESC");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}
