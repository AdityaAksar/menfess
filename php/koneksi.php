<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database_name = "si_23_menfess_db";
    $db = mysqli_connect($hostname, $username, $password, $database_name);
    if ($db->connect_error) {
        echo "Koneksi Gagal";
        die("Gagal");
    }
?>