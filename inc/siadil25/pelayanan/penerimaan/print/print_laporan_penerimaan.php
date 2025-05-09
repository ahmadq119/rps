<style>
	table {
		border: solid 1px black;
		border-collapse: collapse
	}

	table th {
		font-size: 12px;
		text-align: center;
		height: 20px;
	}

	table td {
		font-size: 11px;
	}

	div.containeranalis {
		margin-left: 800px;
		width: 300px;
		height: 150px;
		font-size: 12px;
	}

	div.container {
		margin-left: 50px;
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
		margin-left: 55px;
		font-size: 12px;
	}

	div.conthead table th {
		font-size: 14px;
	}

	div.conthead table td {
		font-size: 12px;
	}
</style>

<page backtop="45mm" backbottom="10mm" backleft="15mm" backright="10mm">
	<page_header>
		<div class="conthead">
			<table width="200" border="1">
				<tr>
					<td rowspan="4" width="200" align="center" valign="middle"><img src="./img/bppmhkp.png" width="100" height="60" align="center" /></td>
					<td rowspan="2" width="450" align="center" valign="middle">
						<h2>FORMULIR KERJA</h2>
					</td>
					<td>No. Dokumen</td>
					<td>: FK 8.9.8/OK/SKI-MM</td>
				</tr>
				<tr>
					<td width="100">Edisi/Revisi/tgl</td>
					<td width="200">: 01/04/01 Maret 2024</td>
				</tr>
				<tr>
					<td rowspan="2" align="center" valign="middle">
						<h4>REKAPITULASI PENERIMAAN SAMPLE</h4>
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
	<?php include '../include/config.php'; ?>
	<div class="judul">
		<p align="center">REKAPITULASI PENERIMAAN SAMPLE</p>
	</div>
	<br>
	<br>
	<table width="1091" border="1">
		<thead>
			<tr>
				<th width="40">No</th>
				<th width="80">Tanggal</th>
				<th width="80">Waktu</th>
				<th width="100">Kode Sampel</th>
				<th width="150">Jenis Sampel</th>
				<th width="85">Jumlah Sampel</th>
				<th width="80">Kondisi Sampel</th>
				<th width="155">Petugas Pelayanan</th>
				<th width="85">Paraf</th>

			</tr>
		</thead>
		<?php
		$bln = $_REQUEST['bulan'];
		if ($bln == '01') {
			$bulan = 'Januari';
		} elseif ($bln == '02') {
			$bulan = 'Februari';
		} elseif ($bln == '03') {
			$bulan = 'Maret';
		} elseif ($bln == '04') {
			$bulan = 'April';
		} elseif ($bln == '05') {
			$bulan = 'Mei';
		} elseif ($bln == '06') {
			$bulan = 'Juni';
		} elseif ($bln == '07') {
			$bulan = 'Juli';
		} elseif ($bln == '08') {
			$bulan = 'Agustus';
		} elseif ($bln == '09') {
			$bulan = 'September';
		} elseif ($bln == '10') {
			$bulan = 'Oktober';
		} elseif ($bln == '11') {
			$bulan = 'November';
		} else {
			$bulan = 'Desember';
		}
		$thn = $_REQUEST['tahun'];
		$i = 0;
		$sql = sqlsrv_query($dbconnect, "select * from v_penerimaan_sample where tahun='$thn' and bulan='$bln'");
		while ($r = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
			$i++;
		?>
			<tbody>
				<tr>
					<td width="40" align="center"><?php echo $i; ?></td>
					<td width="80" align="center" height="15"><?php echo date_format($r['tgl_terima'], 'd-M-Y'); ?></td>
					<td width="80" align="center"><?php echo $r['waktu']; ?></td>
					<td width="100"><?php echo $r['kd_sample']; ?></td>
					<td width="200" align="center"><?php echo $r['nm_sample']; ?></td>
					<td width="85" align="center"><?php echo $r['jumlah']; ?> <?php echo $r['satuan']; ?></td>
					<td width="80" align="center"><?php echo $r['kondisi']; ?></td>
					<td width="155" align="center"><?php echo $r['nama']; ?></td>
					<td width="85">&nbsp;</td>
				</tr>

			</tbody>
		<?php } ?>
	</table>
	<br>
	<br>
	<table align="center">
		<tr>
			<td>
				<div class="container">
				</div>
			</td>
			<td>
				<div class="container"></div>
			</td>
			<td>
				<div class="container">
					<?php
					if ($_REQUEST['nip_mt'] == "198107272005021001") {
						echo "Merauke, ......" . $bulan . " " . $thn;
						echo '<br>';
						$nm = $_REQUEST['nm_mt'];
						echo 'Manajer Teknis';
						echo '<br>';
						echo '<img src="../img/ttd/ttdfirhan.png" width="80" />';
						echo '<br>';
						echo '<div class="subjudul">' . $nm . '</div>';
						echo "NIP. " . $_REQUEST['nip_mt'];
					} elseif ($_REQUEST['nip_mt'] == "198304072005021001") {
						echo "Merauke, ......" . $bulan . " " . $thn;
						echo '<br>';
						$nm = $_REQUEST['nm_mt'];
						echo 'Manajer Teknis';
						echo '<br>';
						echo '<img src="../img/ttd/ttdlis.png" width="80" />';
						echo '<br>';
						echo '<div class="subjudul">' . $nm . '</div>';
						echo "NIP. " . $_REQUEST['nip_mt'];
					} elseif ($_REQUEST['nip_mt'] == "197812132009121001") {
						echo "Merauke, ......" . $bulan . " " . $thn;
						echo '<br>';
						$nm = $_REQUEST['nm_mt'];
						echo 'Manajer Teknis';
						echo '<br>';
						echo '<img src="../img/ttd/fajar_f.png" width="80" />';
						echo '<br>';
						echo '<div class="subjudul">' . $nm . '</div>';
						echo "NIP. " . $_REQUEST['nip_mt'];
					} else {
						echo "Merauke, ......" . $bulan . " " . $thn;
						echo "<br>";
						$nm = $_REQUEST['nm_mt'];
						echo "Manajer Teknis,";
						echo '<br>';
						echo '<br>';
						echo '<br>';
						echo '<br>';
						echo '<br>';
						echo '<br>';
						echo '<br>';
						echo '<div class="subjudul">' . $nm . '</div>';
						echo "NIP. " . $_REQUEST['nip_mt'];
					}
					?>
				</div>
			</td>
		</tr>
	</table>
	<p>&nbsp;</p>
</page>