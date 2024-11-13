<?php
session_start();
include "koneksi.php"; // Pastikan koneksi menggunakan mysqli

$username = $_POST['username'] ?? ''; 
$password = $_POST['password'] ?? '';
$operator = $_GET['operator'] ?? '';

if ($operator == "in") {
    // Siapkan dan ikat
    $stmt = $koneksi->prepare("SELECT * FROM tbl_admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $c = $result->fetch_assoc();
        // Verifikasi password
        if (password_verify($password, $c['password'])) {
            $_SESSION['username'] = $c['username'];
            $_SESSION['level'] = $c['level'];

            if ($c['level'] == "Admin") {
                header("location:halaman-admin.php");
            } else if ($c['level'] == "Kepala Bagian Akadem") {
                header("location:halaman-akademik.php");
            } else if ($c['level'] == "Rektor") {
                header("location:halaman-rektor.php");
            }
        } else {
            header("location:form-login.php");
        }
    } else {
        header("location:form-login.php");
    }

    $stmt->close();
} else if ($operator == "out") {
    unset($_SESSION['username']);
    unset($_SESSION['level']);
    header("location:form-login.php");
}
?>