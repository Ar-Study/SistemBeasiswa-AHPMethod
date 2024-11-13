<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:form-login.php");
    exit();
}
?>

<html>
<head>
    <title>Laporan Hasil Seleksi</title>
    <link rel='shortcut icon' href='images/favicon.jpg'/>
</head>
<body>
    <?php
    $bln = date('m');
    $blnnama = '';

    switch ($bln) {
        case 1: $blnnama = "Januari"; break;
        case 2: $blnnama = "Februari"; break;
        case 3: $blnnama = "Maret"; break;
        case 4: $blnnama = "April"; break;
        case 5: $blnnama = "Mei"; break;
        case 6: $blnnama = "Juni"; break;
        case 7: $blnnama = "Juli"; break;
        case 8: $blnnama = "Agustus"; break;
        case 9: $blnnama = "September"; break;
        case 10: $blnnama = "Oktober"; break;
        case 11: $blnnama = "November"; break;
        case 12: $blnnama = "Desember"; break;
    }
    ?>      
    <center><h4>Laporan Data Hasil Seleksi Beasiswa <br> Bulan <?php echo $blnnama . " " . date('Y'); ?></h4></center>
    <table width="100%" border="solid" bgcolor="white" align="center">
        <tr style="font-weight:bold;" bgcolor="orange" align="center">
            <td>No.</td>
            <td>NIM</td>
            <td>Nama Lengkap</td>
            <td>Kelas</td>
            <td>Tempat Lahir</td>
            <td>Tanggal Lahir</td>
            <td>Jenis Kelamin</td>
            <td>Agama</td>
            <td>Alamat</td>
            <td>No. Telepon</td>
            <td>Hasil Pembobotan</td>
        </tr>
        <?php
        include "koneksi.php"; // Pastikan koneksi.php menggunakan mysqli

        $no_urut = 0;
        $query = mysqli_query($koneksi, "SELECT tbl_mahasiswa.nim, tbl_mahasiswa.nama_lengkap, tbl_mahasiswa.kelas, 
            tbl_mahasiswa.tempat_lahir, tbl_mahasiswa.tanggal_lahir, tbl_mahasiswa.jenis_kelamin, 
            tbl_mahasiswa.agama, tbl_mahasiswa.alamat, tbl_mahasiswa.no_telepon, 
            tbl_pembobotan.hasil_pembobotan 
            FROM tbl_mahasiswa 
            JOIN tbl_kriteria ON tbl_mahasiswa.nim = tbl_kriteria.nim 
            JOIN tbl_normalisasi ON tbl_kriteria.id_kriteria = tbl_normalisasi.id_kriteria 
            JOIN tbl_pembobotan ON tbl_normalisasi.id_normalisasi = tbl_pembobotan.id_normalisasi 
            ORDER BY hasil_pembobotan DESC");

        if ($query) {
            while ($row = mysqli_fetch_assoc($query)) {
                $no_urut++;
                echo "<tr>
                        <td align='center'>$no_urut</td>
                        <td align='center'>" . htmlspecialchars($row['nim']) . "</td>
                        <td>" . htmlspecialchars($row['nama_lengkap']) . "</td>
                        <td>" . htmlspecialchars($row['kelas']) . "</td>
                        <td>" . htmlspecialchars($row['tempat_lahir']) . "</td>
                        <td>" . htmlspecialchars($row['tanggal_lahir']) . "</td>
                        <td>" . htmlspecialchars($row['jenis_kelamin']) . "</td>
                        <td>" . htmlspecialchars($row['agama']) . "</td>
                        <td>" . htmlspecialchars($row['alamat']) . "</td>
                        <td align='center'>" . htmlspecialchars($row['no_telepon']) . "</td>
                        <td>" . htmlspecialchars($row['hasil_pembobotan']) . "</td>
                     </tr>";
            }
        } else {
            echo "<tr><td colspan='11'>Tidak ada data</td></tr>";
        }
        ?>
    </table>
    <br>
    <input type="button" style="margin-left:46%" class="button" value="Print Document" onclick="print_d()"/>
    <script>
        function print_d() {
            window.open("print -hasil-seleksi.php", "_blank");
        }
    </script>
    <br>
    <div style="margin-left:85%;">
        Dicetak Oleh, <br><br><br>
        <u><?php echo htmlspecialchars($_SESSION['username']); ?></u>
        <br>
        Dicetak Tanggal: <?php echo date('d-m-Y'); ?>
    </div>
    <br>
</body>
</html>