<?php 
	include"../inc/config.php"; 
	validate_admin_not_login("login.php");
	include"inc/header.php";
?> 
	
	<div class="container text-center" style="margin-top:20px;padding:50px;">
		
		<?php
			$q = mysqli_query($conn,"select * from user WHere id='$_SESSION[iam_admin]'");
			$u = mysqli_fetch_object($q);
		?>
		<h2>Hi, <?php echo $u->nama ?></h2>
		<br>
		<br>
		<h1>Selamat Datang di Toko Sayurnih Administrator</h1>
    </div> <!-- /container -->
	
<?php include"inc/footer.php"; ?>