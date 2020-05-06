<?php

include "koneksi.php";

class usr{}

$username = $_POST["username"];
$password = $_POST["password"];

if ((empty($username)) || (empty($password))) {
$response = new usr();
$response->success = 0;
$response->message = "Kolom tidak boleh kosong";
die(json_encode($response));
}

$harini = date("Y-m-d");
$a = explode("-", $harini);
$b = $a[0] . $a[1] . $a[2];



$query = mysqli_query($con, "SELECT * FROM user WHERE username='$username' AND password=md5('$password')");
$query1 = mysqli_query($con, "SELECT * FROM admin WHERE username='$username' AND password=md5('$password')");

$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
$row1 = mysqli_fetch_array($query1, MYSQLI_ASSOC);

if (!empty($row)){

    $check_absen = mysqli_num_rows(mysqli_query($con, "SELECT * FROM data_absensi WHERE tanggal = '$harini' AND username = '$username'"));
    $check_data = mysqli_query($con, "SELECT * FROM detail_absensi WHERE username='$username'");

    $data = mysqli_fetch_array($check_data);
    $izin = $data['izin'];
    $alpa = $data['alpa'];

    if ($check_absen == 0) {
        $absen = "Anda belum absen hari ini.";
    } else {
        $absen = "Anda sudah absen";
    }

    $response = new usr();
    $response->success = 1;
    $response->message = "Selamat datang ".$row['nama'];
    $response->id = $row['username'];
    $response->username = $row['nama'];
    $response->gambar = $row['gambar'];
    $response->absen = $absen;
    $response->izin = $izin;
    $response->alpa = $alpa;
    $response->role = "User";
    die(json_encode($response));

} elseif (!empty($row1)) {
    $response = new usr();
    $response->success = 1;
    $response->message = "Selamat datang " . $row['nama'];
    $response->id = $row['username'];
    $response->username = $row['nama'];
    $response->role = "Admin";
    die(json_encode($response));

} else {
$response = new usr();
$response->success = 0; 
$response->message = "Username atau password salah";
die(json_encode($response));
}

mysqli_close($con);
