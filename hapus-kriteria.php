<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:form-login.php");
    exit();
}

include "koneksi.php"; // Pastikan koneksi.php menggunakan mysqli

// Mengambil kode dari parameter GET dengan sanitasi
$kode = isset($_GET['kode']) ? mysqli_real_escape_string($koneksi, $_GET['kode']) : null;

if ($kode) {
    // Menjalankan query DELETE
    $query = mysqli_query($koneksi, "DELETE FROM tbl_kriteria WHERE id_kriteria = '$kode'");
    
    if ($query) {
        // Jika berhasil, redirect ke kriteria.php
        header("Location: kriteria.php");
        exit();
    } else {
        // Jika terjadi kesalahan, tampilkan pesan kesalahan
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    // Jika tidak ada kode, redirect ke kriteria.php
    header("Location: kriteria.php");
    exit();
}

// Menutup koneksi
mysqli_close($koneksi);
?>