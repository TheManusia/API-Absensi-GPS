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

$query = mysqli_query($con, "SELECT * FROM user WHERE username='$username' AND password=md5('$password')");

$row = mysqli_fetch_array($query, MYSQLI_ASSOC);

if (!empty($row)){
$response = new usr();
$response->success = 1;
$response->message = "Selamat datang ".$row['nama'];
$response->id = $row['username'];
$response->username = $row['nama'];
$response->gambar = $row['gambar'];
die(json_encode($response));

} else {
$response = new usr();
$response->success = 0;
$response->message = "Username atau password salah";
die(json_encode($response));
}

mysqli_close($con);

?>