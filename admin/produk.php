<?php 
	include"../inc/config.php"; 
	validate_admin_not_login("login.php");
	
	
	if(!empty($_GET['act']) && $_GET['act'] == 'delete'){		
		$q = mysqli_query($conn,"delete from produk WHERE id='$_GET[id]'");
		if($q){ alert("Success"); redir("produk.php"); }	
	}
	if(!empty($_GET['act']) && $_GET['act'] == 'create'){
		if(!empty($_POST)){
			$gambar = md5('Y-m-d H:i:s').$_FILES['gambar']['name'];
			extract($_POST);
			$deskripsi = (!empty($_POST['deskripsi'])) ? $_POST['deskripsi'] : NULL;
			$q = mysqli_query($conn,"insert into produk Values(NULL,'$nama','$deskripsi','$gambar','$harga','$kategori_produk_id','$stok')");
			if($q){
				$upload = move_uploaded_file($_FILES['gambar']['tmp_name'], '../uploads/'.$gambar);
				if($upload){ alert("Success"); redir("produk.php"); }
			}
		}
	}
	if(!empty($_GET['act']) && $_GET['act'] == 'edit'){
		if(!empty($_POST)){ 					
			extract($_POST); 
			$deskripsi = (!empty($_POST['deskripsi'])) ? $_POST['deskripsi'] : NULL; 
		
			$q = mysqli_query($conn,"update produk SET nama='$nama',deskripsi='$deskripsi', harga='$harga', kategori_produk_id='$kategori_produk_id', stok='$stok'  where id=$_GET[id]") or die(mysqli_error());
			if($q){				
				alert("Success"); 
				redir("produk.php");
			}
		}	
	}
	if(!empty($_GET['act']) && $_GET['act'] == 'photo'){
		if(!empty($_POST)){ 
			
			$gambar = md5('Y-m-d H:i:s').$_FILES['gambar']['name'];
			extract($_POST); 		
		
			$q = mysqli_query($conn,"update produk SET gambar='$gambar' where id=$_GET[id]") or die(mysqli_error());
			if($q){
				$upload = move_uploaded_file($_FILES['gambar']['tmp_name'], '../uploads/'.$gambar);
				if($upload){ alert("Success"); redir("produk.php"); }
			}
		}
	}
	
	
	include"inc/header.php";
	
