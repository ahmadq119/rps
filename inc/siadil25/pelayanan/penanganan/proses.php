<?php
include '../../login/config.php';
require '../../html2pdf/vendor/autoload.php'; // Pastikan HTML2PDF sudah di-load

$data = json_decode(file_get_contents("php://input"));
$request = $data->request;

// Tampil awal
if ($request == 'tampil') {
    $sql = sqlsrv_query($koneksi, "SELECT TOP(20) * from View_penanganan_sample ORDER BY sts_eks ASC, kd_sample DESC");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

// Pencarian data
if ($request == 'cari') {
    $searchQuery = $data->searchQuery;
    $sql = sqlsrv_query($koneksi, "
        SELECT * 
        FROM view_penanganan_sample 
        WHERE kd_sample LIKE '%$searchQuery%'");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

// Update data
if ($request == 'update') {
    $currentData = $data->currentData;
    $kemasan = $currentData->kemasan;
    $kondisi_kemasan = $currentData->kondisi_kemasan;
    $desinfeksi = $currentData->desinfeksi;
    $kodefikasi = $currentData->kodefikasi;
    $lainnya = $currentData->lainnya;
    $distribusi = $currentData->distribusi;
    $masuk_instalasi = $currentData->masuk_instalasi;
    $idpeg = $currentData->idpeg;
    $sts_eks = 1;
    $kd_sample = $currentData->kd_sample;

    $query = "UPDATE penanganan_sample SET 
                        kemasan = ?, 
                        kondisi_kemasan = ?, 
                        desinfeksi = ?, 
                        kodefikasi = ?, 
                        lainnya = ?, 
                        distribusi = ?, 
                        masuk_instalasi = ?, 
                        idpeg = ? ,
                        sts_eks = ?
                      WHERE kd_sample = ?";
    $params = [
        $kemasan,
        $kondisi_kemasan,
        $desinfeksi,
        $kodefikasi,
        $lainnya,
        $distribusi,
        $masuk_instalasi,
        $idpeg,
        $sts_eks,
        $kd_sample
    ];

    $stmt = sqlsrv_query($koneksi, $query, $params);

    if ($stmt) {
        // Ambil kembali data terbaru dari database
        $query = "SELECT * FROM view_penanganan_sample WHERE kd_sample = ?";
        $stmt = sqlsrv_query($koneksi, $query, [$kd_sample]);
        $updatedData = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        echo json_encode([
            'success' => true,
            //'message' => 'Data berhasil diupdate',
            'updatedData' => $updatedData
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Gagal mengupdate data: ' . print_r(sqlsrv_errors(), true)
        ]);
    }
    exit;
}

// Mendapatkan daftar pegawai
if ($request == "pegawai") {
    $sql = sqlsrv_query($koneksi, "SELECT idpeg, nama_pegawai FROM pegawai");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

use Spipu\Html2Pdf\Html2Pdf;

if ($request == 'generate_pdf') {
    $bulan = $_POST['bulan'];
    $tahun = $_POST['tahun'];


    // Query untuk mengambil data dari view_penerimaan_sample
    $query = "SELECT * FROM view_penerimaan_sample 
                  WHERE MONTH(tgl_terima) = ? AND YEAR(tgl_terima) = ?";
    $params = [$bulan, $tahun];
    $stmt = sqlsrv_query($koneksi, $query, $params);

    $data = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $data[] = $row;
    }

    // Generate PDF
    generatePDF($data, $bulan, $tahun);
}


function generatePDF($data, $bulan, $tahun)
{
    $html2pdf = new Html2Pdf('P', 'A4', 'en');
    $html2pdf->setDefaultFont('Arial');

    $bulanNama = getMonthName($bulan);
    $html = "
    <h1 style='text-align: center;'>Laporan Penerimaan Sample</h1>
    <p style='text-align: center;'>Bulan: {$bulanNama}, Tahun: {$tahun}</p>
    <table border='1' cellpadding='5' cellspacing='0' style='width: 100%; border-collapse: collapse;'>
        <thead>
            <tr>
                <th style='text-align: center;'>No</th>
                <th style='text-align: center;'>Tanggal Terima</th>
                <th style='text-align: center;'>Nama Sample</th>
                <th style='text-align: center;'>Jumlah</th>
                <th style='text-align: center;'>Satuan</th>
            </tr>
        </thead>
        <tbody>";

    foreach ($data as $index => $item) {
        $html .= "
            <tr>
                <td style='text-align: center;'>" . ($index + 1) . "</td>
                <td style='text-align: center;'>" . $item['tgl_terima']->format('Y-m-d') . "</td>
                <td style='text-align: left;'>" . $item['nama_sample'] . "</td>
                <td style='text-align: right;'>" . $item['jumlah'] . "</td>
                <td style='text-align: left;'>" . $item['satuan'] . "</td>
            </tr>";
    }

    $html .= "
        </tbody>
    </table>";

    $html2pdf->writeHTML($html);
    $html2pdf->output("Laporan_Penerimaan_Sample_{$bulan}_{$tahun}.pdf", 'D');
}
