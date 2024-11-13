<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:form-login.php");
    exit();
}

include "koneksi.php"; // Pastikan koneksi.php menggunakan mysqli

$username = $_POST['username'];
$password = $_POST['password'];
$level = $_POST['level'];
$status = $_POST['status'];

$query = $koneksi->query("SELECT MAX(id_admin) AS id FROM tbl_admin");
$data = $query->fetch_assoc();
$nilai = $data['id'] ? $data['id'] : 0; // Jika tidak ada id, mulai dari 0
$nilai++;
$angka = substr($nilai, -3);
$id = "USR" . sprintf("%03s", $angka);

if ($status == "0") {
    // Hash password sebelum menyimpan
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $stmt = $koneksi->prepare("INSERT INTO tbl_admin (id_admin, username, password, level) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $id, $username, $hashed_password, $level);
} else {
    $kode = $_POST['kode'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash password untuk update
    $stmt = $koneksi->prepare("UPDATE tbl_admin SET username = ?, password = ?, level = ? WHERE id_admin = ?");
    $stmt->bind_param("ssss", $username, $hashed_password, $level, $kode);
}

if ($stmt->execute()) {
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=user.php">';
    exit;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$koneksi->close();
?>	