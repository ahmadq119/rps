<?php
include '../../login/config.php';

$data = json_decode(file_get_contents("php://input"));
$request = $data->request;

if ($request == "tampilawal") {
    $sql = "SELECT TOP (50) * FROM View_penerimaan_sample_labsensori ORDER BY tgl_terima DESC";
    $query = sqlsrv_query($koneksi, $sql);
    $response = array();
    while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $row['tgl_terima'] = isset($row['tgl_terima']) ? $row['tgl_terima']->format('Y-m-d') : null;
        $row['tgl_uji'] = isset($row['tgl_uji']) ? $row['tgl_uji']->format('Y-m-d') : null;
        $row['tgl_hasil'] = isset($row['tgl_hasil']) ? $row['tgl_hasil']->format('Y-m-d') : null;
        $row['tgl_harus_uji'] = isset($row['tgl_harus_uji']) ? $row['tgl_harus_uji']->format('Y-m-d') : null;

        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

//pencarian
if ($request == 'caridata') {
    $searchQuery = $data->searchQuery;

    // Pastikan searchQuery memiliki wildcard untuk pencarian LIKE
    $searchParam = "%" . $searchQuery . "%";

    // Query dengan parameterized query
    $sql = "SELECT * FROM View_penerimaan_sample_labsensori WHERE kd_sample LIKE ?";

    // Eksekusi query dengan parameter
    $query = sqlsrv_query($koneksi, $sql, [$searchParam]);

    if ($query === false) {
        echo json_encode(["error" => sqlsrv_errors()]);
        exit;
    }

    $response = array();
    while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        // Konversi format tanggal ke Y-m-d jika ada
        if ($row['tgl_terima'] instanceof DateTime) {
            $row['tgl_terima'] = $row['tgl_terima']->format('Y-m-d');
        }

        if ($row['tgl_uji'] instanceof DateTime) {
            $row['tgl_uji'] = $row['tgl_uji']->format('Y-m-d');
        }

        $response[] = $row;
    }

    echo json_encode($response);
    exit;
}


if ($request == "update") {
    $currentData = $data->currentData;
    $kd_sample = $currentData->kd_sample;
    $tgl_hasil = $currentData->tgl_uji;
    $metode = $currentData->metode_pengujian;
    $hasil = $currentData->hasil_pengujian;
    $idpeg = $currentData->idpeg_analis;

    try {

        // UPDATE**
        $sql = "UPDATE sample_labsensori 
            SET tgl_hasil = ?, metode_pengujian = ?, hasil_pengujian = ?, idpeg = ?
            WHERE kd_sample = ?";
        $params = array($tgl_hasil, $metode, $hasil, $idpeg, $kd_sample);

        // Jalankan Query INSERT atau UPDATE**
        $stmt = sqlsrv_query($koneksi, $sql, $params);
        if (!$stmt) {
            throw new Exception("Gagal memperbarui data: " . print_r(sqlsrv_errors(), true));
        }


        // **5️ Ambil data terbaru yang diperbarui**
        $query = "SELECT * FROM View_penerimaan_sample_labsensori WHERE kd_sample LIKE ?";

        $stmt = sqlsrv_query($koneksi, $query, [$kd_sample]);
        $updatedData = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        // Konversi DateTime ke format Y-m-d jika ada**
        if ($updatedData['tgl_terima'] instanceof DateTime) {
            $updatedData['tgl_terima'] = $updatedData['tgl_terima']->format('Y-m-d');
        }
        if ($updatedData['tgl_hasil'] instanceof DateTime) {
            $updatedData['tgl_hasil'] = $updatedData['tgl_hasil']->format('Y-m-d');
        }

        // Kirim JSON response**
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
