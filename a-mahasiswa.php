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
    <title>Mahasiswa</title>
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
                <li><a href='halaman-akademik.php'>Beranda</a></li>
                <li><a href='a-mahasiswa.php'>Mahasiswa</a></li>
                <li><a href='a-kriteria.php'>Kriteria</a></li>
                <li><a href='a-normalisasi.php'>Normalisasi</a></li>
                <li><a href='a-pembobotan-kriteria.php'>Pembobotan&nbsp;Kriteria</a></li>
                <li><a href='a-hasil-seleksi.php'>Hasil&nbsp;Seleksi</a></li>
                <li><a href='a-laporan.php'>Laporan</a></li>
            </ul>
        </div>
    </div>
</div>
<div id='main-wrap'>
    <div id='main-center'>
        <div id='head-main'>
            <span> Data Mahasiswa </span>
        </div>
        <div id='main'>
            <form action="search-mahasiswa.php" method="post">
                <input type="text" class="search" name="search-mahasiswa" placeHolder="Search" required />
                <input type="hidden" name="jenis" value="mahasiswa">
                <input type="submit" class="button" value="Search">
                <a href="mahasiswa.php" class="button"> Kembali </a>
                <a href="form-mahasiswa.php" class="button"> Tambah </a>
            </form>
            <br>
            <table class="bordered">
                <thead>
                <tr>
                    <th width="25px"> No. </th>
                    <th> NIM </th>
                    <th> Nama Lengkap </th>
                    <th> Program Studi </th>
                    <th> Kelas </th>
                    <th> Jenis Kelamin </th>
                    <th width="141px"> Aksi </th>
                </tr>
                </thead>
                <tbody>
                <?php
                include "koneksi.php";
                $no_urut = 0;
                $search = isset($_POST['search-mahasiswa']) ? $_POST['search-mahasiswa'] : '';
                if (!empty($search)) {
                    $stmt = $koneksi->prepare("SELECT * FROM tbl_mahasiswa WHERE nim LIKE ? OR nama_lengkap LIKE ? OR program_studi LIKE ? OR kelas LIKE ? OR jenis_kelamin LIKE ?");
                    $searchParam = "%$search%";
                    $stmt->bind_param("sssss", $searchParam, $searchParam, $searchParam, $searchParam, $searchParam);
 $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        $no_urut++;
                        echo "<tr>
                                <td align='center'>$no_urut</td>
                                <td align='center'>" . htmlspecialchars($row['nim']) . "</td>
                                <td>" . htmlspecialchars($row['nama_lengkap']) . "</td>
                                <td>" . htmlspecialchars($row['program_studi']) . "</td>
                                <td>" . htmlspecialchars($row['kelas']) . "</td>
                                <td>" . htmlspecialchars($row['jenis_kelamin']) . "</td>
                                <td align='center'> 
                                    <a href='detail-mahasiswa.php?kode=" . htmlspecialchars($row['nim']) . "'>Detail</a> |
                                    <a href='form-mahasiswa.php?kode=" . htmlspecialchars($row['nim']) . "'>Ubah</a> |
                                    <a href='hapus-mahasiswa.php?kode=" . htmlspecialchars($row['nim']) . "'>Hapus</a>
                                </td>
                              </tr>";
                    }
                    $stmt->close();
                } else {
                    $query = $koneksi->query("SELECT * FROM tbl_mahasiswa");
                    while ($row = $query->fetch_assoc()) {
                        $no_urut++;
                        echo "<tr>
                                <td align='center'>$no_urut</td>
                                <td align='center'>" . htmlspecialchars($row['nim']) . "</td>
                                <td>" . htmlspecialchars($row['nama_lengkap']) . "</td>
                                <td>" . htmlspecialchars($row['program_studi']) . "</td>
                                <td>" . htmlspecialchars($row['kelas']) . "</td>
                                <td>" . htmlspecialchars($row['jenis_kelamin']) . "</td>
                                <td align='center'> 
                                    <a href='detail-mahasiswa.php?kode=" . htmlspecialchars($row['nim']) . "'>Detail</a> |
                                    <a href='form-mahasiswa.php?kode=" . htmlspecialchars($row['nim']) . "'>Ubah</a> |
                                    <a href='hapus-mahasiswa.php?kode=" . htmlspecialchars($row['nim']) . "'>Hapus</a>
                                </td>
                              </tr>";
                    }
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
        Copyright &copy; 2024 muhammadfarrelpradipta <br>
        All Rights Reserved.
        </div>
        <div class="cleaner_h30"></div>
    </div>
</div>
</body>
</html>