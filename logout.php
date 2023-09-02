<?php include"inc/config.php"; ?>
<?php
	unset($_SESSION['iam_user']);
	unset($_SESSION['iam_user_email']);
	session_destroy();
	redir($url."index.php");
?>