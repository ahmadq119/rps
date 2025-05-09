<?php
include '../../login/config.php';

$data = json_decode(file_get_contents("php://input"));
$request = $data->request;

//tampil awal
if ($request == 'tampil') {
    $sql = sqlsrv_query($koneksi, "SELECT TOP (10) * FROM customer ORDER BY idcustomer DESC");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}
//hapus record yang dipilih
if ($request == 'delete') {
    $idcus = $data->idcus;
    $sql = sqlsrv_query($koneksi, "DELETE FROM customer WHERE idcustomer=$idcustomer");
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
if ($request == 'create') {
    $nama_customer = $data->nama_customer;
    $instansi_perusahaan = $data->instansi_perusahaan;
    $alamat_customer = $data->alamat_customer;
    $no_contact = $data->no_contact;
    $email = $data->email;

    $sql = "INSERT INTO customer (nama_customer, instansi_perusahaan, alamat_customer, no_contact, email) VALUES (?, ?, ?, ?, ?)";
    $params = array($nama_customer, $instansi_perusahaan, $alamat_customer, $no_contact, $email);
    $stmt = sqlsrv_query($koneksi, $sql, $params);
    if ($stmt) {
        $response = array(
            "nama_customer" => $nama_customer,
            "instansi_perusahaan" => $instansi_perusahaan,
            "alamat_customer" => $alamat_customer,
            "no_contact" => $no_contact,
            "email" => $email,
        );
        echo json_encode($response);
    } else {
        http_response_code(500);
        echo json_encode(array('message' => 'Gagal menyimpan data user.'));
    }
    exit;
}

if ($request == 'edit') {
    $currentData = $data->currentData;
    $idcustomer = $currentData->idcustomer;
    $nama_customer = $currentData->nama_customer;
    $instansi_perusahaan = $currentData->instansi_perusahaan;
    $alamat_customer = $currentData->alamat_customer;
    $no_contact = $currentData->no_contact;
    $email = $currentData->email;

    $sql = sqlsrv_query($koneksi, "UPDATE customer 
        SET nama_customer='$nama_customer', instansi_perusahaan='$instansi_perusahaan', alamat_customer='$alamat_customer', no_contact='$no_contact', email='$email'
        WHERE idcustomer=$idcustomer");

    if ($sql) {
        echo json_encode($currentData);
    } else {
        http_response_code(500);
        echo json_encode(array('message' => 'Gagal mengupdate data.'));
    }
    exit;
}

//menampilkan seluruh data
if ($request == 'tampil_all') {
    $sql = sqlsrv_query($koneksi, "SELECT * FROM customer ORDER BY nama_customer DESC");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}
