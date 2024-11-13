<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:form-login.php");
    exit();
}

include "koneksi.php"; // Pastikan koneksi.php menggunakan mysqli

$kriteria = mysqli_real_escape_string($koneksi, $_POST['id_kriteria']);
$status = $_POST['status'];

// Mendapatkan nilai minimum penghasilan orang tua
$query = mysqli_query($koneksi, "SELECT MIN(penghasilan_ortu) AS minimal FROM tbl_kriteria") or die(mysqli_error($koneksi));
$data = mysqli_fetch_array($query);
$n_penghasilan_ortu = $data['minimal'];

// Mendapatkan penghasilan orang tua berdasarkan id_kriteria
$query = mysqli_query($koneksi, "SELECT penghasilan_ortu FROM tbl_kriteria WHERE id_kriteria = '$kriteria'") or die(mysqli_error($koneksi));
$data = mysqli_fetch_array($query);
$penghasilan_ortu = $data['penghasilan_ortu'];

$hasil_penghasilan_ortu = $n_penghasilan_ortu / $penghasilan_ortu;

// Mendapatkan nilai maksimum IPK
$query = mysqli_query($koneksi, "SELECT MAX(nilai_ipk) AS maksimal FROM tbl_kriteria") or die(mysqli_error($koneksi));
$data = mysqli_fetch_array($query);
$n_nilai_ipk = $data['maksimal'];

// Mendapatkan nilai IPK berdasarkan id_kriteria
$query = mysqli_query($koneksi, "SELECT nilai_ipk FROM tbl_kriteria WHERE id_kriteria = '$kriteria'") or die(mysqli_error($koneksi));
$data = mysqli_fetch_array($query);
$nilai_ipk = $data['nilai_ipk'];

$hasil_nilai_ipk = $nilai_ipk / $n_nilai_ipk;

// Mendapatkan nilai maksimum semester
$query = mysqli_query($koneksi, "SELECT MAX(semester) AS maksimal FROM tbl_kriteria") or die(mysqli_error($koneksi));
$data = mysqli_fetch_array($query);
$n_semester = $data['maksimal'];

// Mendapatkan semester berdasarkan id_kriteria
$query = mysqli_query($koneksi, "SELECT semester FROM tbl_kriteria WHERE id_kriteria = '$kriteria'") or die(mysqli_error($koneksi));
$data = mysqli_fetch_array($query);
$semester = $data['semester'];

$hasil_semester = $semester / $n_semester;

// Mendapatkan nilai maksimum tanggungan orang tua
$query = mysqli_query($koneksi, "SELECT MAX(tanggungan_ortu) AS maksimal FROM tbl_kriteria") or die(mysqli_error($koneksi));
$data = mysqli_fetch_array($query);
$n_tanggungan_ortu = $data['maksimal'];

// Mendapatkan tanggungan orang tua berdasarkan id_kriteria
$query = mysqli_query($koneksi, "SELECT tanggungan_ortu FROM tbl_kriteria WHERE id_kriteria = '$kriteria'") or die(mysqli_error($koneksi));
$data = mysqli_fetch_array($query);
$tanggungan_ortu = $data['tanggungan_ortu'];

$hasil_tanggungan_ortu = $tanggungan_ortu / $n_tanggungan_ortu;

// Mendapatkan nilai maksimum saudara kandung
$query = mysqli_query($koneksi, "SELECT MAX(saudara_kandung) AS maksimal FROM tbl_kriteria") or die(mysqli_error($koneksi));
$data = mysqli_fetch_array($query);
$n_saudara_kandung = $data['maksimal'];

// Mendapatkan saudara kandung berdasarkan id_kriteria
$query = mysqli_query($koneksi, "SELECT saudara_kandung FROM tbl_kriteria WHERE id_kriteria = '$kriteria'") or die(mysqli_error($koneksi));
$data = mysqli_fetch_array($query);
$saudara_kandung = $data['saudara_kandung'];

$hasil_saudara_kandung = $saudara_kandung / $n_saudara_kandung;

// Mendapatkan id_normalisasi berikutnya
$query = mysqli_query($koneksi, "SELECT MAX(id_normalisasi) AS id FROM tbl_normalisasi") or die(mysqli_error($koneksi));
$data = mysqli_fetch_array($query);
$nilai = $data['id'];

// Menangani ID Normalisasi
if ($nilai) {
    $angka = substr($nilai, -3);
    $id = "NRM" . sprintf("%03s", $angka + 1);
} else {
    $id = "NRM001"; // Jika tidak ada ID sebelumnya
}

if ($status == "0") {
    // Insert baru
    $query = mysqli_query($koneksi, " INSERT INTO tbl_normalisasi (id_normalisasi, id_kriteria, n_penghasilan_ortu, n_nilai_ipk, n_semester, n_tanggungan_ortu, n_saudara_kandung) 
    VALUES ('$id', '$kriteria', '$hasil_penghasilan_ortu', '$hasil_nilai_ipk', '$hasil_semester', '$hasil_tanggungan_ortu', '$hasil_saudara_kandung')");
} else {
    // Update yang sudah ada
    $kode = mysqli_real_escape_string($koneksi, $_POST['kode']);
    $query = mysqli_query($koneksi, "UPDATE tbl_normalisasi SET 
    id_kriteria = '$kriteria',
    n_penghasilan_ortu = '$hasil_penghasilan_ortu',
    n_nilai_ipk = '$hasil_nilai_ipk',
    n_semester = '$hasil_semester',
    n_tanggungan_ortu = '$hasil_tanggungan_ortu',
    n_saudara_kandung = '$hasil_saudara_kandung'
    WHERE id_normalisasi = '$kode'");
}

// Cek hasil query
if ($query) {
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=normalisasi.php">';
    exit;
} else {
    echo "Error: " . mysqli_error($koneksi);
}
?>