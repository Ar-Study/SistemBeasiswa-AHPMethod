<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:form-login.php");
    exit();
}

include "koneksi.php"; // Pastikan koneksi.php menggunakan mysqli

// Ambil data dari form dan sanitasi
$nim = mysqli_real_escape_string($koneksi, $_POST['nim']);
$nama = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
$program_studi = mysqli_real_escape_string($koneksi, $_POST['program_studi']);
$kelas = mysqli_real_escape_string($koneksi, $_POST['kelas']);
$tempat_lahir = mysqli_real_escape_string($koneksi, $_POST['tempat_lahir']);
$tanggal_lahir = mysqli_real_escape_string($koneksi, $_POST['tanggal_lahir']);
$jenis_kelamin = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);
$agama = mysqli_real_escape_string($koneksi, $_POST['agama']);
$alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
$telepon = mysqli_real_escape_string($koneksi, $_POST['no_telepon']);
$status = $_POST['status'];

if ($status == "0") {
    // Insert new record
    $query = mysqli_query($koneksi, "INSERT INTO tbl_mahasiswa (nim, nama_lengkap, program_studi, kelas, tempat_lahir, tanggal_lahir, jenis_kelamin, agama, alamat, no_telepon) 
    VALUES ('$nim', '$nama', '$program_studi', '$kelas', '$tempat_lahir', '$tanggal_lahir', '$jenis_kelamin', '$agama', '$alamat', '$telepon')");
} else {
    // Update existing record
    $kode = mysqli_real_escape_string($koneksi, $_POST['kode']);
    $query = mysqli_query($koneksi, "UPDATE tbl_mahasiswa SET 
    nama_lengkap = '$nama',
    program_studi = '$program_studi',
    kelas = '$kelas',
    tempat_lahir = '$tempat_lahir',
    tanggal_lahir = '$tanggal_lahir',
    jenis_kelamin = '$jenis_kelamin',
    agama = '$agama',
    alamat = '$alamat',
    no_telepon = '$telepon'
    WHERE nim = '$kode'");
}

if ($query) {
    // Redirect to mahasiswa.php if successful
    header("Location: mahasiswa.php");
    exit();
} else {
    // Output error message
    echo "Error: " . mysqli_error($koneksi);
}
?>