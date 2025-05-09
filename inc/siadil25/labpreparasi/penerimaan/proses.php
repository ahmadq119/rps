<?php
include '../../login/config.php';

$data = json_decode(file_get_contents("php://input"));
$request = $data->request;

if ($request == "tampilawal") {
    $sql = "SELECT 
    ps.idpre,
    ps.kd_sample,
    ps.panjang,
    ps.berat,
    ps.idpeg,
    peg.nama_pegawai,
    js.nama_sample,
    pn.tgl_terima,
    pn.jumlah,
    s.satuan,
    STUFF((
        SELECT CHAR(13) + CHAR(10) + tp.target_pengujian + ': ' + pt.organ_target
        FROM penerimaan_target pt
        INNER JOIN target_pengujian tp ON pt.idtarget = tp.idtarget
        WHERE pt.kd_sample = ps.kd_sample
        FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 2, '') AS pengujian_tergabung
FROM 
    preparasi_sample ps
INNER JOIN 
    penerimaan_sample pn ON ps.kd_sample = pn.kd_sample
INNER JOIN 
    jenis_sample js ON pn.idsample = js.idsample
INNER JOIN 
    satuan s ON js.idsatuan = s.idsatuan
LEFT OUTER JOIN 
    pegawai peg ON ps.idpeg = peg.idpeg
GROUP BY 
    ps.idpre, 
    ps.kd_sample, 
    ps.panjang, 
    ps.berat, 
    ps.idpeg,
    peg.nama_pegawai, 
    js.nama_sample,
    pn.tgl_terima, 
    pn.jumlah, 
    s.satuan
";
    $query = sqlsrv_query($koneksi, $sql);
    $response = array();
    while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $row['tgl_terima'] = $row['tgl_terima']->format('Y-m-d'); // Pastikan formatnya Y-m-d
        //$row['tgl_uji'] = $row['tgl_uji']->format('Y-m-d'); // Pastikan formatnya Y-m-d
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

//pencarian
if ($request == 'caridata') {
    $searchQuery = $data->searchQuery;
    $sql = sqlsrv_query($koneksi, "SELECT * FROM view_preparasi_gabungan WHERE kd_sample LIKE '%$searchQuery%'");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $row['tgl_terima'] = $row['tgl_terima']->format('Y-m-d'); // Pastikan formatnya Y-m-d
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

if ($request == "update") {
    $currentData = $data->currentData;
    $kd_sample = $currentData->kd_sample;
    $panjang = $currentData->panjang;
    $berat = $currentData->berat;
    $idpeg = $currentData->idpeg;

    try {
        // Update Query
        $sql = "UPDATE preparasi_sample 
                SET panjang = ?, 
                    berat = ?,
                    idpeg = ?
                WHERE kd_sample = ?";
        $params = array($panjang, $berat, $idpeg, $kd_sample);

        $stmt = sqlsrv_query($koneksi, $sql, $params);
        if (!$stmt) {
            throw new Exception("Gagal mengupdate data: " . print_r(sqlsrv_errors(), true));
        }

        // Ambil data terbaru yang diperbarui
        $query = "SELECT * FROM view_preparasi_gabungan WHERE kd_sample = ?";

        $stmt = sqlsrv_query($koneksi, $query, [$kd_sample]);
        $updatedData = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        if ($updatedData['tgl_terima'] instanceof DateTime) {
            $updatedData['tgl_terima'] = $updatedData['tgl_terima']->format('Y-m-d');
        }

        echo json_encode([
            'success' => true,
            'updatedData' => $updatedData
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
    exit;
}


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
