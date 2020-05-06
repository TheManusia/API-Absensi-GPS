<?php

include 'koneksi.php';

class a {

}

$nama = $_POST['nama'];
$username = $_POST['username'];
$password = $_POST['password'];
$newpassword = $_POST['newpassword'];
$gambar = $_POST['gambar'];

$query = "SELECT * FROM user WHERE username = '$username' AND password = md5('$password')";

$result = mysqli_num_rows(mysqli_query($con, $query));

if ($result) {
    if ($gambar != "") {
        $angka = rand(0, 999);
        $nama_gambar = $angka .  " - " . date("Y_m_d") . " - ". $username;
        $destination = "img/$nama_gambar.png";
        file_put_contents($destination, base64_decode($gambar));

        $ada = ", gambar = '$nama_gambar'";
    } else {
        $ada = "";
    }

    if ($newpassword != "") {
        $query1 = "UPDATE user SET nama = '$nama', password = md5('$newpassword') $ada WHERE username = '$username'";
    } else {
        $query1 = "UPDATE user SET nama = '$nama' $ada WHERE username = '$username'";
    }

    $result1 = mysqli_query($con, $query1);
    
    if (!$result1) {
        $response = new a();
        $response->success = 0;
        $response->message = "Gagal update profile";
        $response->result = $result;
        die(json_encode($response));
    } else {
        $response = new a();
        $response->success = 1;
        $response->message = "Berhasil update profile";
        $response->username = $username;        
        $response->nama = $nama;
        $response->result1 = $result1;
        die(json_encode($response));
    }
} else {
    $response = new a();
    $response->success = 0;
    $response->message = "Password salah";
    $response->username = $username;
    $response->password = $password;
    $response->nama = $nama;
    die(json_encode($response));
}
?>