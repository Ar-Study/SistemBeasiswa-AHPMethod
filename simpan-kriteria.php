<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:form-login.php");
    exit();
}

include "koneksi.php"; // Pastikan koneksi.php menggunakan mysqli

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil dan menyiapkan data
    $mahasiswa = mysqli_real_escape_string($koneksi, $_POST['nim']);
    $penghasilan_ortu = mysqli_real_escape_string($koneksi, $_POST['penghasilan_ortu']);
    $nilai_ipk = mysqli_real_escape_string($koneksi, $_POST['nilai_ipk']);
    $semester = mysqli_real_escape_string($koneksi, $_POST['semester']);
    $tanggungan_ortu = mysqli_real_escape_string($koneksi, $_POST['tanggungan_ortu']);
    $saudara_kandung = mysqli_real_escape_string($koneksi, $_POST['saudara_kandung']);
    $status = $_POST['status'];

    // Mengambil ID kriteria maksimum
    $query = mysqli_query($koneksi, "SELECT max(id_kriteria) as id FROM tbl_kriteria");
    $data = mysqli_fetch_array($query);

    // Memisahkan angka dari string
    if ($data['id']) {
        $angka = (int) substr($data['id'], 3); // Mengambil angka setelah "KRT"
        $nilai = $angka + 1; // Menambahkan 1 ke angka
    } else {
        $nilai = 1; // Jika tidak ada id, mulai dari 1
    }

    $id = "KRT" . sprintf("%03s", $nilai); // Membuat ID baru

    // Menjalankan query sesuai dengan status
    if ($status == "0") {
        $stmt = mysqli_prepare($koneksi, "INSERT INTO tbl_kriteria (id_kriteria, nim, penghasilan_ortu, nilai_ipk, semester, tanggungan_ortu, saudara_kandung) VALUES (?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssssiii", $id, $mahasiswa, $penghasilan_ortu, $nilai_ipk, $semester, $tanggungan_ortu, $saudara_kandung);
    } else {
        $kode = mysqli_real_escape_string($koneksi, $_POST['kode']);
        $stmt = mysqli_prepare($koneksi, "UPDATE tbl_kriteria SET nim = ?, penghasilan_ortu = ?, nilai_ipk = ?, semester = ?, tanggungan_ortu = ?, saudara_kandung = ? WHERE id_kriteria = ?");
        mysqli_stmt_bind_param($stmt, "ssiiisi", $mahasiswa, $penghasilan_ortu, $nilai_ipk, $semester, $tanggungan_ortu, $saudara_kandung, $kode);
    }

    // Eksekusi statement
    if (mysqli_stmt_execute($stmt)) {
        header("Location: kriteria.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }

    // Menutup statement
    mysqli_stmt_close($stmt);
}

// Menutup koneksi
mysqli_close($koneksi);
?>