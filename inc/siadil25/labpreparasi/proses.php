<?php
include '../login/config.php';

// Menangani kesalahan koneksi
if (!$koneksi) {
    die(json_encode(array("error" => "Koneksi database gagal")));
}

$data = json_decode(file_get_contents("php://input"));
$request = $data->request;

$response = array();

if ($request == 1) {
    $query = "SELECT YEAR(tgl_terima) AS Year, COUNT(kd_sample) AS Total_Records
                FROM view_penerimaan_sample
                WHERE tgl_terima >= DATEADD(YEAR, -5, GETDATE())
                GROUP BY YEAR(tgl_terima)
                ORDER BY Year DESC";

    $sql = sqlsrv_query($koneksi, $query);

    if ($sql === false) {
        die(json_encode(array("error" => "Query gagal: " . print_r(sqlsrv_errors(), true))));
    }

    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }

    // Tambahkan debug output untuk melihat apakah data diambil dengan benar
    if (empty($response)) {
        echo json_encode(array("error" => "Tidak ada data yang diambil."));
    } else {
        echo json_encode($response);
    }
    exit;
}
