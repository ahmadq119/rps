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
		margin-left: 5mm;
		font-size: 12px;
	}

	div.conthead table th {
		font-size: 14px;
	}

	div.conthead table td {
		font-size: 12px;
	}
</style>

<page backtop="45mm" backbottom="10mm" backleft="5mm" backright="5mm">
	<page_header>
		<div class="conthead">
			<table width="200" border="1">
				<tr>
					<td rowspan="4" width="200" align="center" valign="middle"><img src="../../img/bppmhkp.png" width="100" height="60" align="center" /></td>
					<td rowspan="2" width="450" align="center" valign="middle">
						<h2>FORMULIR KERJA</h2>
					</td>
					<td>No. Dokumen</td>
					<td>: FK 8.9.11/OK/SKI-MM</td>
				</tr>
				<tr>
					<td width="100">Edisi/Revisi/tgl</td>
					<td width="200">: 01/04/01 Maret 2024</td>
				</tr>
				<tr>
					<td rowspan="2" align="center" valign="middle">
						<h4>REKAPITULASI KEGIATAN PREPARASI SAMPEL</h4>
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
	<?php include '../../login/config.php';
	session_start();
	?>
	<div class="judul">
		<p align="center">REKAPITULASI KEGIATAN PREPARASI SAMPEL</p>
	</div>
	<br>
	<br>
	<table width="1091" border="1">
		<thead>
			<tr>
				<th width="30">No</th>
				<th width="80">Tanggal</th>
				<th width="100">Kode Sampel</th>
				<th width="150">Jenis Sampel</th>
				<th width="80">Jumlah Sampel</th>
				<th width="80">Panjang</th>
				<th width="80">Berat</th>
				<th width="200">Target Pemeriksaan / Organ Target</th>
				<th width="120">Petugas Preparasi</th>
				<th width="50">Paraf</th>

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
		$ruang = $_SESSION['ruangid'];
		$i = 0;
		$sql = "SELECT 
    ps.idpre, 
    ps.kd_sample, 
    ps.panjang, 
    ps.berat, 
    ps.idpeg, 
    peg.nama_pegawai, 
    js.nama_sample, 
    pn.tgl_terima, 
    pn.jumlah, 
    s.satuan, 
    STUFF(
        (
            SELECT 
                '<br>' + tp.target_pengujian + ': ' + pt.organ_target + '. '
            FROM 
                penerimaan_target pt 
            INNER JOIN 
                target_pengujian tp 
                ON pt.idtarget = tp.idtarget
            WHERE 
                pt.kd_sample = ps.kd_sample
            FOR XML PATH(''), TYPE
        ).value('.', 'NVARCHAR(MAX)'), 
        1, 
        4, 
        ''
    ) AS pengujian_tergabung
FROM 
    preparasi_sample ps 
INNER JOIN 
    penerimaan_sample pn 
    ON ps.kd_sample = pn.kd_sample 
INNER JOIN 
    jenis_sample js 
    ON pn.idsample = js.idsample 
INNER JOIN 
    satuan s 
    ON js.idsatuan = s.idsatuan 
LEFT OUTER JOIN 
    pegawai peg 
    ON ps.idpeg = peg.idpeg
GROUP BY 
    ps.idpre, 
    ps.kd_sample, 
    ps.panjang, 
    ps.berat, 
    ps.idpeg, 
    peg.nama_pegawai, 
    js.nama_sample, 
    pn.tgl_terima, 
    pn.jumlah, 
    s.satuan;
";
		$query = sqlsrv_query($koneksi, $sql);
		while ($r = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
			$i++;
		?>
			<tbody>
				<tr>
					<td width="30" align="center"><?php echo $i; ?></td>
					<td width="80" align="center" height="15"><?php echo date_format($r['tgl_terima'], 'd-M-Y'); ?></td>
					<td width=" 100"><?php echo $r['kd_sample']; ?></td>
					<td width="150" align="center"><?php echo $r['nama_sample']; ?></td>
					<td width="80" align="center"><?php echo $r['jumlah']; ?> <?php echo $r['satuan']; ?></td>
					<td width="80" align="center"><?php echo $r['panjang']; ?></td>
					<td width="80" align="center"><?php echo $r['berat']; ?></td>
					<td width="200" align="left"><?php echo $r['pengujian_tergabung']; ?></td>
					<td width="120" align="center"><?php echo $r['nama_pegawai']; ?></td>
					<td width="50">&nbsp;</td>
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
				</div>
			</td>
		</tr>
	</table>
	<p>&nbsp;</p>
</page>