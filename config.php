<?php

$host = "sakura.proxy.rlwy.net";
$user = "root";
$password = "WvMKkCGkCxxfweESECkulizfWbuFkvrB";
$database = "railway";
$port = 54553;


$conn = new mysqli(
    $host,
    $user,
    $password,
    $database,
    $port
);


if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}


// WIB
date_default_timezone_set("Asia/Jakarta");
?>

?>