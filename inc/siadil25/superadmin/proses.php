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
    // Query untuk mendapatkan daftar asal_sample unik
    $query_columns = "SELECT STUFF(( 
        SELECT DISTINCT ',' + QUOTENAME(asal_sample)
        FROM view_penerimaan_sample
        FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 1, '') AS columns_list";

    $sql_columns = sqlsrv_query($koneksi, $query_columns);
    if ($sql_columns === false) {
        die(json_encode(array("error" => "Gagal mendapatkan daftar kolom: " . print_r(sqlsrv_errors(), true))));
    }

    $row_columns = sqlsrv_fetch_array($sql_columns, SQLSRV_FETCH_ASSOC);
    $columns = $row_columns['columns_list'];

    if (empty($columns)) {
        die(json_encode(array("error" => "Kolom asal_sample tidak ditemukan.")));
    }

    // Query Pivot Dinamis
    $query_pivot = "
DECLARE @sql NVARCHAR(MAX);
SET @sql = '
SELECT Tahun, " . $columns . ",
ISNULL(" . str_replace(",", " + ", $columns) . ", 0) AS Total
FROM (
SELECT YEAR(tgl_terima) AS Tahun, asal_sample, kd_sample
FROM view_penerimaan_sample
) AS SourceTable
PIVOT (
COUNT(kd_sample) 
FOR asal_sample IN (" . $columns . ")
) AS PivotTable
ORDER BY Tahun DESC;';

EXEC sp_executesql @sql;";

    // Jalankan Query Pivot
    $sql_pivot = sqlsrv_query($koneksi, $query_pivot);

    if ($sql_pivot === false) {
        die(json_encode(array("error" => "Query pivot gagal: " . print_r(sqlsrv_errors(), true))));
    }

    while ($row = sqlsrv_fetch_array($sql_pivot, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }

    echo json_encode($response, JSON_PRETTY_PRINT);
    exit;
}
