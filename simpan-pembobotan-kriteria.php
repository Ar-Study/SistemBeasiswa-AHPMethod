<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:form-login.php");
    exit();
}

include "koneksi.php"; // Pastikan koneksi.php menggunakan mysqli

$normalisasi = mysqli_real_escape_string($koneksi, $_POST['id_normalisasi']);

// Mengambil data dari tabel normalisasi
$query = mysqli_query($koneksi, "SELECT n_penghasilan_ortu, n_nilai_ipk, n_semester, n_tanggungan_ortu, n_saudara_kandung FROM tbl_normalisasi WHERE id_normalisasi = '$normalisasi'") or die(mysqli_error($koneksi));

if ($data = mysqli_fetch_array($query)) {
    $n_penghasilan_ortu = $data['n_penghasilan_ortu'];
    $n_nilai_ipk = $data['n_nilai_ipk'];
    $n_semester = $data['n_semester'];
    $n_tanggungan_ortu = $data['n_tanggungan_ortu'];
    $n_saudara_kandung = $data['n_saudara_kandung'];

    // Menghitung hasil pembobotan
    $hasil_penghasilan_ortu = $n_penghasilan_ortu * 25;
    $hasil_nilai_ipk = $n_nilai_ipk * 30;
    $hasil_semester = $n_semester * 20;
    $hasil_tanggungan_ortu = $n_tanggungan_ortu * 15;
    $hasil_saudara_kandung = $n_saudara_kandung * 10;

    $hasil_pembobotan = $hasil_penghasilan_ortu + $hasil_nilai_ipk + $hasil_semester + $hasil_tanggungan_ortu + $hasil_saudara_kandung;

    $status = $_POST['status'];

    // Mengambil ID pembobotan maksimum
    $query = mysqli_query($koneksi, "SELECT max(id_pembobotan) as id FROM tbl_pembobotan");
    $data = mysqli_fetch_array($query);
    $nilai = $data['id'] ? intval(substr($data['id'], 3)) : 0; // Mengambil angka dari ID
    $nilai++;
    $id = "PBN" . sprintf("%03s", $nilai);

    if ($status == "0") {
        // Insert data baru
        $query = mysqli_query($koneksi, "INSERT INTO tbl_pembobotan (id_pembobotan, id_normalisasi, p_penghasilan_ortu, p_nilai_ipk, p_semester, p_tanggungan_ortu, p_saudara_kandung, hasil_pembobotan) 
        VALUES ('$id', '$normalisasi', '$hasil_penghasilan_ortu', '$hasil_nilai_ipk', '$hasil_semester', '$hasil_tanggungan_ortu', '$hasil_saudara_kandung', '$hasil_pembobotan')");
    } else {
        // Update data yang ada
        $kode = mysqli_real_escape_string($koneksi, $_POST['kode']);
        $query = mysqli_query($koneksi, "UPDATE tbl_pembobotan SET 
        id_normalisasi = '$normalisasi',
        p_penghasilan_ortu = '$hasil_penghasilan_ortu',
        p_nilai_ipk = '$hasil_nilai_ipk',
        p_semester = '$hasil_semester',
        p_tanggungan_ortu = '$hasil_tanggungan_ortu',
        p_saudara_kandung = '$hasil_saudara_kandung',
        hasil_pembobotan = '$hasil_pembobotan'
        WHERE id_pembobotan = '$kode'");
    }

    if ($query) {
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=pembobotan-kriteria.php">';
        exit;
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    echo "Data normalisasi tidak ditemukan.";
}
?>