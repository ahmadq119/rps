<?php
include '../../login/config.php';
session_start();

$data = json_decode(file_get_contents("php://input"));
$request = $data->request;
$ruangid = $_SESSION['ruangid'];

//tampil awal
if ($request == 'tampil') {
    // Ambil data dari tabel sample_labsensori
    $sql = "SELECT DISTINCT 
                a.kd_sample, a.metode_pengujian, a.tgl_uji, a.idpeg, 
                c.nama_pegawai, c.nip_pegawai, 
                b.kd_sample AS kd_sample_persiapan, d.idsample, e.nama_sample
            FROM penerimaan_sample AS d 
            INNER JOIN sample_labformalin AS a 
                ON d.kd_sample = a.kd_sample 
            INNER JOIN pegawai AS c 
                ON a.idpeg = c.idpeg 
            INNER JOIN jenis_sample AS e 
                ON d.idsample = e.idsample 
            LEFT OUTER JOIN persiapan_tempat_kerja AS b 
                ON a.kd_sample = b.kd_sample";

    $query = sqlsrv_query($koneksi, $sql);
    $response = array();

    while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        // Cek apakah kd_sample ini ada dalam persiapan_tempat_kerja
        $check_sql = "SELECT COUNT(*) AS jumlah FROM persiapan_tempat_kerja WHERE kd_sample=? AND ruangid=?";
        $check_stmt = sqlsrv_query($koneksi, $check_sql, array($row['kd_sample'], $ruangid));
        $check_row = sqlsrv_fetch_array($check_stmt, SQLSRV_FETCH_ASSOC);

        // Jika tidak ditemukan di persiapan_tempat_kerja, tambahkan ke response
        if ($check_row['jumlah'] == 0) {
            $row['tgl_uji'] = $row['tgl_uji']->format('Y-m-d');
            $response[] = $row;
        }
    }

    // Jika tidak ada data yang memenuhi syarat, kirim array kosong
    echo json_encode($response);
    exit;
}

//pencarian data
if ($request == 'cari') {
    $searchQuery = $data->searchQuery;
    $query = "SELECT DISTINCT 
                a.kd_sample, a.metode_pengujian,a.tgl_uji, a.idpeg, c.nama_pegawai, c.nip_pegawai, 
                b.kd_sample AS kd_sample_persiapan, d.idsample, e.nama_sample
            FROM penerimaan_sample as d INNER JOIN
                sample_labformalin as a INNER JOIN
                pegawai as c ON a.idpeg = c.idpeg ON d.kd_sample = a.kd_sample INNER JOIN
                jenis_sample as e ON d.idsample = e.idsample LEFT OUTER JOIN
                persiapan_tempat_kerja as b ON a.kd_sample = b.kd_sample
			WHERE b.kd_sample IS NULL AND a.kd_sample LIKE '%$searchQuery%'";
    $sql = sqlsrv_query($koneksi, $query);
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $row['tgl_uji'] = $row['tgl_uji']->format('Y-m-d');
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

//Tambah Data
if ($request == 'tambahData') {
    $currentData = $data->currentData;
    $kd_sample = $currentData->kd_sample;
    $tgl_kegiatan = $currentData->tgl_uji;
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
    $query = $data->query;
    $sql = sqlsrv_query($koneksi, "SELECT * FROM pegawai WHERE nama_pegawai like '%$query%' ORDER BY nama_pegawai ASC");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}
