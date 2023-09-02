 <?php 
	include"inc/config.php";
	
	if(empty($_SESSION['iam_user'])){
		redir("index.php");
	}
	$user = mysqli_fetch_object(mysqli_query($conn,"SELECT*FROM user where id='$_SESSION[iam_user]'"));
	
	include"layout/header.php";
	
	$q = mysqli_query($conn,"select*from pesanan where user_id='$_SESSION[iam_user]'");
			$j = mysqli_num_rows($q);
?> 
		 
		<div class="col-md-9">
			<div class="row">
			<div class="col-md-12">
		 
			<h3>Profile : <?php echo $user->nama; ?></h3>
				<hr>
				<div class="col-md-6	 content-menu" style="margin-top:-20px;">
				 <table class="table table-striped">
					<tr>
						<td>Nama</td>
						<td>:</td>
						<td><?php echo $user->nama; ?></td>
					</tr>
					<tr>
						<td>Email</td>
						<td>:</td>
						<td><?php echo $user->email; ?></td>
					</tr>
					<tr>
						<td>Telephone</td>
						<td>:</td>
						<td><?php echo $user->telephone; ?></td>
					</tr>
					<tr>
						<td>Alamat</td>
						<td>:</td>
						<td><?php echo $user->alamat; ?></td>
					</tr>
					<tr>
						<td>Password</td>
						<td>:</td>
						<td>--- *** --</td>
					</tr>
					
				 </table>
				
				 
				</div>   
				<!-- <div class="col-md-12 content-menu"> -->
				<!-- <h3>Riwayaat Pemesanan </h3> -->
					<!-- <hr>
					<table class="table table-striped table-hove">  -->
			<thead> 
				<!-- <tr> 
					<th>#</th> 
					<th>Nama Pemesan</th> 
					<th>Tanggal Pesan</th> 
					<th>Tanggal Digunakan</th> 
					<th>Telephone</th> 
					<th>Alamat</th>  
				</tr>  -->
			</thead> 
			<tbody> 
		
			</tbody> 
		</table> 
					
				</div>   
				 
					
				
			</div>
			</div> 
		</div> 	
<?php include"layout/footer.php"; ?>