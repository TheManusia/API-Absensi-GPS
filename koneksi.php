<?php

date_default_timezone_set("Asia/Jakarta");

$host = "localhost";
$user = "id12764976_ian";
$password = "Kagaminer1n";
$database = "id12764976_absensi";

$con = mysqli_connect($host, $user, $password, $database);

if (mysqli_connect_errno()) {
    echo "Koneksi gagal : " . mysqli_connect_errno();
}

?>