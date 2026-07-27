<?php

$host = "sakura.proxy.rlwy.net"; // host Railway kamu
$user = "root";              // username Railway
$password = "WvMKkCGkCxxfweESECkulizfWbuFkvrB"; // password Railway
$database = "railway";       // nama database Railway
$port = 54553;               // port Railway


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

?>