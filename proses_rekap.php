<?php

include 'koneksi.php';

$tanggal = json_decode(file_get_contents("https://raw.githubusercontent.com/guangrei/Json-Indonesia-holidays/master/calendar.json"), true);

$harini = date("Y-m-d");
$a = explode("-", $harini);
$b = $a[0] . $a[1] . $a[2];

$from = "themanusia@themanusia.xyz";
$to = "minecraftindo0@gmail.com";
$subject = "Laporan Rekap";
$message = "Laporan\nTanggal: $harini\n\n";
$headers = "From:" . $from;

if (date("H:i") == "19:00") {
    if (isset($tanggal[$b])) {
        $message= $tanggal[$b]['deskripsi']. (", Semoga Harimu Menyenangkan :)");
        die();
    } else if (date("D", strtotime($harini)) == "Sun") {
        $message= "Hari Minggu, " . $harini. " Semoga Harimu Menyenangkan :)";
        mail($to, $subject, $message, $headers);
        die($message);
    } else if (date("D", strtotime($harini)) == "Sat") {
        $message= "Hari Sabtu, " . $harini. " Semoga Harimu Menyenangkan :)";
        mail($to, $subject, $message, $headers);
        die($message);
    } else {

        $check = mysqli_query($con, "SELECT * FROM user");

        while($id = mysqli_fetch_array($check)) {

            $query = "SELECT * FROM data_absensi WHERE tanggal = '$harini' AND username = '$id[username]'";
            $result = mysqli_query($con, $query);

            $query1 = "SELECT * FROM detail_absensi WHERE username = '$id[username]'";
            $result1 = mysqli_query($con, $query1);
            $data = mysqli_fetch_array($result1);

            if (mysqli_num_rows($result)) {
                $hadir = $data['hadir'] + 1;
                $query2 = "UPDATE detail_absensi SET hadir = '$hadir' WHERE username = '$data[username]'";
                mysqli_query($con, $query2);

                $message .= "$data[username] = Hadir\nHadir: $data[hadir], Alpa: $data[alpa], Izin: $data[izin]\n\n ";

                mysqli_query($con, "INSERT INTO laporan (id_user, tanggal, type) VALUES ('$data[username]', '$harini', 'hadir')");
            } else {
                $alpa = $data['alpa'] + 1;
                $query2 = "UPDATE detail_absensi SET alpa = '$alpa' WHERE username = '$data[username]'";
                mysqli_query($con, $query2);

                $message .= "$data[username] = Alpa\nHadir: $data[hadir], Alpa: $data[alpa], Izin: $data[izin]\n\n ";

                mysqli_query($con, "INSERT INTO laporan (id_user, tanggal, type) VALUES ('$data[username]', '$harini', 'alpa')");
            }
        } 
        mail($to, $subject, $message, $headers);
        echo "gud";
    }
}else {
    echo "blom";
}
?>