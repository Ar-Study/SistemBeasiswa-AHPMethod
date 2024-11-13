<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:form-login.php");
    exit();
}

include "koneksi.php"; // Pastikan koneksi.php menggunakan mysqli

$kode = $_GET['kode'];

if (isset($kode)) {
    // Sanitasi input untuk menghindari SQL Injection
    $kode = mysqli_real_escape_string($koneksi, $kode);
    
    // Query untuk menghapus data
    $query = mysqli_query($koneksi, "DELETE FROM tbl_mahasiswa WHERE nim = '$kode'");
    
    if ($query) {
        // Redirect ke halaman mahasiswa.php jika berhasil
        header("Location: mahasiswa.php");
        exit();
    } else {
        // Tampilkan pesan error jika query gagal
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    // Jika kode tidak ada, redirect ke halaman mahasiswa.php
    header("Location: mahasiswa.php");
    exit();
}
?>