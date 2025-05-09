<?php
include '../../login/config.php';
session_start();

$data = json_decode(file_get_contents("php://input"));
$request = $data->request;

//tampil awal
if ($request == 'tampil') {
    $ruangid = $_SESSION['ruangid'];
    $sql = "SELECT * FROM view_permintaan_bahan Where ruangid=? and sts=0 ORDER BY tanggal DESC";
    $params = array($ruangid);
    $query = sqlsrv_query($koneksi, $sql, $params);

    $response = array();
    while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $row['tanggal'] = $row['tanggal']->format('Y-m-d');
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

//pencarian data
if ($request == 'read') {
    $searchQuery = $data->searchQuery;
    $sql = sqlsrv_query($koneksi, "SELECT * FROM view_permintaan_bahan WHERE nama_bahan+nama_alat LIKE '%$searchQuery%'");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

//tambah data -- koding ini untuk menghindari sql injection
if ($request == 'create') {
    // Ambil data dari request    
    $ruangid = $data->ruangid ?? '';
    $tanggal = $data->tanggal ?? '';
    $waktu = $data->waktu ?? '';
    $idpeg = $data->idpeg ?? '';
    $dataItems = $data->items ?? [];
    $sts = '0';

    // Debug log untuk data yang diterima    
    //file_put_contents('debug.log', print_r($data, true), FILE_APPEND);

    $success = true; // Flag untuk status sukses  
    $responseItems = []; // Array untuk menyimpan item yang berhasil disimpan  

    try {
        foreach ($dataItems as $item) {
            $nama_bahan = $item->namaBahan ?? '';
            $jumlah_bahan = $item->jumlahBahan ?? '';
            $nama_alat = $item->namaAlat ?? '';
            $jumlah_alat = $item->jumlahAlat ?? '';

            if (empty($nama_bahan) && empty($nama_alat)) {
                continue;
            }

            $sql = "INSERT INTO permintaan_bahan     
                      (ruangid, tanggal, waktu, nama_bahan, jumlah_bahan, nama_alat, jumlah_alat, idpeg_ruang, sts)     
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $params = array($ruangid, $tanggal, $waktu, $nama_bahan, $jumlah_bahan, $nama_alat, $jumlah_alat, $idpeg, $sts);
            $stmt = sqlsrv_query($koneksi, $sql, $params);
            if ($stmt) {
                $responseItems[] = array(
                    "ruangid" => $ruangid,
                    "tanggal" => $tanggal,
                    "waktu" => $waktu,
                    "nama_bahan" => $nama_bahan,
                    "jumlah_bahan" => $jumlah_bahan,
                    "nama_alat" => $nama_alat,
                    "jumlah_alat" => $jumlah_alat,
                    "idpeg_ruang" => $idpeg,
                    "sts" => $sts,
                );
            } else {
                $success = false; // Set flag ke false jika ada yang gagal  
                break; // Keluar dari loop jika ada kesalahan  
            }
        }

        if ($success) {
            echo json_encode(['status' => 'success', 'items' => $responseItems]);
        } else {
            http_response_code(500);
            echo json_encode(array('status' => 'error', 'message' => 'Gagal menyimpan data.'));
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    exit;
}

//update
if ($request == 'update') {
    $currentData = $data->currentData;
    $idbahan = $currentData->idbahan;
    $tanggal = $currentData->tanggal;
    $waktu = $currentData->waktu;
    $nama_bahan = $currentData->nama_bahan;
    $jumlah_bahan = $currentData->jumlah_bahan;
    $nama_alat = $currentData->nama_alat;
    $jumlah_alat = $currentData->jumlah_alat;
    $idpeg = $currentData->idpeg_ruang;
    $ruangid = $currentData->ruangid;

    try {
        // Mulai transaksi
        sqlsrv_begin_transaction($koneksi);

        $sql = "UPDATE permintaan_bahan SET tanggal=?, waktu=?, nama_bahan=?, jumlah_bahan=?, nama_alat=?, jumlah_alat=?, idpeg_ruang=? WHERE idbahan=?";
        $params = array($tanggal, $waktu, $nama_bahan, $jumlah_bahan, $nama_alat, $jumlah_alat, $idpeg, $idbahan);
        $stmt = sqlsrv_query($koneksi, $sql, $params);

        if ($stmt) {
            // Ambil data terbaru yang diperbarui
            $selectSql = "SELECT * FROM view_permintaan_bahan WHERE idbahan=?";
            $paramsSelect = array($idbahan);
            $result = sqlsrv_query($koneksi, $selectSql, $paramsSelect);
            $response = array();

            if ($result) {
                $updatedData = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
                $updatedData['tanggal'] = $updatedData['tanggal']->format('Y-m-d');
                $response[] = $updatedData;

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

//menampilkan seluruh data
if ($request == 'cari_seluruh_data') {
    $sql = sqlsrv_query($koneksi, "SELECT * FROM view_permintaan_bahan ORDER BY tanggal DESC");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
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
