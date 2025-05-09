<?php
include '../../login/config.php';

$data = json_decode(file_get_contents("php://input"));
$request = $data->request;

if ($request == "tampilawal") {
    $sql = "SELECT TOP (50) * FROM View_penerimaan_sample_labformalin ORDER BY tgl_terima DESC";
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
    $sql = "SELECT * FROM View_penerimaan_sample_labformalin
    WHERE kd_sample LIKE ?";

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

        if ($row['tgl_harus_uji'] instanceof DateTime) {
            $row['tgl_harus_uji'] = $row['tgl_harus_uji']->format('Y-m-d');
        }

        $response[] = $row;
    }

    echo json_encode($response);
    exit;
}


if ($request == "update") {
    $currentData = $data->currentData;
    $kd_sample = $currentData->kd_sample;
    $tgl_terima = $currentData->tgl_terima;
    $tgl_uji = $currentData->tgl_harus_uji;
    $metode = $currentData->acuan;
    $sts = 1;
    //$idpeg = $currentData->idpeg;

    try {
        // ** 1 Cek apakah kd_sample sudah ada**
        $check_sql = "SELECT COUNT(*) AS jumlah FROM sample_labformalin WHERE kd_sample = ?";
        $check_stmt = sqlsrv_query($koneksi, $check_sql, array($kd_sample));
        $row = sqlsrv_fetch_array($check_stmt, SQLSRV_FETCH_ASSOC);

        if ($row['jumlah'] > 0) {
            // **2️ Jika ada, lakukan UPDATE**
            $sql = "UPDATE sample_labformalin 
            SET tgl_uji = ?, metode_pengujian = ?, sts_terima = ?
            WHERE kd_sample = ?";
            $params = array($tgl_uji, $metode, $sts, $kd_sample);
        } else {
            // **3️ Jika tidak ada, lakukan INSERT**
            $sql = "INSERT INTO sample_labformalin (kd_sample, tgl_uji, metode_pengujian, sts_terima) 
            VALUES (?, ?, ?, ?)";
            $params = array($kd_sample, $tgl_uji, $metode, $sts);
        }

        // **4️ Jalankan Query INSERT atau UPDATE**
        $stmt = sqlsrv_query($koneksi, $sql, $params);
        if (!$stmt) {
            throw new Exception("Gagal memperbarui data: " . print_r(sqlsrv_errors(), true));
        }


        // **5️ Ambil data terbaru yang diperbarui**
        $query = "SELECT *
        FROM View_penerimaan_sample_labformalin
        WHERE kd_sample = ?";

        $stmt = sqlsrv_query($koneksi, $query, [$kd_sample]);
        $updatedData = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        // **6️ Konversi DateTime ke format Y-m-d jika ada**
        if ($updatedData['tgl_terima'] instanceof DateTime) {
            $updatedData['tgl_terima'] = $updatedData['tgl_terima']->format('Y-m-d');
        }
        if ($updatedData['tgl_uji'] instanceof DateTime) {
            $updatedData['tgl_uji'] = $updatedData['tgl_uji']->format('Y-m-d');
        }

        // **7️ Kirim JSON response**
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
