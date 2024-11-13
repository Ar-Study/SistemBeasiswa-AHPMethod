<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:form-login.php");
    exit();
}
?>
<html>
<head>
    <title> Kriteria </title>
    <meta charset='utf-8'>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel='shortcut icon' href='images/favicon.jpg'/>
    <link rel='stylesheet' type='text/css' href='css/style.css'/>
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script src="js/script.js"></script>
</head>
<body>
<div id='header-wrap'>
    <div id='header'>
        <div id='logo'>
            <img src='images/logo.png'/>
            <div class="admin"> Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?><br>
                <a href="#"> Lihat Website </a> | <a href="#"> Help </a> | <a href="logout.php"> Logout </a>
            </div>
        </div>
    </div>
</div>
<div id='menu-wrap'>
    <div id='menu-padding'>
        <div id='cssmenu'>
            <ul>
                <li><a href='halaman-admin.php'>Beranda</a></li>
                <li><a href='mahasiswa.php'>Mahasiswa</a></li>
                <li><a href='kriteria.php'>Kriteria</a></li>
                <li><a href='normalisasi.php'>Normalisasi</a></li>
                <li><a href='pembobotan-kriteria.php'>Pembobotan&nbsp;Kriteria</a></li>
                <li><a href='hasil-seleksi.php'>Hasil&nbsp;Seleksi</a></li>
                <li><a href='laporan.php'>Laporan</a></li>
                <li><a href='user.php'>Manajemen&nbsp;User </a></li>
            </ul>
        </div>
    </div>
</div>
<div id='main-wrap'>
    <div id='main-center'>
        <div id='head-main'>
            <span> Data Kriteria </span>
        </div>
        <div id='main'>
            <form action="search-kriteria.php" method="post">
                <input type="text" class="search" name="search-kriteria" placeholder="Search" required/>
                <input type="hidden" name="jenis" value="kriteria">
                <input type="submit" class="button" value="Search">
                <a href="kriteria.php" class="button"> Kembali </a>
                <a href="form-kriteria.php" class="button"> Tambah </a>
            </form>
            <br>
            <table class="bordered">
                <thead>
                <tr>
                    <th> Id. Kriteria </th>
                    <th> NIM </th>
                    <th> Penghasilan Orang Tua </th>
                    <th> IPK </th>
                    <th> Semester </th>
                    <th> Tanggungan Orang Tua </th>
                    <th> Saudara </th>
                    <th width="141px"> Aksi </th>
                </tr>
                </thead>
                <tbody>
                <?php
                include "koneksi.php"; // Pastikan koneksi.php menggunakan mysqli

                // Menggunakan mysqli_real_escape_string untuk mencegah SQL Injection
                if (isset($_POST['search-kriteria'])) {
                    $search = mysqli_real_escape_string($koneksi, $_POST['search-kriteria']);
                    $query = mysqli_query($koneksi, "SELECT * FROM tbl_kriteria WHERE nim LIKE '%$search%'");
                } else {
                    $query = mysqli_query($koneksi, "SELECT * FROM tbl_kriteria");
                }

                // Periksa apakah query berhasil
                if ($query) {
                    while ($row = mysqli_fetch_array($query)) {
                        echo "<tr> <td align=center>" . $row['id_kriteria'] . "</td>
                                   <td><a href='detail-mahasiswa.php?kode=" . $row['nim'] . "'>" . $row['nim'] . "</a></td>
                                   <td>" . number_format($row['penghasilan_ortu'], 2, ',', '.') . "</td>
                                   <td>" . number_format($row['nilai_ipk'], 2) . "</td>
                                   <td>" . $row['semester'] . "</td>
                                   <td>" . $row['tanggungan_ortu'] . "</td>
                                   <td>" . $row['saudara_kandung'] . "</td>
                                   <td align=center> 
                                        <a href='detail-kriteria.php?kode=" . $row['id_kriteria'] . "'>Detail</a> |
                                        <a href='form-kriteria.php?kode=" . $row['id_kriteria'] . "'>Ubah</a> |
                                        <a href='hapus-kriteria.php?kode=" . $row['id_kriteria'] . "'>Hapus</a>
                                   </td>
                             </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' align='center'>Tidak ada data ditemukan.</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id='footer'>
    <div id='footer-wrap'>
        <div class="cleaner_h20"></div>
        <div align="center">
            Copyright &copy; 2018 Hadi Suhada & Friends <br>
            All Rights Reserved.
        </div>
        <div class="cleaner_h30"></div>
    </div>
</div>
</body>
</html>