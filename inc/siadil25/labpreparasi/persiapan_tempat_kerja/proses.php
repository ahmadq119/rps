<?php
include '../../login/config.php';
session_start();

$data = json_decode(file_get_contents("php://input"));
$request = $data->request;
$ruangid = $_SESSION['ruangid'];

//tampil awal
if ($request == 'tampil') {
    $sql = "SELECT DISTINCT TOP (10) b.kd_sample, b.tgl_terima, c.nama_sample, d.idpeg, e.nama_pegawai 
    from penerimaan_sample b
left join persiapan_tempat_kerja a ON b.kd_sample = a.kd_sample
inner join jenis_sample c ON b.idsample=c.idsample
inner join preparasi_sample d ON b.kd_sample=d.kd_sample
inner join pegawai e ON d.idpeg=e.idpeg";
    $query = sqlsrv_query($koneksi, $sql);
    $response = array();
    while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        // Cek apakah kd_sample ini ada dalam persiapan_tempat_kerja
        $check_sql = "SELECT COUNT(*) AS jumlah FROM persiapan_tempat_kerja WHERE kd_sample=? AND ruangid=?";
        $check_stmt = sqlsrv_query($koneksi, $check_sql, array($row['kd_sample'], $ruangid));
        $check_row = sqlsrv_fetch_array($check_stmt, SQLSRV_FETCH_ASSOC);

        // Jika tidak ditemukan di persiapan_tempat_kerja, tambahkan ke response
        if ($check_row['jumlah'] == 0) {
            $row['tgl_terima'] = $row['tgl_terima']->format('Y-m-d');
            $response[] = $row;
        }
    }
    echo json_encode($response);
    exit;
}

//pencarian data
if ($request == 'cari') {
    $searchQuery = $data->searchQuery;
    $sql = sqlsrv_query($koneksi, "SELECT * FROM customer WHERE nama_customer LIKE '%$searchQuery%'");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

//Tambah Data
if ($request == 'tambahData') {
    $currentData = $data->currentData;
    $kd_sample = $currentData->kd_sample;
    $tgl_kegiatan = $currentData->tgl_terima;
    $nama_kegiatan = $data->nama_kegiatan;

    // Mengatur nilai default jika checkbox tidak dicentang
    $menghidupkan_uv = isset($data->s_uv) ? $data->s_uv : 0;
    $alkohol_1 = isset($data->s_ol) ? $data->s_ol : 0;
    $menyiapkan_bahan = isset($data->s_bh) ? $data->s_bh : 0;
    $menyiapkan_alat = isset($data->s_al) ? $data->s_al : 0;
    $membersihkan_sisa_bahan = isset($data->p_ss) ? $data->p_ss : 0;
    $alkohol_2 = isset($data->p_ol) ? $data->p_ol : 0;
    $membuang_sisa_bahan = isset($data->p_sk) ? $data->p_sk : 0;
    $mengembalikan_alat = isset($data->p_al) ? $data->p_al : 0;

    $idpeg = $currentData->idpeg;
    $ruangid = $_SESSION['ruangid'];
    $keterangan = "";

    $sql = "INSERT INTO persiapan_tempat_kerja (kd_sample, tgl_kegiatan, nama_kegiatan, menghidupkan_uv, alkohol_1, menyiapkan_bahan, menyiapkan_alat, membersihkan_sisa_bahan, alkohol_2, membuang_sisa_bahan, mengembalikan_alat, idpeg, ruangid, keterangan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $params = array($kd_sample, $tgl_kegiatan, $nama_kegiatan, $menghidupkan_uv, $alkohol_1, $menyiapkan_bahan, $menyiapkan_alat, $membersihkan_sisa_bahan, $alkohol_2, $membuang_sisa_bahan, $mengembalikan_alat, $idpeg, $ruangid, $keterangan);
    $stmt = sqlsrv_query($koneksi, $sql, $params);
    if ($stmt === false) {
        if (($errors = sqlsrv_errors()) != null) {
            foreach ($errors as $error) {
                echo "SQLSTATE: " . $error['SQLSTATE'] . "<br />";
                echo "code: " . $error['code'] . "<br />";
                echo "message: " . $error['message'] . "<br />";
            }
        }
        http_response_code(500);
        echo json_encode(array('message' => 'Gagal menyimpan data user.'));
    }
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
