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
            <span> Rincian Data Kriteria </span>
        </div>
        <div id='main'>
            <?php
            include "koneksi.php"; // Pastikan koneksi.php menggunakan mysqli

            if (isset($_GET['kode'])) {
                $kode = mysqli_real_escape_string($koneksi, $_GET['kode']);
                
                $query = mysqli_query($koneksi, "SELECT tbl_kriteria.id_kriteria, tbl_mahasiswa.nim, tbl_mahasiswa.nama_lengkap, tbl_kriteria.penghasilan_ortu, tbl_kriteria.nilai_ipk, 
                tbl_kriteria.semester, tbl_kriteria.tanggungan_ortu, tbl_kriteria.saudara_kandung FROM tbl_kriteria 
                JOIN tbl_mahasiswa ON tbl_kriteria.nim = tbl_mahasiswa.nim WHERE id_kriteria = '$kode'");
                
                if ($query) {
                    $row = mysqli_fetch_array($query);
                    if ($row) {
                        ?>
                        <table>
                            <tr>
                                <td width="180px"><b> Id. Kriteria </b></td>
                                <td width="5px"> : </td>
                                <td> <?php echo htmlspecialchars($row['id_kriteria']); ?> </td>
                            </tr>
                            <tr>
                                <td width="180px"><b> Nama Mahasiswa </b></td>
                                <td width="5px"> : </td>
                                <td> <?php echo "<a href='detail-mahasiswa.php?kode=" . htmlspecialchars($row['nim']) . "'>" . htmlspecialchars($row['nama_lengkap']) . "</a>"; ?> </td>
                            </tr>
                            <tr>
                                <td width="180px"><b> Penghasilan Orang Tua </b></td>
                                <td width="5px"> : </td>
                                <td> <?php echo htmlspecialchars($row['penghasilan_ortu']); ?> </td>
                            </ <tr>
                                <td width="180px"><b> Nilai IPK </b></td>
                                <td width="5px"> : </td>
                                <td> <?php echo htmlspecialchars($row['nilai_ipk']); ?> </td>
                            </tr>
                            <tr>
                                <td width="180px"><b> Semester </b></td>
                                <td width="5px"> : </td>
                                <td> <?php echo htmlspecialchars($row['semester']); ?> </td>
                            </tr>
                            <tr>
                                <td width="180px"><b> Tanggungan Orang Tua </b></td>
                                <td width="5px"> : </td>
                                <td> <?php echo htmlspecialchars($row['tanggungan_ortu']); ?> </td>
                            </tr>
                            <tr>
                                <td width="180px"><b> Saudara Kandung </b></td>
                                <td width="5px"> : </td>
                                <td> <?php echo htmlspecialchars($row['saudara_kandung']); ?> </td>
                            </tr>
                        </table>
                        <?php
                    } else {
                        echo "Data tidak ditemukan.";
                    }
                } else {
                    echo "Error: " . mysqli_error($koneksi);
                }
            } else {
                echo '<META HTTP-EQUIV="Refresh" Content="0; URL=kriteria.php">'; exit;
            }
            ?>
            <br>
            <form method="post">
                <center><input type="button" class="button" value="Kembali" onclick="self.history.back()"></center>
            </form>
        </div>
    </div>
</div>
<div id='footer'>
    <div id='footer-wrap'>
        <div class="cleaner_h20"></div>
        <div align="center">
        Copyright &copy; 2024 muhammadfarrelpradipta <br>
        All Rights Reserved.
        </div>
        <div class="cleaner_h30"></div>
    </div>
</div>
</body>
</html>