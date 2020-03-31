<?php

include "koneksi.php";

class a
{
}

$tanggal = json_decode(file_get_contents("https://raw.githubusercontent.com/guangrei/Json-Indonesia-holidays/master/calendar.json"), true);

$username = $_POST["username"];

$harini = date("Y-m-d");
$a = explode("-", $harini);
$b = $a[0].$a[1].$a[2];
$jam = date("H:i:s");

$check_absen = mysqli_num_rows(mysqli_query($con, "SELECT * FROM data_absensi WHERE tanggal = '$harini' AND username = '$username'"));

if (isset($tanggal[$b])) {

    $response = new a();
    $response->success = 0;
    $response->message = $tanggal[$b]['deskripsi'].", tidak ada pengabsenan";
    die(json_encode($response));
} else if (date("D", strtotime($harini)) == "Sun") {

    $response = new a();
    $response->success = 0;
    $response->message = "Hari Minggu, tidak ada pengabsenan";
    die(json_encode($response));
} else if (date("D", strtotime($harini)) == "Sat") {

    $response = new a();
    $response->success = 0;
    $response->message = "Hari Sabtu, tidak ada pengabsenan";
    die(json_encode($response));
} else {

    if ($check_absen == 0) {

        $query = "INSERT INTO data_absensi (username, tanggal, waktu) VALUES ('$username', '$harini', '$jam')";
        $result = mysqli_query($con, $query);

        if (!$result) {
            $response = new a();
            $response->success = 0;
            $response->message = "Absen Gagal";
            $response->username = $username;
            $response->absen = $check_absen;
            $response->date = $harini;
            $response->jam = $jam;
            $response->result = $result;
            die(json_encode($response));
        } else {
            $response = new a();
            $response->success = 1;
            $response->message = "Absen Sukses";
            die(json_encode($response));
        }
    } else {
        $response = new a();
        $response->success = 0;
        $response->message = "Anda sudah absen";
        $response->username = $username;
        die(json_encode($response));
    }
}

mysqli_close($con);
