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
            <span> Rincian Data User </span>
        </div>
        <div id='main'>
            <?php
            include "koneksi.php";
            $kode = $_GET['kode'] ?? null; // Use null coalescing operator

            if (isset($kode)) {
                $stmt = $koneksi->prepare("SELECT * FROM tbl_admin WHERE id_admin = ?");
                $stmt->bind_param("s", $kode);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                if ($row) {
                    ?>
                    <table>
                        <tr>
                            <td width="180px"><b>Id. User</b></td>
                            <td width="5px">:</td>
                            <td><?php echo htmlspecialchars($row['id_admin']); ?></td>
                        </tr>
                        <tr>
                            <td><b>Username</b></td>
                            <td>:</td>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                        </tr>
                        <tr>
                            <td><b>Password</b></td>
                            <td>:</td>
                            <td>****** (hidden for security)</td> <!-- Do not display password -->
                        </tr>
                        <tr>
                            <td><b>Level</b></td>
                            <td>:</td>
                            <td><?php echo htmlspecialchars($row['level']); ?></td>
                        </tr>
                    </table>
                    <?php
                } else {
                    echo "User  not found.";
                }
                $stmt->close();
            } else {
                echo '<META HTTP-EQUI V="Refresh" Content="0; URL=user.php">'; exit;
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
            Copyright &copy; muhammadfarrelpradipta <br>
            All Rights Reserved.
        </div>
        <div class="cleaner_h30"></div>
    </div>
</div>
</body>
</html>