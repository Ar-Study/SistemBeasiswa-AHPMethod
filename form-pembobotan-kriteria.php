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
    <title> Pembobotan Kriteria </title>
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
            <span> Formulir Data Pembobotan Kriteria </span>
        </div>
        <div id='main'>
            <form action="simpan-pembobotan-kriteria.php" method="post">
                <?php
                include "koneksi.php"; // Pastikan koneksi.php menggunakan mysqli

                if (isset($_GET['kode'])) {
                    $kode = mysqli_real_escape_string($koneksi, $_GET['kode']);
                    $query = mysqli_query($koneksi, "SELECT * FROM tbl_pembobotan WHERE id_pembobotan = '$kode'");

                    if ($query && mysqli_num_rows($query) > 0) {
                        $row = mysqli_fetch_array($query);
                        ?>
                        <table>
                            <tr>
                                <td width="180px"><b> Id. Pembobotan </b></td>
                                <td><input type="text" class="pendek" name="kode" required 
                                value="<?php echo htmlspecialchars($kode); ?>" readonly /></td>
                            </tr>
                            <tr>
                                <td><b> Id. Normalisasi </b></td>
                                <td>
                                    <select name="id_normalisasi" required>
                                        <option value=''>Pilih Normalisasi</option>
                                        <?php
                                        $normalisasi = mysqli_query($koneksi, "SELECT * FROM tbl_normalisasi");
                                        while ($nrm = mysqli_fetch_array($normalisasi)) {
                                            if ($nrm['id_normalisasi'] == $row['id_normalisasi']) {
                                                echo "<option value='" . htmlspecialchars($nrm['id_normalisasi']) . "' selected>" . htmlspecialchars($nrm['id_normalisasi']) . "</option>";
                                            } else {
                                                echo "<option value='" . htmlspecialchars($nrm['id_normalisasi']) . "'>" . htmlspecialchars($nrm['id_normalisasi']) . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <input type="hidden" name="status" value="1"/>
                            </tr>
                            <tr>
                                <td></ td>
                                <td>
                                    <input type="submit" class="button" value="Update"/>
                                    <input type="reset" class="button" value="Cancel"/>
                                    <input type="button" class="button" value="Kembali" onclick="self.history.back()">
                                </td>
                            </tr>
                        </table>
                        <?php
                    } else {
                        echo "Data tidak ditemukan.";
                    }
                } else {
                    ?>
                    <table>
                        <tr>
                            <td><b> Id. Normalisasi </b></td>
                            <td>
                                <select name="id_normalisasi" required>
                                    <option value=''>Pilih Normalisasi</option>
                                    <?php
                                    $normalisasi = mysqli_query($koneksi, "SELECT * FROM tbl_normalisasi");
                                    while ($nrm = mysqli_fetch_array($normalisasi)) {
                                        echo "<option value='" . htmlspecialchars($nrm['id_normalisasi']) . "'>" . htmlspecialchars($nrm['id_normalisasi']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <input type="hidden" name="status" value="0"/>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="submit" class="button" value="Submit"/>
                                <input type="reset" class="button" value="Cancel"/>
                                <input type="button" class="button" value="Kembali" onclick="self.history.back()">
                            </td>
                        </tr>
                    </table>
                    <?php
                }
                ?>
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