<?php
include '../../login/config.php';

$data = json_decode(file_get_contents("php://input"));
$request = $data->request;

if ($request == "tampilawal") {
    $sql = sqlsrv_query($koneksi, "SELECT TOP (10) * FROM View_penerimaan_sample ORDER BY kd_sample DESC");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
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
    $sql = sqlsrv_query($koneksi, "SELECT * FROM view_penerimaan_sample WHERE kd_sample + nama_customer LIKE '%$searchQuery%' ORDER BY tgl_terima DESC, kd_sample DESC");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $row['tgl_terima'] = $row['tgl_terima']->format('Y-m-d'); // Pastikan formatnya Y-m-d
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

if ($request == 'tambahdata') {
    $kd_sample = $data->kd_sample;
    $nomor = $data->nomor;
    $no_reg = $data->no_reg;
    $no_bap = $data->no_bap;
    $tgl_terima = $data->tgl_terima;
    $tgl_uji = $data->tgl_uji;
    $idcustomer = $data->idcustomer;
    $idsample = $data->idsample;
    $jumlah = $data->jumlah;
    $idkondisi = $data->idkondisi;
    $idpeg1 = $data->idpeg1;
    $idpeg2 = $data->idpeg2;
    $idpeg3 = $data->idpeg3;
    $idasal = $data->idasal;
    $target_pengujian = $data->target_pengujian;

    // Debug: Cek apakah semua variabel terisi dengan benar
    error_log("Data yang diterima: " . json_encode($data));


    // Validasi data
    if (!$tgl_terima || !$kd_sample || !$nomor || !$idcustomer || !$idsample || !$jumlah || !$idkondisi || !$idpeg1 || !$idpeg2 || !$idpeg3) {
        echo json_encode(['success' => false, 'message' => 'Harap isi semua field yang diperlukan.']);
        exit;
    }

    try {
        // Mulai transaksi
        sqlsrv_begin_transaction($koneksi);

        // Perbaiki Format Tanggal untuk SQL Server
        $tgl_terima = date('Y-m-d', strtotime($tgl_terima));
        $tgl_uji = date('Y-m-d', strtotime($tgl_uji));

        // Query untuk tabel penerimaan_sample
        $sql1 = "INSERT INTO penerimaan_sample (kd_sample, nomor, no_reg, no_bap, tgl_terima, tgl_uji, idcustomer, idsample, jumlah, idkondisi, idpeg1, idpeg2, idpeg3, idasal) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $params1 = array($kd_sample, $nomor, $no_reg, $no_bap, $tgl_terima, $tgl_uji, $idcustomer, $idsample, $jumlah, $idkondisi, $idpeg1, $idpeg2, $idpeg3, $idasal);
        $stmt1 = sqlsrv_query($koneksi, $sql1, $params1);
        if ($stmt1 === false) {
            throw new Exception("Gagal menyimpan data ke tabel penerimaan_sample");
        }

        // Loop untuk menyimpan penerimaan_target
        // Simpan penerimaan_target
        if (!empty($target_pengujian)) {
            foreach ($target_pengujian as $target) {
                $sql2 = "INSERT INTO penerimaan_target (kd_sample, idtarget) VALUES (?, ?)";
                $params2 = array($kd_sample, $target);
                $stmt2 = sqlsrv_query($koneksi, $sql2, $params2);
                if ($stmt2 === false) {
                    throw new Exception("Gagal menyimpan data ke tabel penerimaan_target. Error: " . print_r(sqlsrv_errors(), true));
                }
            }
        }

        // Commit transaksi
        sqlsrv_commit($koneksi);

        echo json_encode(['success' => true, 'message' => 'Data berhasil disimpan']);
    } catch (Exception $e) {
        // Rollback transaksi jika ada kesalahan
        sqlsrv_rollback($koneksi);
        error_log("Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}


if ($request == "update") {
    $currentData = $data->currentData;
    $no_reg = $currentData->no_reg;
    $no_bap = $currentData->no_bap;
    $kd_sample = $currentData->kd_sample;
    $tgl_terima = $currentData->tgl_terima;
    $tgl_uji = $currentData->tgl_uji;
    $idcustomer = $currentData->idcustomer;
    $idsample = $currentData->idsample;
    $jumlah = $currentData->jumlah;
    $idpeg1 = $currentData->idpeg1;
    $idpeg2 = $currentData->idpeg2;
    $idpeg3 = $currentData->idpeg3;
    $idasal = $currentData->idasal;
    $target_pengujian = $data->target_pengujian;

    // Validasi field
    if (!$kd_sample || !$tgl_terima || !$tgl_uji || !$idcustomer || !$idsample || !$jumlah) {
        echo json_encode(['success' => false, 'message' => 'Harap isi semua field yang diperlukan.']);
        exit;
    }

    try {
        // Mulai transaksi
        sqlsrv_begin_transaction($koneksi);

        // Query update untuk tabel penerimaan_sample
        $sql = "UPDATE penerimaan_sample 
            SET no_reg = ?, 
            no_bap = ?,
            tgl_terima = ?, 
            tgl_uji = ?, 
            idcustomer = ?, 
            idsample = ?, 
            jumlah = ?, 
            idpeg1 = ?, 
            idpeg2 = ?, 
            idpeg3 = ?,
            idasal = ?
    WHERE kd_sample = ?";
        $params = array($no_reg, $no_bap, $tgl_terima, $tgl_uji, $idcustomer, $idsample, $jumlah, $idpeg1, $idpeg2, $idpeg3, $idasal, $kd_sample);

        $stmt = sqlsrv_query($koneksi, $sql, $params);

        if ($stmt) {
            // Ambil data terbaru yang diperbarui
            $selectSql = "SELECT * FROM View_penerimaan_sample WHERE kd_sample = ?";
            $paramsSelect = array($kd_sample);
            $result = sqlsrv_query($koneksi, $selectSql, $paramsSelect);

            if ($result) {
                $updatedData = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

                // Cek dan format tanggal jika tidak null
                if ($updatedData['tgl_terima'] instanceof DateTime) {
                    $updatedData['tgl_terima'] = $updatedData['tgl_terima']->format('Y-m-d');
                }
                if ($updatedData['tgl_uji'] instanceof DateTime) {
                    $updatedData['tgl_uji'] = $updatedData['tgl_uji']->format('Y-m-d');
                }

                // Kirim data dalam format JSON
                echo json_encode([
                    "success" => true,
                    "updatedData" => $updatedData
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Gagal mengambil data yang diperbarui"
                ]);
            }
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Gagal memperbarui data di database"
            ]);
        }

        // Delete existing targets for this sample
        $query_delete_targets = "DELETE FROM penerimaan_target WHERE kd_sample = ?;";
        $paramsDelete = array($kd_sample);
        $stmt_delete = sqlsrv_query($koneksi, $query_delete_targets, $paramsDelete);


        // Loop untuk menyimpan penerimaan_target
        foreach ($target_pengujian as $target) {
            $sql3 = "INSERT INTO penerimaan_target (kd_sample, idtarget) VALUES (?, ?)";
            $params3 = array($kd_sample, $target);

            $stmt3 = sqlsrv_query($koneksi, $sql3, $params3);
            if ($stmt3 === false) {
                throw new Exception("Gagal menyimpan data ke tabel target_pengujian");
            }
        }

        // Commit transaksi
        sqlsrv_commit($koneksi);

        echo json_encode(['success' => true, 'message' => 'Data berhasil disimpan']);
    } catch (Exception $e) {
        // Rollback transaksi jika ada kesalahan
        sqlsrv_rollback($koneksi);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}


if ($request == 'ambilnomor') {
    $sql = sqlsrv_query($koneksi, "SELECT TOP 1 RIGHT('00000' + CAST(CAST(nomor AS INT) + 1 AS VARCHAR), 5) AS nomor_baru FROM penerimaan_sample WHERE YEAR(tgl_terima) = YEAR(GETDATE()) ORDER BY nomor DESC");
    $response = array();
    if ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response['nomor_baru'] = $row['nomor_baru'];
    } else {
        $response['nomor_baru'] = "00001"; // Default nomor jika tidak ada data
    }
    echo json_encode($response);
    exit;
}

if ($request == 'cari_customer') {
    $query = $data->query;
    $sql = sqlsrv_query($koneksi, "SELECT idcustomer, RTRIM(nama_customer) AS nama_customer, alamat_customer FROM customer WHERE nama_customer LIKE '%$query%'");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

if ($request == 'AmbilNamaSample') {
    $query = sqlsrv_query($koneksi, "SELECT DISTINCT idsample, RTRIM(nama_sample), satuan FROM View_jenis_sample ORDER BY nama_sample ASC");
    $results = [];
    while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $results[] = $row;
    }
    echo json_encode($results);
}

if ($request == 'asalsample') {
    $query = sqlsrv_query($koneksi, "SELECT * FROM asal_sample ORDER BY asal_sample ASC");
    $results = [];
    while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $results[] = $row;
    }
    echo json_encode($results);
}

// Mengambil Data Kondisi Sample
if ($request == 'ambildatakondisisample') {
    $query = sqlsrv_query($koneksi, "SELECT idkondisi, kondisi_sample FROM kondisi_sample ORDER BY kondisi_sample ASC");

    // Cek jika query gagal dieksekusi
    if ($query === false) {
        die(print_r(sqlsrv_errors(), true)); // Debugging jika ada kesalahan pada query
    }

    $results = [];
    while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) { // Ganti $sql dengan $query
        $results[] = $row;
    }
    echo json_encode($results);
    exit;
}


//Mengambil Data Target Pengujian
if ($request == 'ambiltargetpengujian') {

    $sql = sqlsrv_query($koneksi, "SELECT idtarget, target_pengujian FROM target_pengujian");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}


if ($request == 'cari_jenis_sample') {
    $query = $data->query;
    $sql = sqlsrv_query($koneksi, "SELECT * FROM View_jenis_sample WHERE nama_sample LIKE '%$query%'");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
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
    $sql = sqlsrv_query($koneksi, "SELECT * FROM v_penerimaan_sample ORDER BY idrec DESC");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $row['tgl_terima'] = $row['tgl_terima']->format('Y-m-d'); // Pastikan formatnya Y-m-d
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}
