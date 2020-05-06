<?php

date_default_timezone_set("Asia/Jakarta");

$host = "localhost";
$user = "themanusia_ian";
$password = "RSUPACjJ";
$database = "themanusia_absensi";

$con = mysqli_connect($host, $user, $password, $database);

if (mysqli_connect_errno()) {
    echo "Koneksi gagal : " . mysqli_connect_errno();
}

?>