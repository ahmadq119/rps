<?php
include '../../login/config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$data = json_decode(file_get_contents("php://input"));
$request = $data->request;

if ($request == "tampilawal") {
    $kd_sample = isset($data->kd_sample) ? $data->kd_sample : null;

    // Pastikan kd_sample tidak null
    if ($kd_sample) {
        // Gunakan prepared statement untuk mencegah SQL Injection
        $sql = "SELECT * FROM View_lhu WHERE kd_sample = ?";
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
                if (isset($row['tgl_lhu']) && $row['tgl_lhu'] instanceof DateTime) {
                    $row['tgl_lhu'] = $row['tgl_lhu']->format('Y-m-d');
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

if ($request == "update") {
    $currentData = $data->currentData;
    $id = $currentData->id;
    $kd_sample = $currentData->kd_sample;
    $no_lhu = "Tes Nomor";
    $bidang_pengujian = $currentData->target_pengujian;
    $parameter = $currentData->parameter;

    // **Ambil nilai hasil & persyaratan_mutu dari TinyMCE**
    $hasil = isset($currentData->hasil) ? $currentData->hasil : null;
    $persyaratan_mutu = isset($currentData->persyaratan_mutu) ? $currentData->persyaratan_mutu : null;

    $metode_acuan = $currentData->metode_acuan;
    // **Ambil nilai hasil & persyaratan_mutu dari TinyMCE**
    $keterangan = isset($currentData->keterangan) ? $currentData->keterangan : null;

    $tgl_lhu = $currentData->tgl_lhu;
    $idpeg = $currentData->idpeg;

    // Validasi field
    if (!$parameter) {
        echo json_encode(['success' => false, 'message' => 'Harap isi semua field yang diperlukan.']);
        exit;
    }

    try {
        // Mulai transaksi
        //sqlsrv_begin_transaction($koneksi);

        // ** 1 Cek apakah kd_sample sudah ada**
        $check_sql = "SELECT COUNT(*) AS jumlah FROM lhu WHERE id = ?";
        $check_stmt = sqlsrv_query($koneksi, $check_sql, array($id));
        $row = sqlsrv_fetch_array($check_stmt, SQLSRV_FETCH_ASSOC);

        if ($row['jumlah'] > 0) {
            // **2️ Jika ada, lakukan UPDATE**
            $sql = "UPDATE lhu 
            SET kd_sample = ?, no_lhu = ?, bidang_pengujian = ?, parameter = ?, hasil = ?, persyaratan_mutu = ?, metode_acuan = ?, keterangan = ?, tgl_lhu = ?, idpeg = ?
            WHERE id = ?";
            $params = array($kd_sample, $no_lhu, $bidang_pengujian, $parameter, $hasil, $persyaratan_mutu, $metode_acuan, $keterangan, $tgl_lhu, $idpeg, $id);
        } else {
            // **3️ Jika tidak ada, lakukan INSERT**
            $sql = "INSERT INTO lhu (kd_sample, no_lhu, bidang_pengujian, parameter, hasil, persyaratan_mutu, metode_acuan, keterangan, tgl_lhu, idpeg) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $params = array($kd_sample, $no_lhu, $bidang_pengujian, $parameter, $hasil, $persyaratan_mutu, $metode_acuan, $keterangan, $tgl_lhu, $idpeg);
        }

        // **4️ Jalankan Query INSERT atau UPDATE**
        $stmt = sqlsrv_query($koneksi, $sql, $params);
        if (!$stmt) {
            throw new Exception("Gagal memperbarui data: " . print_r(sqlsrv_errors(), true));
        }


        // **5️ Ambil data terbaru yang diperbarui**
        $query = "SELECT * FROM View_lhu WHERE id = ?";

        $stmt = sqlsrv_query($koneksi, $query, [$kd_sample]);
        $updatedData = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        // **6️ Konversi DateTime ke format Y-m-d jika ada**
        if ($updatedData['tgl_terima'] instanceof DateTime) {
            $updatedData['tgl_terima'] = $updatedData['tgl_terima']->format('Y-m-d');
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
