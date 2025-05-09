<?php
include '../../login/config.php';

$data = json_decode(file_get_contents("php://input"));
$request = $data->request;

// Mengambil Data Tahun
if ($request == 'ambildatatahun') {

    $query = sqlsrv_query($koneksi, "SELECT DISTINCT year(tgl_terima) as tahun FROM view_preparasi_gabungan ORDER BY tahun DESC");

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
    $sql = sqlsrv_query($koneksi, "SELECT * FROM pegawai ORDER BY nama_pegawai ASC");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

// Mengambil Data Bulan
if ($request == 'ambildatabulan') {

    $query = sqlsrv_query($koneksi, "SELECT DISTINCT month(tgl_terima) as bulan FROM view_preparasi_gabungan ORDER BY bulan ASC");

    // Cek jika query gagal dieksekusi
    if ($query === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $results = [];
    while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $results[] = [
            'value' => $row['bulan'],
            'name' => getMonthName((int)$row['bulan']),
        ];
    }

    echo json_encode($results);
    exit;
}

// Fungsi untuk mendapatkan nama bulan
function getMonthName($monthNumber)
{
    $months = [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember"
    ];
    return $months[$monthNumber - 1];
}
