<?php
include '../../login/config.php';

$data = json_decode(file_get_contents("php://input"));
$request = $data->request;

//tampil awal
if ($request == 'tampil') {
    $sql = sqlsrv_query($koneksi, "SELECT * FROM v_users ORDER BY nama ASC");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

//pencarian data
if ($request == 'read') {
    $searchQuery = $data->searchQuery;
    $sql = sqlsrv_query($koneksi, "SELECT * FROM v_users WHERE nama LIKE '%$searchQuery%'");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

//tambah data -- koding ini untuk menghindari sql injection
if ($request == 'create') {
    $nama = $data->nama;
    $username = $data->username;
    $password = md5($data->password);
    $email = $data->email;
    $no_contact = $data->no_contact;
    $ruangid = $data->ruangid;

    $sql = "INSERT INTO users (nama, username, password, email, no_contact, ruangid) VALUES (?, ?, ?, ?, ?, ?)";
    $params = array($nama, $username, $password, $email, $no_contact, $ruangid);
    $stmt = sqlsrv_query($koneksi, $sql, $params);

    if ($stmt) {
        $response = array(
            "nama" => $nama,
            "username" => $username,
            "email" => $email,
            "no_contact" => $no_contact,
            "ruangid" => $ruangid,
        );
        echo json_encode($response);
    } else {
        http_response_code(500);
        echo json_encode(array('message' => 'Gagal menyimpan data user.'));
    }
    exit;
}


//update
if ($request == 'update') {
    $currentData = $data->currentData;
    $userid = $currentData->userid;
    $nama = $data->nama;
    $username = $data->username;
    $password = md5($data->password);
    $email = $data->email;
    $no_contact = $data->no_contact;
    $ruangid = $data->ruangid;

    $sql = sqlsrv_query($koneksi, "UPDATE users 
        SET nama='$nama', username='$username', password='$password', email='$email', no_contact='$no_contact'
        WHERE userid=$userid");

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
    $sql = sqlsrv_query($koneksi, "SELECT * FROM v_users ORDER BY nama ASC");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}

//Mengambil Data Ruangan
if ($request == 'ambildataruang') {
    $sql = sqlsrv_query($koneksi, "SELECT * FROM ruangan ORDER BY nama_ruang ASC");
    $response = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $response[] = $row;
    }
    echo json_encode($response);
    exit;
}
