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
    <title>User</title>
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
            <span>Data User</span>
        </div>
        <div id='main'>
            <form action="search-user.php" method="post">
                <input type="text" class="search" name="search-user" placeholder="Search" required/>
                <input type="hidden" name="jenis" value="user">
                <input type="submit" class="button" value="Search">
                <a href="user.php" class="button"> Kembali </a>
                <a href="form-user.php" class="button"> Tambah </a>
            </form>
            <br>
            <table class="bordered">
                <thead>
                <tr>
                    <th>Id. User</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Level</th>
                    <th width="141px">Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php
                include "koneksi.php"; // Pastikan koneksi.php menggunakan mysqli

                // Cek apakah ada pencarian
                $search = isset($_POST['search-user']) ? $_POST['search-user'] : '';
                $searchParam = "%" . $search . "%";

                // Menggunakan prepared statement untuk menghindari SQL injection
                if ($stmt = $koneksi->prepare("SELECT * FROM tbl_admin WHERE id_admin LIKE ? OR username LIKE ?")) {
                    $stmt->bind_param("ss", $searchParam, $searchParam);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td align='center'>" . htmlspecialchars($row['id_admin']) . "</td>
                                    <td>" . htmlspecialchars($row['username']) . "</td>
                                    <td>" . htmlspecialchars($row['password']) . "</td>
                                    <td>" . htmlspecialchars($row['level']) . "</td>
                                    <td align='center'>
                                        <a href='detail-user.php?kode=" . htmlspecialchars($row['id_admin']) . "'>Detail</a> |
                                        <a href='form-user.php?kode=" . htmlspecialchars($row['id_admin']) . "'>Ubah</a> |
                                        <a href='hapus-user.php?kode=" . htmlspecialchars($row['id_admin']) . "'>Hapus</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' align='center'>Tidak ada data ditemukan</td></tr>";
                    }
                    $stmt->close();
                } else {
                    // Jika tidak ada pencarian, ambil semua data
                    $query = $koneksi->query("SELECT * FROM tbl_admin");
                    while ($row = $query->fetch_assoc()) {
                        echo "<tr>
                                <td align='center'>" . htmlspecialchars($row['id_admin']) . "</td>
                                <td>" . htmlspecialchars($row['username']) . "</td>
                                <td>" . htmlspecialchars($row['password']) . "</td>
                                <td>" . htmlspecialchars($row['level']) . "</td>
                                <td align='center'>
                                    <a href='detail-user.php?kode=" . htmlspecialchars($row['id_admin']) . "'>Detail</a> |
                                    <a href='form-user.php?kode=" . htmlspecialchars($row['id_admin']) . "'>Ubah</a> |
                                    <a href='hapus-user.php?kode=" . htmlspecialchars($row['id_admin']) . "'>Hapus</a>
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
            Copyright &copy; 2018 Hadi Suhada & Friends <br>
            All Rights Reserved.
        </div>
        <div class="cleaner_h30"></div>
    </div>
</div>
</body>
</html>