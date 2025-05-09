<?php
include '../../login/config.php';

$data = json_decode(file_get_contents("php://input"));
$request = $data->request;

if ($request == "tampilawal") {
    $kd_sample = isset($data->kd_sample) ? $data->kd_sample : null;

    // Pastikan kd_sample tidak null
    if ($kd_sample) {
        // Gunakan prepared statement untuk mencegah SQL Injection
        $sql = "SELECT * FROM View_penerimaan_target WHERE kd_sample = ?";
        $params = [$kd_sample];
        $stmt = sqlsrv_prepare($koneksi, $sql, $params);

        if ($stmt) {
            sqlsrv_execute($stmt);

            $response = [];
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                // Pastikan kolom tgl_terima dan tgl_uji ada sebelum memformat
                if (isset($row['tgl_terima']) && $row['tgl_terima'] instanceof DateTime) {
                    $row['tgl_terima'] = $row['tgl_terima']->format('Y-m-d');
                }
                if (isset($row['tgl_uji']) && $row['tgl_uji'] instanceof DateTime) {
                    $row['tgl_uji'] = $row['tgl_uji']->format('Y-m-d');
                }
                $response[] = $row;
            }

            echo json_encode($response);
        } else {
            // Jika query gagal
            echo json_encode(["error" => "Query preparation failed."]);
        }
    } else {
        // Jika kd_sample tidak ada
        echo json_encode(["error" => "Parameter kd_sample is missing."]);
    }

    exit;
}

if ($request == "updateOrganTarget") {
    $currentData = $data->currentData;
    $id = $currentData->id;
    $organ_target = $data->organ_target;

    // Validasi field
    if (!$id || !$organ_target) {
        echo json_encode(['success' => false, 'message' => 'Harap isi semua field yang diperlukan.']);
        exit;
    }

    try {
        // Mulai transaksi
        sqlsrv_begin_transaction($koneksi);

        // Query update untuk tabel penerimaan_target
        $sql = "UPDATE penerimaan_target SET organ_target = ? WHERE id = ?";
        $params = array($organ_target, $id);

        $stmt = sqlsrv_query($koneksi, $sql, $params);

        if ($stmt) {
            // Ambil data terbaru yang diperbarui
            $selectSql = "SELECT * FROM View_penerimaan_target WHERE id = ?";
            $paramsSelect = array($id);
            $result = sqlsrv_query($koneksi, $selectSql, $paramsSelect);

            if ($result) {
                $updatedData = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

                // Format tanggal jika tidak null
                if ($updatedData['tgl_terima'] instanceof DateTime) {
                    $updatedData['tgl_terima'] = $updatedData['tgl_terima']->format('Y-m-d');
                }
                if ($updatedData['tgl_uji'] instanceof DateTime) {
                    $updatedData['tgl_uji'] = $updatedData['tgl_uji']->format('Y-m-d');
                }

                // Commit transaksi
                sqlsrv_commit($koneksi);

                // Kirim data dalam format JSON
                echo json_encode([
                    "success" => true,
                    "updatedData" => $updatedData,
                    "message" => "Data berhasil disimpan."
                ]);
                exit;
            } else {
                throw new Exception("Gagal mengambil data yang diperbarui.");
            }
        } else {
            throw new Exception("Gagal memperbarui data di database.");
        }
    } catch (Exception $e) {
        // Rollback transaksi jika ada kesalahan
        sqlsrv_rollback($koneksi);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        exit;
    }
}


//Mengambil Data Target Pengujian
if ($request == 'organTarget') {

    $sql = sqlsrv_query($koneksi, "SELECT idorg, nama_organ FROM organ_target");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

//menampilkan seluruh data
if ($request == 14) {
    $sql = sqlsrv_query($koneksi, "SELECT * FROM View_penerimaan_target ORDER BY kd_sample DESC");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $row['tgl_terima'] = $row['tgl_terima']->format('Y-m-d'); // Pastikan formatnya Y-m-d
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}
