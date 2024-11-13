<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:form-login.php");
    exit();
}

include "koneksi.php"; // Pastikan koneksi.php menginisialisasi variabel $conn

$kode = $_GET['kode'] ?? ''; // Menggunakan null coalescing operator untuk menghindari notice

if (!empty($kode)) {
    // Menggunakan prepared statement untuk menghindari SQL injection
    $stmt = $koneksi->prepare("DELETE FROM tbl_pembobotan WHERE id_pembobotan = ?");
    $stmt->bind_param("s", $kode); // Mengasumsikan id_pembobotan adalah string; gunakan "i" jika integer

    if ($stmt->execute()) {
        // Redirect jika berhasil
        header("Location: pembobotan-kriteria.php");
        exit();
    } else {
        // Tampilkan pesan kesalahan
        echo "Error: " . mysqli_error($conn);
    }

    $stmt->close(); // Menutup statement
} else {
    // Redirect jika kode tidak ada
    header("Location: pembobotan-kriteria.php");
    exit();
}
?>