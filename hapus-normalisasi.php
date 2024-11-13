<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:form-login.php");
    exit();
}

include "koneksi.php"; // Pastikan koneksi.php menggunakan mysqli

// Mengambil kode dari URL dan melakukan sanitasi
$kode = isset($_GET['kode']) ? mysqli_real_escape_string($koneksi, $_GET['kode']) : '';

if (!empty($kode)) {
    // Melakukan query untuk menghapus data
    $query = mysqli_query($koneksi, "DELETE FROM tbl_normalisasi WHERE id_normalisasi = '$kode'");

    if ($query) {
        // Jika berhasil, redirect ke halaman normalisasi
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=normalisasi.php">';
        exit;
    } else {
        // Jika gagal, tampilkan pesan kesalahan
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    // Jika kode tidak ada, redirect ke halaman normalisasi
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=normalisasi.php">';
    exit;
}
?>