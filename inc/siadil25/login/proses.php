<?php
session_start();
include 'config.php';

$data = json_decode(file_get_contents("php://input"), true);

// Pastikan data tidak null sebelum mencoba mengaksesnya
if ($data === null) {
    echo json_encode(array('status' => 'fail', 'message' => 'No data received'));
    exit();
}

$request = isset($data['request']) ? $data['request'] : null;

if ($request == 'login') {
    $username = $data['username'];
    $password = md5($data['password']);

    $sql = "SELECT * FROM v_users WHERE username = ? AND password = ?";
    $params = array($username, $password);
    $stmt = sqlsrv_query($koneksi, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $_SESSION['username'] = $row['username'];
        $_SESSION['folder'] = $row['nama_ruang'];
        $_SESSION['nama'] = $row['nama'];
        $_SESSION['loggedin_time'] = time();
        $_SESSION['userid'] = $row['userid'];
        $_SESSION['ruangid'] = $row['ruangid'];

        $response = array(
            'status' => 'success',
            'folder' => $row['nama_ruang'],
            'nama' => $row['nama'],
            'ruangid' => $row['ruangid'],
        );
    } else {
        $response = array('status' => 'fail');
    }

    echo json_encode($response);
    exit;
}

if ($request == 'check_session') {
    if (isset($_SESSION['username'])) {
        $response = array(
            'status' => 'success',
            'username' => $_SESSION['username'],
            'folder' => $_SESSION['folder'],
            'nama' => $_SESSION['nama'],
            'userid' => $_SESSION['userid'],
            'ruangid' => $_SESSION['ruangid']
        );
    } else {
        $response = array('status' => 'fail');
    }
    echo json_encode($response);
    exit;
}

if ($request == 'logout') {
    session_destroy();
    echo json_encode(array('status' => 'success'));
    exit();
}

function check_session_timeout()
{
    $timeout_duration = 1800; // 30 minutes
    if (isset($_SESSION['loggedin_time']) && (time() - $_SESSION['loggedin_time']) > $timeout_duration) {
        session_unset();
        session_destroy();
        return false;
    }
    return true;
}
