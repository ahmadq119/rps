<?php
include '../../login/config.php';
session_start();

$data = json_decode(file_get_contents("php://input"));
$request = $data->request;

//tampil awal
if ($request == 'tampil') {
    $ruangid = $_SESSION['ruangid'];
    $sql = "SELECT TOP (20) * FROM view_rek_rh_temperatur Where ruangid=? ORDER BY tgl_kegiatan DESC";
    $params = array($ruangid);
    $query = sqlsrv_query($koneksi, $sql, $params);

    $response = array();
    while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $row['tgl_kegiatan'] = $row['tgl_kegiatan']->format('Y-m-d'); // Pastikan formatnya Y-m-d
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

//tambah data -- koding ini untuk menghindari sql injection
if ($request == 'create') {
    // Ambil data dari request    
    $ruangid = $data->ruangid ?? '';
    $tgl_kegiatan = $data->tgl_kegiatan ?? '';
    $nil_rh = $data->nil_rh ?? '';
    $nil_temp = $data->nil_temp ?? '';
    $idpeg = $data->idpeg ?? '';

    // Debug log untuk data yang diterima    
    //file_put_contents('debug.log', print_r($data, true), FILE_APPEND);

    $success = true; // Flag untuk status sukses  

    $sql = "INSERT INTO rekaman_rh_temperatur     
                      (tgl_kegiatan, nil_rh, nil_temp, idpeg, ruangid)     
                      VALUES (?, ?, ?, ?, ?)";
    $params = array($tgl_kegiatan, $nil_rh, $nil_temp, $idpeg, $ruangid);
    $stmt = sqlsrv_query($koneksi, $sql, $params);
    if ($stmt) {
        $responseItems[] = array(
            "ruangid" => $tgl_kegiatan,
            "tanggal" => $nil_rh,
            "waktu" => $nil_temp,
            "nama_bahan" => $idpeg,
            "jumlah_bahan" => $ruangid,
        );
        echo json_encode($response);
    } else {
        http_response_code(500);
        echo json_encode(array('message' => 'Gagal menyimpan data rekaman.'));
    }
    exit;
}

//update
if ($request == 'update') {
    $currentData = $data->currentData;
    $id = $currentData->id;
    $tgl_kegiatan = $currentData->tgl_kegiatan;
    $nil_rh = $currentData->nil_rh;
    $nil_temp = $currentData->nil_temp;
    $idpeg = $currentData->idpeg;
    $ruangid = $currentData->ruangid;

    $sql = sqlsrv_query($koneksi, "UPDATE rekaman_rh_temperatur 
        SET tgl_kegiatan='$tgl_kegiatan', nil_rh='$nil_rh', nil_temp='$nil_temp', idpeg='$idpeg', ruangid='$ruangid'
        WHERE id=$id");

    if ($sql) {
        echo json_encode($currentData);
    } else {
        http_response_code(500);
        echo json_encode(array('message' => 'Gagal mengupdate data.'));
    }
    exit;
}

//menampilkan seluruh data
if ($request == 'cari_seluruh_data') {
    $sql = sqlsrv_query($koneksi, "SELECT * FROM view_rek_rh_temperatur ORDER BY tgl_kegiatan DESC");
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
