<?php include"../inc/config.php"; ?>
<?php
	$_SESSION['iam_admin']='';

    unset($_SESSION['iam_admin']);
    
    session_unset();
    session_destroy();
    redir($url."index.php");
?>