<?php
	@session_start();
	session_destroy();
	//setcookie("usuar", "", time()- 365 * 24 * 60 * 60, "/","",0);


	header("Location: login.php");
?>
