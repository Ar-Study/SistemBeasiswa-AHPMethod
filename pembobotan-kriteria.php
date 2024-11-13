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
    <title>Pembobotan Kriteria</title>
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
            <span>Data Pembobotan Kriteria</span>
        </div>
        <div id='main'>
            <form action="search-pembobotan.php" method="post">
                <input type="text" class="search" name="search-pembobotan" placeholder="Search" required/>
                <input type="hidden" name="jenis" value="pembobotan">
                <input type="submit" class="button" value="Search">
                <a href="pembobotan-kriteria.php" class="button"> Kembali </a>
                <a href="form-pembobotan-kriteria.php" class="button"> Tambah </a>
            </form>
            <br>
            <table class="bordered">
                <thead>
                <tr>
                    <th>Id. Pembobotan</th>
                    <th>Id. Normalisasi</th>
                    <th>Penghasilan Orang Tua</th>
                    <th>IPK</th>
                    <th>Semester</th>
                    <th>Tanggungan Orang Tua</th>
                    <th>Saudara</th>
                    <th width="141px">Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php
                include "koneksi.php"; // Pastikan koneksi.php menggunakan mysqli

                // Cek apakah ada pencarian
                $search = isset($_POST['search-pembobotan']) ? $_POST['search-pembobotan'] : '';
                $searchParam = "%" . $search . "%";

                // Menggunakan prepared statement untuk menghindari SQL injection
                $stmt = $koneksi->prepare("SELECT * FROM tbl_pembobotan WHERE id_normalisasi LIKE ?");
                $stmt->bind_param("s", $searchParam);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td align=center>" . htmlspecialchars($row ['id_pembobotan']) . "</td>
                                <td><a href='detail-normalisasi.php?kode=" . htmlspecialchars($row['id_normalisasi']) . "'>" . htmlspecialchars($row['id_normalisasi']) . "</a></td>
                                <td>" . htmlspecialchars($row['p_penghasilan_ortu']) . "</td>
                                <td>" . htmlspecialchars($row['p_nilai_ipk']) . "</td>
                                <td>" . htmlspecialchars($row['p_semester']) . "</td>
                                <td>" . htmlspecialchars($row['p_tanggungan_ortu']) . "</td>
                                <td>" . htmlspecialchars($row['p_saudara_kandung']) . "</td>
                                <td align=center>
                                    <a href='detail-pembobotan-kriteria.php?kode=" . htmlspecialchars($row['id_pembobotan']) . "'>Detail</a> |
                                    <a href='form-pembobotan-kriteria.php?kode=" . htmlspecialchars($row['id_pembobotan']) . "'>Ubah</a> |
                                    <a href='hapus-pembobotan-kriteria.php?kode=" . htmlspecialchars($row['id_pembobotan']) . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus?\")'>Hapus</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>Tidak ada data</td></tr>";
                }
                $stmt->close();
                $koneksi->close();
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
            Copyright &copy; 2023 Hadi Suhada & Friends <br>
            All Rights Reserved.
        </div>
        <div class="cleaner_h30"></div>
    </div>
</div>
</body>
</html>