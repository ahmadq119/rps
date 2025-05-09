<style>
	table {
		border: solid 0px #5544DD;
		border-collapse: collapse;
		font-size: 10px;
	}

	table td {
		font-size: 10;
		height: 10px;
	}

	table th {
		height: 30px;
		padding: 0 0 0 5px;
		text-align: center;
	}

	div.judul {
		font-size: 14px;
		font-weight: bold;
	}

	div.tebal {
		font-weight: bold;
	}

	div.label {
		font-size: 10px;
		font-style: italic;
	}

	.tengah {
		text-align: center;
	}

	.ratakirikanan {
		text-align: justify;
	}

	.tulisankecil {
		font-size: 10px;
	}

	div.container {
		font-size: 12px;
	}

	div.conthead {
		font-size: 12px;
	}

	div.conthead table th {
		font-size: 14px;
	}

	div.conthead table td {
		font-size: 12px;
		text-align: left;
	}
</style>

<page backtop="35mm">
	<page_header>
		<div class="conthead">
			<table width="200" border="1">
				<tr>
					<td rowspan="4" width="100" align="center" valign="middle"><img src="../../img/bppmhkp.png" width="100" align="center" /></td>
					<td rowspan="2" width="300" align="center" valign="middle">
						<h2>FORMULIR KERJA</h2>
					</td>
					<td>No. Dokumen</td>
					<td>: FK 7.1.2/OK/SKI-MM</td>
				</tr>
				<tr>
					<td width="80">Edisi/Revisi/tgl</td>
					<td width="150">: 01/04/01 Maret 2024</td>
				</tr>
				<tr>
					<th rowspan="2" align="center" valign="middle" width="300">PERMINTAAN ALAT DAN BAHAN UJI LABORATORIUM</th>
					<td>Berlaku Efektif</td>
					<td>: 01 Maret 2024</td>
				</tr>
				<tr>
					<td>Halaman</td>
					<td>: [[page_cu]]/[[page_nb]]</td>
				</tr>
				<tr>
					<th colspan="4" align="center" valign="middle">STASIUN KARANTINA IKAN, PENGENDALIAN MUTU DAN KEAMANAN HASIL PERIKANAN MERAUKE</th>
				</tr>
			</table>
		</div>
	</page_header>
	<page_footer></page_footer>
	<?php
	include '../../login/config.php';
	?>
	<br>
	<div class="judul">
		<p align="center">BLANKO PERMINTAAN ALAT DAN BAHAN UJI LABORATORIUM</p>
	</div>
	<div class="judul">
		<p align="center">RUANG PENGUJIAN : <?php echo strtoupper($_REQUEST['ruang']); ?></p>
	</div>
	<br>
	<br>
	<p style="text-align: justify">
		Kepada :
		<br>
		Penyelia/Analis Ruang Pembuatan Bahan dan Reagensia
		<br>
		<br>
		Berdasarkan disposisi perintah pengujian yang telah dikeluarkan oleh Manajer Teknik Laboratorium, maka dalam rangka melaksanakan rangkaian kegiatan pengujian tersebut, diperlukan alat/bahan dan reagensia sebagai berikut :
	</p>
	<br>

	<?php
	$tanggal = $_REQUEST['tanggal'];
	$ruang = $_REQUEST['ruang'];
	$sql = "SELECT * FROM  view_permintaan_bahan WHERE tanggal='$tanggal' AND nama_ruang='$ruang'";
	$data = sqlsrv_query($koneksi, $sql);

	?>
	<table border="1">
		<tr>
			<th rowspan="2" width="70">Tanggal Permintaan</th>
			<th colspan="2">Permintaan Bahan</th>
			<th colspan="2">Permintaan Alat</th>
			<th rowspan="2">Petugas Pemohon</th>
		</tr>
		<tr>
			<th>Jenis Bahan</th>
			<th>Jumlah</th>
			<th>Jenis Alat</th>
			<th>Jumlah</th>
		</tr>
		<?php
		while ($r = sqlsrv_fetch_array($data, SQLSRV_FETCH_ASSOC)) {
		?>

			<tr>
				<td width="70" height="20" align="center"><?php echo date_format($r['tanggal'], 'd-m-Y'); ?></td>
				<td width="150"><?php echo $r['nama_bahan']; ?></td>
				<td width="70" align="center"><?php echo $r['jumlah_bahan']; ?></td>
				<td width="150"><?php echo $r['nama_alat']; ?></td>
				<td width="70" align="center"><?php echo $r['jumlah_alat']; ?></td>
				<td width="150" align="center"><?php echo $r['nama_pegawai']; ?></td>
			</tr>
		<?php } ?>
	</table>
	<br>

	<?php
	$tanggal = $_REQUEST['tanggal'];
	$ruang = $_REQUEST['ruang'];
	$sql = "SELECT TOP (1) * 
	FROM  view_permintaan_bahan WHERE tanggal='$tanggal' AND nama_ruang='$ruang'";
	$data1 = sqlsrv_query($koneksi, $sql);
	while ($r1 = sqlsrv_fetch_array($data1, SQLSRV_FETCH_ASSOC)) {
	?>

		<table border="0" align="center">

			<tr>
				<td width="250">
					<div class="container">
						<?php
						echo "Tanggal : ............................." . '<br>';
						echo "Diserahkan oleh :" . '<br>';
						echo "Pemohon," . '<br>';
						echo '<br>';
						echo '<br>';
						echo '<br>';
						echo '<br>';
						echo '<div class="subjudul">' . $r1['nama_pegawai'] . '</div>';
						echo "NIP. " . $r1['nip_pegawai'];
						?>
					</div>
				</td>
				<td width="30"></td>
				<td width="250">
					<div class="container">
						<?php
						echo "Tanggal : ............................." . '<br>';
						echo "Diterima oleh :" . '<br>';
						echo "Petugas Bahan," . '<br>';
						echo '<br>';
						echo '<br>';
						echo '<br>';
						echo '<br>';
						echo '<div class="subjudul">' . $r1['nama_p_bahan'] . '</div>';
						echo "NIP. " . $r1['nip_p_bahan'];
						?>
					</div>
				</td>
			</tr>
		<?php } ?>
		</table>
</page>