?> 
	
	<div class="container">
		<?php
			$q = mysqli_query($conn,"select * from produk");
			$j = mysqli_num_rows($q);
		?>
		<h4>Daftar Produk (<?php echo ($j>0)?$j:0; ?>)</h4>
		<a class="btn btn-sm btn-primary" href="produk.php?act=create">Tambah Data</a>
		<hr>
		<?php
			if(!empty($_GET)){
				if($_GET['act'] == 'create'){
				?>
					<div class="row col-md-6">
					<form action="" method="post" enctype="multipart/form-data">
						<label>Kategori Produk</label><br>
						<select name="kategori_produk_id" required class="form-control"> 
							<?php
								$katpro = mysqli_query($conn,"select * from kategori_produk");
								while($kp = mysqli_fetch_array($katpro)){
							?>
							<option value="<?php echo $kp['id']; ?>"><?php echo $kp['nama'] ?></option>
								<?php } ?>
						</select><br>
						<label>Nama</label><br>
						<input type="text" class="form-control" name="nama" required><br>
						<label>Deskripsi</label><br> 
						<textarea class="form-control" name="deskripsi" required></textarea><br>
						<label>Gambar</label><br>
						<input type="file" class="form-control" name="gambar" required><br>
						<label>Harga</label><br>						
						<input type="number" class="form-control" name="harga" required><br>
						<label>Stok</label><br>
						<input type="number" class="form-control" name="stok" required><br>
						<input type="submit" name="form-input" value="Simpan" class="btn btn-success">
					</form>
					</div>
					<div class="row col-md-12"><hr></div>
				<?php	
				} 
				else if($_GET['act'] == 'edit'){
					$data = mysqli_fetch_object(mysqli_query($conn,"select * from produk where id='$_GET[id]'"));
				?>
					<div class="row col-md-6">
					<form action="produk.php?act=edit&&id=<?php echo $_GET['id'] ?>" method="post" enctype="multipart/form-data">
						<label>Kategori Produk</label><br>
						<select name="kategori_produk_id" required class="form-control"> 
						<?php
								$katpro = mysqli_query($conn,"select * from kategori_produk where id='$data->kategori_produk_id'");
								$kpa = mysqli_fetch_array($katpro);
							?>
								<option value="<?php echo $kpa['id']; ?>"><?php echo $kpa['nama'] ?></option>
							<?php
								$katpro = mysqli_query($conn,"select * from kategori_produk");
								while($kp = mysqli_fetch_array($katpro)){
							?>
								<option value="<?php echo $kp['id']; ?>"><?php echo $kp['nama'] ?></option>
								<?php } ?>
						</select><br>
						<label>Nama</label><br>
						<input type="text" class="form-control" name="nama" value="<?php echo $data->nama; ?>"><br>
						<label>Deskripsi</label><br> 
						<textarea class="form-control" name="deskripsi" required><?php echo $data->deskripsi; ?></textarea><br>						
						<label>Harga</label><br>
						<input type="number" class="form-control" name="harga" required value="<?php echo $data->harga; ?>"><br>
						<label>Stok</label><br>
						<input type="number" class="form-control" name="stok" required value="<?php echo $data->stok; ?>"><br>
						<input type="submit" name="form-edit" value="Simpan" class="btn btn-success">
					</form>
					</div>
					<div class="row col-md-12"><hr></div>
				<?php	
				} 
				else if($_GET['act'] == 'photo'){
					$data = mysqli_fetch_object(mysqli_query($conn,"select * from produk where id='$_GET[id]'"));
				?>
					<div class="row col-md-6">
					<form action="produk.php?act=photo&&id=<?php echo $_GET['id'] ?>" method="post" enctype="multipart/form-data">
						<!-- <label>Kategori Produk</label><br> -->
						<!-- <select name="kategori_produk_id" required class="form-control"> -->
						<label>Gambar</label><br>
						<input type="file" class="form-control" name="gambar" required><br>										
						<input type="submit" name="form-edit" value="Simpan" class="btn btn-success">
					</form>
					</div>
					<div class="row col-md-12"><hr></div>
				<?php	
				}
			}
		?>
		
		<table class="table table-striped table-hove"> 
			<thead> 
				<tr> 
					<th>#</th> 
					<th width="70px">Gambar</th> 
					<th>Nama</th> 
					<th>harga</th> 
					<th>stok</th> 
					<th>*</th> 
				</tr> 
			</thead> 
			<tbody> 
				

			
			
		<?php while($data=mysqli_fetch_object($q)){ ?> 
				<tr> 
					<th scope="row"><?php echo $no++; ?></th> 
					<td><img src="<?php echo $url.'uploads/'.$data->gambar ?>" width="100%"></td> 
					<td><?php echo $data->nama ?></td> 
					<td><?php echo number_format($data->harga, 2, ',', '.') ?></td> 
					<td><?php echo $data->stok ?></td> 
					<td>
						<a class="btn btn-sm btn-success" href="produk.php?act=edit&&id=<?php echo $data->id ?>">Edit</a>
						<a class="btn btn-sm btn-success" href="produk.php?act=photo&&id=<?php echo $data->id ?>">Edit Photo</a>
						<a class="btn btn-sm btn-danger" href="produk.php?act=delete&&id=<?php echo $data->id ?>">Hapus</a>
					</td> 
				</tr>
		<?php } ?>
			</tbody> 
		</table> 
    </div> <!-- /container -->
	
<?php include"inc/footer.php"; ?>