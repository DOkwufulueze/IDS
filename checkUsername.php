<?php
	include("class.php");
	$uname=!isset($_GET['uname'])?"":$_GET['uname'];
	chat::checkUsername($uname);
?>