<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:form-login.php");
    exit();
}

// Koneksi ke database
include "koneksi.php"; // Pastikan koneksi.php menggunakan mysqli

// Ambil kode dari URL dan sanitasi
$kode = isset($_GET['kode']) ? $_GET['kode'] : null;

if ($kode) {
    // Gunakan prepared statement untuk menghindari SQL Injection
    $stmt = $koneksi->prepare("SELECT * FROM tbl_pembobotan WHERE id_pembobotan = ?");
    $stmt->bind_param("s", $kode); // "s" menunjukkan bahwa parameter adalah string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Mengambil data sebagai array asosiatif
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
                        <img src='images/logos.png'/>
                        <div class="admin"> Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?><br>
                            <a href="#"> Lihat Website </a> | <a href="#"> Help </a> | <a href="logout.php"> Logout </a>
                        </div>
                    </div>
                </div>
            </div>
            <div id='main-wrap'>
                <div id='main-center'>
                    <div id='head-main'>
                        <span> Rincian Data Pembobotan Kriteria </span>
                    </div>
                    <div id='main'>
                        <table>
                            <tr><td width="180px"><b> Id. Pembobotan </b></td><td width="5px"> : </td>
                            <td> <?php echo htmlspecialchars($row['id_pembobotan']); ?> </td></tr>
                            <tr><td width="180px"><b> Id. Normalisasi </b></td><td width="5px"> : </td>
                            <td> <?php echo "<a href='detail-normalisasi.php?kode=".htmlspecialchars($row['id_normalisasi'])."'>".htmlspecialchars($row['id_normalisasi'])."</a>"; ?> </td></tr>
                            <tr><td width="180px"><b> Penghasilan Orang Tua </b></td><td width="5px"> : </td>
                            <td> <?php echo htmlspecialchars($row['p_penghasilan_ortu']); ?> </td></tr>
                            <tr><td width="180px"><b> Nilai IPK </b></td><td width="5px"> : </td>
                            <td> <?php echo htmlspecialchars($row['p_nilai_ipk']); ?> </td></tr>
                            <tr><td width="180px"><b> Semester </b></td><td width="5px"> : </td>
                            <td> <?php echo htmlspecialchars($row['p_semester']); ?> </td></tr>
                            <tr><td width="180px"><b> Tanggungan Orang Tua </b></td><td width="5px"> : </td>
                            <td> <?php echo htmlspecialchars($row['p_tanggungan_ortu']); ?> </td></tr>
                            <tr><td width="180px"><b> Saudara Kandung </b></td><td width="5px"> : </td>
                            <td> <?php echo htmlspecialchars($row['p_saudara_kandung']); ?> </td></tr>
                            <tr><td width="180px"><b> Hasil Pembobotan Kriteria </b></td><td width ="5px"> : </td>
                            <td> <?php echo htmlspecialchars($row['hasil_pembobotan']); ?> </td></tr>
                        </table>
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
        <?php
    } else {
        echo "Data tidak ditemukan.";
    }
    $stmt->close();
} else {
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=pembobotan-kriteria.php">'; exit;
}
$mysqli->close();