<style>
	table {
		border: solid 1px black;
		border-collapse: collapse
	}

	table th {
		font-size: 10px;
		text-align: center;
		height: 20px;
	}

	table td {
		font-size: 10px;
	}

	div.container {
		margin-left: 5mm;
		width: 300px;
		height: 100px;
		font-size: 12px;
	}

	div.judul {
		font-size: 14px;
		font-weight: bold;
	}

	div.subjudul {
		font-size: 12px;
		font-weight: bold;
		align: left;
	}

	div.tebal {
		font-size: 12px;
		font-weight: bold;
	}

	div.label {
		font-size: 9px;
	}

	div.conthead {
		font-size: 12px;
	}

	div.conthead table th {
		font-size: 14px;
	}

	div.conthead table td {
		font-size: 12px;
	}
</style>

<page backtop="35mm" backbottom="10mm" backleft="5mm" backright="5mm">
	<page_header>
		<div class="conthead">
			<table width="200" border="1" align="center">
				<tr>
					<td rowspan="4" width="200" align="center" valign="middle"><img src="../../img/bppmhkp.png" width="100" height="60" align="center" /></td>
					<td rowspan="2" width="450" align="center" valign="middle">
						<h2>FORMULIR KERJA</h2>
					</td>
					<td>No. Dokumen</td>
					<td>: FK 7.5.2/OK/SKI-MM</td>
				</tr>
				<tr>
					<td width="100">Edisi/Revisi/tgl</td>
					<td width="200">: 01/04/01 Maret 2024</td>
				</tr>
				<tr>
					<td rowspan="2" align="center" valign="middle">
						<h4>REKAMAN PERSIAPAN TEMPAT KERJA & PENANGANAN SISA KERJA</h4>
					</td>
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
	<page_footer>
	</page_footer>
	<?php include '../../login/config.php'; ?>
	<?php session_start() ?>
	<br>
	<div class="judul">
		<p align="center">REKAMAN PERSIAPAN TEMPAT KERJA & PENANGANAN SISA KERJA</p>
	</div>
	<br>
	<br>
	<table width="1091" border="1">
		<thead>
			<tr>
				<th width="60" rowspan="3">Tanggal Pelaksanaan</th>
				<th width="100" rowspan="3">Kode Sampel / Jenis Objek Kegiatan</th>
				<th width="150" rowspan="3">Uraian Kegiatan Yang Dilakukan<br>(Berdasarkan Jenis Sampel/Obyek Kegiatan)</th>
				<th colspan="4">Persiapan Tempat Kerja</th>
				<th colspan="4">Penanganan Sisa Kerja</th>
				<th width="100" rowspan="3">Petugas / Analis / Penyelia</th>
				<th width="60" rowspan="3">Paraf</th>
			</tr>
			<tr>
				<th colspan="4">Kegiatan Yang Dilakukan</th>
				<th colspan="4">Kegiatan Yang Dilakukan</th>
			</tr>
			<tr>
				<th width="80">Penyinaran UV (30 menit)</th>
				<th width="80">Desinfeksi Alkohol 80%</th>
				<th width="80">Menyiapkan Bahan</th>
				<th width="80">Menyiapkan Aalat</th>
				<th width="80">Memisahkan & Membersihkan Sisa Kerja</th>
				<th width="80">Desinfeksi Alkohol 80%</th>
				<th width="80">Membuang Sisa Kerja</th>
				<th width="80">Mengembalikan Alat & Bahan</th>

			</tr>
		</thead>
		<?php
		$thn = $_REQUEST['tahun'];
		$bln = $_REQUEST['bulan'];
		$ruang = $_SESSION['ruangid'];
		$i = 0;
		$sql = sqlsrv_query($koneksi, "SELECT * FROM view_persiapan_tempat_kerja WHERE ruangid = '$ruang' and year(tgl_kegiatan) = '$thn' and month(tgl_kegiatan)= '$bln' ORDER BY tgl_kegiatan asc");
		while ($r = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
			$i++;
		?>
			<tbody>
				<tr>
					<td align="center" height="15"><?php echo date_format($r['tgl_kegiatan'], 'd-m-Y'); ?></td>
					<td width="100" align="center"><?php echo $r['kd_sample']; ?></td>
					<td><?php echo $r['nama_kegiatan']; ?></td>
					<td align="center">
						<?php
						$uv = $r['menghidupkan_uv'];
						$hasil = ($uv == 1) ? 'V' : ' - ';
						echo $hasil;
						?>
					</td>
					<td align="center">
						<?php
						$al1 = $r['alkohol_1'];
						$hasil = ($al1 == 1) ? 'V' : ' - ';
						echo $hasil;
						?>
					</td>
					<td align="center">
						<?php
						$mb = $r['menyiapkan_bahan'];
						$hasil = ($mb == 1) ? 'V' : ' - ';
						echo $hasil;
						?>
					</td>
					<td align="center">
						<?php
						$ma = $r['menyiapkan_alat'];
						$hasil = ($ma == 1) ? 'V' : ' - ';
						echo $hasil;
						?>
					</td>
					<td align="center">
						<?php
						$ms = $r['membersihkan_sisa_bahan'];
						$hasil = ($ms == 1) ? 'V' : ' - ';
						echo $hasil;
						?>
					</td>
					<td align="center">
						<?php
						$al2 = $r['alkohol_2'];
						$hasil = ($al2 == 1) ? 'V' : ' - ';
						echo $hasil;
						?>
					</td>
					<td align="center">
						<?php
						$msb = $r['membuang_sisa_bahan'];
						$hasil = ($msb == 1) ? 'V' : ' - ';
						echo $hasil;
						?>
					</td>
					<td align="center">
						<?php
						$ka = $r['mengembalikan_alat'];
						$hasil = ($ka == 1) ? 'V' : ' - ';
						echo $hasil;
						?>
					</td>
					<td><?php echo $r['nama_pegawai']; ?></td>
					<td>&nbsp;</td>
				</tr>

			</tbody>
		<?php } ?>
	</table>
	<br>
	<br>
	<table>
		<tr>
			<td style="width: 900;">

			</td>
			<td style="width: 200;">
				Mengetahui:<br>
				Manajer Teknis,
				<?php
				$nm = $_REQUEST['nm_mt'];
				echo '<br>';
				echo '<br>';
				echo '<br>';
				echo '<br>';
				echo '<br>';
				echo $nm . '<br>';
				echo "NIP. " . $_REQUEST['nip_mt'];
				?>
			</td>
		</tr>
	</table>
</page>