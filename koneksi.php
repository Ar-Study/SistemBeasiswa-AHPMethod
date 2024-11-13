<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'db_beasiswa';

// Create connection
$koneksi = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$koneksi) {
    die("Koneksi Gagal: " . mysqli_connect_error());
} else {
    echo "Koneksi Berhasil";
}
?>