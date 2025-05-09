<?php
include '../../login/config.php';

$data = json_decode(file_get_contents("php://input"));
$request = $data->request;


if ($request == "tampilawal") {
    $sql = "SELECT 
    s.kd_sample,
    s.tgl_terima,
    s.tgl_uji,
    s.no_reg,
    s.nama_sample,
    s.nama_customer,
    s.jumlah,
    s.satuan,
    STUFF((
        SELECT 
            ', ' + t.target_pengujian
        FROM 
            view_penerimaan_target t
        WHERE 
            t.kd_sample = s.kd_sample
        FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 2, '') AS target_pengujian,
    STUFF((
        SELECT 
            ', ' + t.target_pengujian + ' (' + t.organ_target + ')'
        FROM 
            view_penerimaan_target t
        WHERE 
            t.kd_sample = s.kd_sample
        FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 2, '') AS organ_target,
    s.mt
FROM 
    view_penerimaan_sample s
GROUP BY 
    s.kd_sample, 
    s.tgl_terima, 
    s.tgl_uji, 
    s.no_reg, 
    s.nama_sample, 
    s.nama_customer, 
    s.jumlah, 
    s.satuan,
    s.mt
ORDER BY s.kd_sample DESC";
    $query = sqlsrv_query($koneksi, $sql);
    $response = array();
    while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $row['tgl_terima'] = $row['tgl_terima']->format('Y-m-d'); // Pastikan formatnya Y-m-d
        $row['tgl_uji'] = $row['tgl_uji']->format('Y-m-d'); // Pastikan formatnya Y-m-d
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

//pencarian
if ($request == 'caridata') {
    $searchQuery = $data->searchQuery;
    $sql = "SELECT 
    s.kd_sample,
    s.tgl_terima,
    s.tgl_uji,
    s.no_reg,
    s.nama_sample,
    s.nama_customer,
    s.jumlah,
    s.satuan,
    STUFF((
        SELECT 
            ', ' + t.target_pengujian
        FROM 
            view_penerimaan_target t
        WHERE 
            t.kd_sample = s.kd_sample
        FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 2, '') AS target_pengujian,
    STUFF((
        SELECT 
            ', ' + t.target_pengujian + ' (' + t.organ_target + ')'
        FROM 
            view_penerimaan_target t
        WHERE 
            t.kd_sample = s.kd_sample
        FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 2, '') AS organ_target,
    s.mt
FROM 
    view_penerimaan_sample s
WHERE 
    s.kd_sample + s.nama_customer 
LIKE 
    '%$searchQuery%'
GROUP BY 
    s.kd_sample, 
    s.tgl_terima, 
    s.tgl_uji, 
    s.no_reg, 
    s.nama_sample, 
    s.nama_customer, 
    s.jumlah, 
    s.satuan,
    s.mt
ORDER BY s.kd_sample DESC";
    $query = sqlsrv_query($koneksi, $sql);
    $response = array();
    while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $row['tgl_terima'] = $row['tgl_terima']->format('Y-m-d'); // Pastikan formatnya Y-m-d
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}
