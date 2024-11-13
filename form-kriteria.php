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
            <span> Formulir Data Kriteria </span>
        </div>
        <div id='main'>
            <form action="simpan-kriteria.php" method="post">
                <?php
                include "koneksi.php"; // Pastikan koneksi.php menggunakan mysqli

                if (isset($_GET['kode'])) {
                    $kode = mysqli_real_escape_string($koneksi, $_GET['kode']);
                    $query = mysqli_query($koneksi, "SELECT * FROM tbl_kriteria WHERE id_kriteria = '$kode'");

                    if ($query && mysqli_num_rows($query) > 0) {
                        $row = mysqli_fetch_array($query);
                        ?>
                        <table>
                            <tr>
                                <td width="180px"><b> Id. Kriteria </b></td>
                                <td><input type="text" class="pendek" name="kode" required 
                                value="<?php echo htmlspecialchars($kode); ?>" readonly /></td>
                            </tr>
                            <tr>
                                <td><b> Nama Mahasiswa </b></td>
                                <td>
                                    <select name="nim" required>
                                        <option value=''>...</option>
                                        <?php
                                        $mahasiswa = mysqli_query($koneksi, "SELECT * FROM tbl_mahasiswa");
                                        while ($mhs = mysqli_fetch_array($mahasiswa)) {
                                            $selected = ($mhs['nim'] == $row['nim']) ? "selected" : "";
                                            echo "<option value='{$mhs['nim']}' $selected>{$mhs['nama_lengkap']}</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><b> Penghasilan Orang Tua </b></td>
                                <td>
                                    <select name="penghasilan_ortu" required>
                                        <option value=''> ... </option>
                                        <option value="20"> ≤ Rp. 1. 000.000,- </option>
                                        <option value="40"> ≤ Rp. 1.500.000,- </option>
                                        <option value="60"> ≤ Rp. 3.000.000,- </option>
                                        <option value="80"> ≤ Rp. 4.500.000,- </option>
                                        <option value="100"> > Rp. 4.500.000,- </option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><b> Nilai IPK </b></td>
                                <td>
                                    <select name="nilai_ipk" required>
                                        <option value=''> ... </option>
                                        <option value="20"> ≤ 2,75 </option>
                                        <option value="40"> ≤ 3,00 </option>
                                        <option value="60"> ≤ 3,25 </option>
                                        <option value="80"> ≤ 3,50 </option>
                                        <option value="100"> > 3,50 </option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><b> Semester </b></td>
                                <td>
                                    <select name="semester" required>
                                        <option value=''> ... </option>
                                        <option value="20"> 4 (Empat) </option>
                                        <option value="40"> 5 (Lima) </option>
                                        <option value="60"> 6 (Enam) </option>
                                        <option value="80"> 7 (Tujuh) </option>
                                        <option value="100"> 8 (Delapan) </option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><b> Tanggungan Orang Tua </b></td>
                                <td>
                                    <select name="tanggungan_ortu" required>
                                        <option value=''> ... </option>
                                        <option value="20"> 1 Orang </option>
                                        <option value="40"> 2 Orang </option>
                                        <option value="60"> 3 Orang </option>
                                        <option value="80"> 4 Orang </option>
                                        <option value="100"> > 4 Orang </option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><b> Saudara Kandung </b></td>
                                <td>
                                    <select name="saudara_kandung" required>
                                        <option value=''> ... </option>
                                        <option value="20"> 1 Orang </option>
                                        <option value="40"> 2 Orang </option>
                                        <option value="60"> 3 Orang </option>
                                        <option value="80"> 4 Orang </option>
                                        <option value="100"> > 4 Orang </option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <input type="hidden" name="status" value="1"/>
                            </tr>
                            <tr>
                                <td></td>
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
                            <td><b> Nama Mahasiswa </b></td>
                            <td>
                                <select name="nim" required>
                                    <option value=''>...</option>
                                    <?php
                                    $mahasiswa = mysqli_query($koneksi, "SELECT * FROM tbl_mahasiswa");
                                    while ($mhs = mysqli_fetch_array($mahasiswa)) {
                                        echo "<option value='{$mhs['nim']}'>{$mhs['nama_lengkap']}</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><b> Penghasilan Orang Tua </b></td>
                            <td>
                                <select name="penghasilan_ortu" required>
                                    <option value=''> ... </option>
                                    <option value="20"> ≤ Rp. 1.000.000,- </option>
                                    <option value="40"> ≤ Rp. 1.500.000,- </option>
                                    <option value="60"> ≤ Rp. 3.000.000,- </option>
                                    <option value="80"> ≤ Rp. 4.500.000,- </option>
                                    <option value="100"> > Rp. 4.500.000,- </option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><b> Nilai IPK </b></td>
                            <td>
                                <select name="nilai_ipk" required>
                                    <option value=''> ... </option>
                                    <option value="20"> ≤ 2,75 </option>
                                    <option value="40"> ≤ 3,00 </option>
                                    <option value="60"> ≤ 3,25 </option>
                                    <option value="80"> ≤ 3,50 </option>
                                    <option value="100"> > 3,50 </option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><b> Semester </b></td>
                            <td>
                                <select name="semester" required>
                                    <option value=''> ... </option>
                                    <option value="20"> 4 (Empat) </option>
                                    <option value="40"> 5 (Lima) </option>
                                    <option value="60"> 6 (Enam) </option>
                                    <option value="80"> 7 (Tujuh) </option>
                                    <option value="100"> 8 (Delapan) </option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><b> Tanggungan Orang Tua </b></td>
                            <td>
                                <select name="tanggungan_ortu" required>
                                    <option value=''> ... </option>
                                    <option value="20"> 1 Orang </option>
                                    <option value="40"> 2 Orang </option>
                                    <option value="60"> 3 Orang </option>
                                    <option value="80"> 4 Orang </option>
                                    <option value="100"> > 4 Orang </option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><b> Saudara Kandung </b></td>
                            <td>
                                <select name="saudara_kandung" required>
                                    <option value=''> ... </option>
                                    <option value="20"> 1 Orang </option>
                                    <option value="40"> 2 Orang </option>
                                    <option value="60"> 3 Orang </option>
                                    <option value="80"> 4 Orang </option>
                                    <option value="100"> > 4 Orang </option>
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