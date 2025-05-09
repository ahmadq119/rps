<?php
include '../../login/config.php';

$data = json_decode(file_get_contents("php://input"));
$request = $data->request;

// Mengambil Data Tahun
if ($request == 'ambildatatahun') {

    $query = sqlsrv_query($koneksi, "SELECT DISTINCT year(tgl_kegiatan) as tahun FROM View_rek_uv_ruangan ORDER BY year(tgl_kegiatan) DESC");

    // Cek jika query gagal dieksekusi
    if ($query === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $results = [];
    while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $results[] = $row['tahun'];
    }
    echo json_encode($results);
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

// Mengambil Data Alat
if ($request == 'ambildataalat') {

    $sql = sqlsrv_query($koneksi, "SELECT DISTINCT UPPER(nama_alat) AS nama_alat FROM rekaman_verifikasi_suhu_alat ORDER BY nama_alat ASC");

    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}
