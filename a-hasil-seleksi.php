<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
	session_start();
	if(empty($_SESSION['username'])){
		header("location:form-login.php");
		exit(); // Ensure to exit after header redirection
	}
?>

<html>
<head>
	<title> Hasil Seleksi </title>
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
				<span> Data Hasil Seleksi </span>
			</div>
			<div id='main'>
				<table class="bordered">
					<thead>
						<tr>
							<th width="25px"> No. </th>
							<th> NIM </th>
							<th> Nama Lengkap </th>
							<th> Kelas </th>
							<th> Jenis Kelamin </th>
							<th> Hasil Pembobotan </th>
							<th width="70px"> Aksi </th>
						</tr>
					</thead>
					<tbody>
					<?php
						include "koneksi.php";
						$no_urut = 0;

						// Using prepared statements to prevent SQL injection
						$stmt = $koneksi->prepare("SELECT tbl_mahasiswa.nim, tbl_mahasiswa.nama_lengkap, tbl_mahasiswa.kelas, tbl_mahasiswa.jenis_kelamin, tbl_pembobotan.hasil_pembobotan FROM tbl_mahasiswa JOIN tbl_kriteria ON tbl_mahasiswa.nim = tbl_kriteria.nim JOIN tbl_normalisasi ON tbl_kriteria.id_kriteria = tbl_normalisasi.id_kriteria JOIN tbl_pembobotan ON tbl_normalisasi.id_normalisasi = tbl_pembobotan.id_normalisasi ORDER BY hasil_pembobotan DESC");
						$stmt->execute();
						$result = $stmt->get_result();

						while($row = $result->fetch_assoc()) {
							$no_urut++;
							echo "<tr> <td align=center>$no_urut</td>
									   <td>".$row['nim']."</td>
									   <td>".$row['nama_lengkap']."</td>
									   <td>".$row['kelas']."</td>
									   <td>".$row['jenis_kelamin']."</td>
									   <td>".$row['hasil_pembobotan']."</td>
									   <td align=center> 
											<a href='detail-hasil-seleksi.php?kode=".$row['nim']."'>Detail</a>
									   </td>
								 </tr>";
						}
						$stmt->close();
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