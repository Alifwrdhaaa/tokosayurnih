<?php
ob_start();
include "../inc/config.php";
validate_admin_not_login("login.php");
if (@$_GET['act'] != "cetak") {
	include "inc/header.php";
}
?>
<div class="container">
	<h4>Laporan Penjualan</h4>
	<?php
	if (@$_GET['act'] != "cetak") {
		// <?= $filter_hari 
	?>
		<!-- <a href="?act=cetak" class="btn btn-primary">Cetak</a> -->
		<form action="" method="post">	
		<label>Tanggal Awal</label><br>
		<div class="form-group">				
			<div class='input-group date' id='datetimepicker'>
				<input type='date' class="form-control" name="tanggal_awal" 
					value="<?php echo (!empty($_POST['tanggal_awal'])) ? $_POST['tanggal_awal'] : ''; ?>"
								required />
					<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
					</span>
			</div>
		</div>
		<label>Tanggal Akhir</label><br>
		<div class="form-group">	
			<div class='input-group date' id='datetimepicker'>
				<input type='date' class="form-control" name="tanggal_akhir" 
					value="<?php echo (!empty($_POST['tanggal_akhir'])) ? $_POST['tanggal_akhir'] : ''; ?>"
								required />
					<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
					</span>
			</div>
		</div>
			<input type="submit" name="btn_filter" class="btn btn-success">
		</form> 
	<?php
	}
	?>

	<div class="col-md-12">
		<hr />
	</div>

	<div class="row">
		<table class="table table-striped" border="1">
			<tr>
				<th>#</th>
				<th>Nama</th>
				<th>Tanggal Tempo</th>
				<th>Tanggal Pesan</th>
				<th>Total</th>
				<th>Ongkir</th>
				<th>Status</th>
			</tr>
			<tbody>
				<?php

				// $mysqli = new mysqli('localhost', 'root', '', 'db_baru');			
				$query = "Select pesanan.* from pesanan order by id desc";
				if (isset($_POST['btn_filter'])) {				
					$tanggal_awal = date('Y-m-d',strtotime($_POST['tanggal_awal']));
					$tanggal_akhir = date('Y-m-d',strtotime($_POST['tanggal_akhir']));
					$query = "select * from pesanan WHERE tanggal_digunakan BETWEEN  '$tanggal_awal' AND '$tanggal_akhir'";
				}

				$totalSemua = 0;
				$totalOngkir = 0;
				$no = 0;
				$q = mysqli_query($conn, $query) or die(mysqli_error());
				while ($data = mysqli_fetch_object($q)) {
					$totalHarga = 0;
					$no++;
					$q2 = mysqli_query($conn, "Select detail_pesanan.*, produk.harga from detail_pesanan INNER JOIN produk ON detail_pesanan.produk_id = produk.id where pesanan_id = '$data->id'") or die(mysqli_error());
					while ($d = mysqli_fetch_object($q2)) {
						$totalHarga += $d->harga * $d->qty;
					}
					$totalSemua += $totalHarga;
					$totalOngkir += $data->ongkir;
				?>
					<tr>
						<td><?php echo $no; ?></td>
						<td><?php echo $data->nama; ?></td>
						<td><?php echo $data->tanggal_digunakan; ?></td>
						<td><?php echo $data->tanggal_pesan; ?></td>
						<td><?php echo "Rp. " . number_format($totalHarga, 2, ",", "."); ?></td>
						<td><?php echo "Rp. " . number_format($data->ongkir, 2, ",", "."); ?></td>
						<td><?php echo $data->status; ?></td>
					</tr>
				<?php
				}
				?>
				<tr>
					<td colspan="4" align="right">
						<font size="3">
							<b>TOTAL</b>
						</font>
					</td>
					<td>
						<font size="3"><?php echo "Rp. " . number_format($totalSemua, 2, ",", "."); ?></font>
					</td>
					<td>
						<font size="3">
							<?php echo "Rp. " . number_format($totalOngkir, 2, ",", "."); ?>
						</font>
					</td>
					<td></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<?php
if (@$_GET['act'] == "cetak") {
	$html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
	ob_end_clean();
	include("../assets/MPDF57/mpdf.php");
	$mpdf = new mPDF();
	//Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
	$stylesheet = file_get_contents('../assets/css/style.css');
	$mpdf->WriteHTML($stylesheet, 1);
	$mpdf->WriteHTML(utf8_encode($html), 2);
	$mpdf->Output();
	exit;
} else {
	include "inc/footer.php";
}
?>