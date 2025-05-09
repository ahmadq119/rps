<?php
$serverName = "36.94.61.122";
//$serverName = "BP2MHKP";
$connectionOptions = array(
    "Database" => "SIADIL",
    "Uid" => "sa",
    "PWD" => "BINj8pOPQ"
);

// Establishes the connection
$koneksi = sqlsrv_connect($serverName, $connectionOptions);

if ($koneksi === false) {
    die(print_r(sqlsrv_errors(), true));
}
