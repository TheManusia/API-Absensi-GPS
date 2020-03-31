<?php 

include 'koneksi.php';

$tanggal = json_decode(file_get_contents("https://raw.githubusercontent.com/guangrei/Json-Indonesia-holidays/master/calendar.json"), true);

$harini = date("Y-m-d");
$a = explode("-", $harini);
$b = $a[0] . $a[1] . $a[2];

if (isset($tanggal[$b])) {
    
    die($tanggal[$b]['deskripsi']);
} else if (date("D", strtotime($harini)) == "Sun") {

    die("Hari Minggu, ".$harini);
} else if (date("D", strtotime($harini)) == "Sat") {

    die("Hari Sabtu, ".$harini);
} else {

    $query = "SELECT * FROM data_absensi WHERE tanggal = $harini";
    $result = mysqli_query($con, $query);

    $query1 = "SELECT * FROM detail_absensi";
    $result1 = mysqli_query($con, $query1);

    if (mysqli_num_rows($result)) {
        while ($data = mysqli_fetch_array($result1)) {
            $hadir = $data['hadir'] + 1;
            $query2 = "UPDATE detail_absensi SET hadir = '$hadir' WHERE username = '$data[username]'";
            mysqli_query($con, $query2);
        }
    } else {
        while ($data = mysqli_fetch_array($result1)) {
            $alpa = $data['alpa'] + 1;
            $query2 = "UPDATE detail_absensi SET alpa = '$alpa' WHERE username = '$data[username]'";
            mysqli_query($con, $query2);
        }
    }
}
