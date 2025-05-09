<?php
include '../../login/config.php';

$data = json_decode(file_get_contents("php://input"));
$request = $data->request;

if ($request == "tampilawal") {
    $sql = "SELECT TOP (50)
    kd_sample,
    STUFF((
        SELECT DISTINCT CHAR(10) + CHAR(13) + target_pengujian
        FROM View_penerimaan_sample_mikrobiologi AS sub
        WHERE sub.kd_sample = main.kd_sample
        FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 2, '') AS target_pengujian,
    STUFF((
        SELECT DISTINCT CHAR(10) + CHAR(13) + acuan
        FROM View_penerimaan_sample_mikrobiologi AS sub
        WHERE sub.kd_sample = main.kd_sample
        FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 2, '') AS acuan,
    nama_ruang,
    tgl_terima,
    tgl_uji,
    tgl_hasil,
    idmtd_isolasi,
    bahan,
    suhu_inkubasi,
    hasil_isolasi_awal,
    nama_bakteri_ditemukan,
    metode_pengujian,
    idpeg_analis,
    idpeg_penyelia,
    analis,
    nip_analis,
    penyelia,
    nip_penyelia,
    nama_sample,
    jumlah,
    satuan,
    panjang,
    berat,
    no_reg,
    tgl_terima_dipelayanan,
    tgl_harus_uji,
    sts_terima
FROM View_penerimaan_sample_mikrobiologi AS main
GROUP BY 
    kd_sample, nama_ruang, tgl_terima, tgl_uji, tgl_hasil, 
    idmtd_isolasi, bahan, suhu_inkubasi, hasil_isolasi_awal, 
    nama_bakteri_ditemukan, metode_pengujian, idpeg_analis, idpeg_penyelia, 
    analis, nip_analis, penyelia, nip_penyelia, nama_sample, jumlah, satuan, 
    panjang, berat, no_reg, tgl_terima_dipelayanan, tgl_harus_uji, sts_terima
ORDER BY tgl_terima DESC";
    $query = sqlsrv_query($koneksi, $sql);
    $response = array();
    while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $row['tgl_terima'] = isset($row['tgl_terima']) ? $row['tgl_terima']->format('Y-m-d') : null;
        $row['tgl_uji'] = isset($row['tgl_uji']) ? $row['tgl_uji']->format('Y-m-d') : null;
        $row['tgl_hasil'] = isset($row['tgl_hasil']) ? $row['tgl_hasil']->format('Y-m-d') : null;
        $row['tgl_terima_dipelayanan'] = isset($row['tgl_terima_dipelayanan']) ? $row['tgl_terima_dipelayanan']->format('Y-m-d') : null;
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
    $sql = "SELECT 
        kd_sample,
        STUFF((
            SELECT DISTINCT CHAR(10) + CHAR(13) + target_pengujian
            FROM View_penerimaan_sample_mikrobiologi AS sub
            WHERE sub.kd_sample = main.kd_sample
            FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 2, '') AS target_pengujian,
        STUFF((
            SELECT DISTINCT CHAR(10) + CHAR(13) + acuan
            FROM View_penerimaan_sample_mikrobiologi AS sub
            WHERE sub.kd_sample = main.kd_sample
            FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 2, '') AS acuan,
        nama_ruang,
        tgl_terima,
        tgl_uji,
        tgl_hasil,
        idmtd_isolasi,
        bahan,
        suhu_inkubasi,
        hasil_isolasi_awal,
        nama_bakteri_ditemukan,
        metode_pengujian,
        idpeg_analis,
        idpeg_penyelia,
        analis,
        nip_analis,
        penyelia,
        nip_penyelia,
        nama_sample,
        jumlah,
        satuan,
        panjang,
        berat,
        no_reg,
        tgl_terima_dipelayanan,
        tgl_harus_uji,
        sts_terima
    FROM View_penerimaan_sample_mikrobiologi AS main
    WHERE kd_sample LIKE ?
    GROUP BY 
        kd_sample, nama_ruang, tgl_terima, tgl_uji, tgl_hasil, 
        idmtd_isolasi, bahan, suhu_inkubasi, hasil_isolasi_awal, 
        nama_bakteri_ditemukan, metode_pengujian, idpeg_analis, idpeg_penyelia, 
        analis, nip_analis, penyelia, nip_penyelia, nama_sample, jumlah, satuan, 
        panjang, berat, no_reg, tgl_terima_dipelayanan, tgl_harus_uji, sts_terima";

    // Eksekusi query dengan parameter
    $query = sqlsrv_query($koneksi, $sql, [$searchParam]);

    if ($query === false) {
        echo json_encode(["error" => sqlsrv_errors()]);
        exit;
    }

    $response = array();
    while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        // Konversi format tanggal ke Y-m-d jika ada
        if ($row['tgl_terima_dipelayanan'] instanceof DateTime) {
            $row['tgl_terima_dipelayanan'] = $row['tgl_terima_dipelayanan']->format('Y-m-d');
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
    $tgl_terima = $currentData->tgl_terima_dipelayanan;
    $tgl_uji = $currentData->tgl_harus_uji;
    $idmtd_isolasi = $currentData->idmtd_isolasi;
    $bahan = $currentData->bahan;
    $suhu = $currentData->suhu_inkubasi;
    $hasil_awal = $currentData->hasil_isolasi_awal;
    $sts = 1;
    //$idpeg = $currentData->idpeg;

    try {
        // ** 1 Cek apakah kd_sample sudah ada**
        $check_sql = "SELECT COUNT(*) AS jumlah FROM sample_mikrobiologi WHERE kd_sample = ?";
        $check_stmt = sqlsrv_query($koneksi, $check_sql, array($kd_sample));
        $row = sqlsrv_fetch_array($check_stmt, SQLSRV_FETCH_ASSOC);

        if ($row['jumlah'] > 0) {
            // **2️ Jika ada, lakukan UPDATE**
            $sql = "UPDATE sample_mikrobiologi 
            SET tgl_terima = ?, tgl_uji = ?, idmtd_isolasi = ?, bahan = ?, suhu_inkubasi = ?, hasil_isolasi_awal = ?, sts_terima = ?
            WHERE kd_sample = ?";
            $params = array($tgl_terima, $tgl_uji, $idmtd_isolasi, $bahan, $suhu, $hasil_awal, $sts, $kd_sample);
        } else {
            // **3️ Jika tidak ada, lakukan INSERT**
            $sql = "INSERT INTO sample_mikrobiologi (kd_sample, tgl_terima, tgl_uji, idmtd_isolasi, bahan, suhu_inkubasi, hasil_isolasi_awal, sts_terima) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $params = array($kd_sample, $tgl_terima, $tgl_uji, $idmtd_isolasi, $bahan, $suhu, $hasil_awal, $sts);
        }

        // **4️ Jalankan Query INSERT atau UPDATE**
        $stmt = sqlsrv_query($koneksi, $sql, $params);
        if (!$stmt) {
            throw new Exception("Gagal memperbarui data: " . print_r(sqlsrv_errors(), true));
        }


        // **5️ Ambil data terbaru yang diperbarui**
        $query = "SELECT 
    kd_sample,
    STUFF((
        SELECT DISTINCT CHAR(10) + CHAR(13) + target_pengujian
        FROM View_penerimaan_sample_mikrobiologi AS sub
        WHERE sub.kd_sample = main.kd_sample
        FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 2, '') AS target_pengujian,
    STUFF((
        SELECT DISTINCT CHAR(10) + CHAR(13) + acuan
        FROM View_penerimaan_sample_mikrobiologi AS sub
        WHERE sub.kd_sample = main.kd_sample
        FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 2, '') AS acuan,
    nama_ruang,
    tgl_terima,
    tgl_uji,
    tgl_hasil,
    idmtd_isolasi,
    bahan,
    suhu_inkubasi,
    hasil_isolasi_awal,
    nama_bakteri_ditemukan,
    metode_pengujian,
    idpeg_analis,
    idpeg_penyelia,
    analis,
    nip_analis,
    penyelia,
    nip_penyelia,
    nama_sample,
    jumlah,
    satuan,
    panjang,
    berat,
    no_reg,
    tgl_terima_dipelayanan,
    tgl_harus_uji,
    sts_terima
FROM View_penerimaan_sample_mikrobiologi AS main
WHERE kd_sample = ?
GROUP BY 
    kd_sample, nama_ruang, tgl_terima, tgl_uji, tgl_hasil, 
    idmtd_isolasi, bahan, suhu_inkubasi, hasil_isolasi_awal, 
    nama_bakteri_ditemukan, metode_pengujian, idpeg_analis, idpeg_penyelia, 
    analis, nip_analis, penyelia, nip_penyelia, nama_sample, jumlah, satuan, 
    panjang, berat, no_reg, tgl_terima_dipelayanan, tgl_harus_uji, sts_terima";

        $stmt = sqlsrv_query($koneksi, $query, [$kd_sample]);
        $updatedData = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        // **6️ Konversi DateTime ke format Y-m-d jika ada**
        if ($updatedData['tgl_terima_dipelayanan'] instanceof DateTime) {
            $updatedData['tgl_terima_dipelayanan'] = $updatedData['tgl_terima_dipelayanan']->format('Y-m-d');
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

if ($request == 'ambildatametodeisolasi') {
    $sql = sqlsrv_query($koneksi, "SELECT * FROM metode_isolasi");
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
