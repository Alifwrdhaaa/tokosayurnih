<?php 
	session_start();
	//mysql_connect("localhost", "root", "");
	$conn = mysqli_connect("localhost", "root", "","tokosayurniiih");
//	mysql_select_db("tokosayurnih");
	
	// settings
	$url = "http://localhost/tokosayurnih/";
	$title = "Website Toko Sayurnih";
	$no = 1;
	
	function alert($conn){
		echo "<script>alert('".$conn."');</script>";
	}
	function redir($conn){
		echo "<script>document.location='".$conn."';</script>";
	}
	function validate_admin_not_login($conn){
		if(empty($_SESSION['iam_admin'])){
			redir($conn);
		}
	}
?>