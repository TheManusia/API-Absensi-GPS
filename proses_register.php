<?php

include 'koneksi.php';

class a{

}

$nama = $_POST['nama'];
$username = $_POST['username'];
$password = $_POST['password'];

$num_rows = mysqli_num_rows(mysqli_query($con, "SELECT * FROM user WHERE username = '$username'"));

if ($num_rows == 0) {
    $query = "INSERT INTO user (username, password, nama) VALUES ('$username', md5('$password'), '$nama')";
    $result = mysqli_query($con, $query);

    if (!$result) {
        $response = new a();
        $response->success = 0;
        $response->message = "Register Failed";
        $response->username = $username;
        $response->result = $result;
        die(json_encode($response));
    } else {
        $query = "INSERT INTO detail_absensi (username, hadir, alpa, izin) VALUES ('$username', 0, 0, 0)";
        mysqli_query($con, $query);
        $response = new a();
        $response->success = 1;
        $response->message = "Register Success";
        $response->num_rows = $num_rows;
        die(json_encode($response));
    }
} else {
    $response = new a();
    $response->success = 0;
    $response->num_rows = $num_rows;
    $response->message = "Username Already Taken";
    die(json_encode($response));
}

mysqli_close($con);

?>