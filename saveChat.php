<?php
	include("class.php");
	$uname = !isset($_GET['uname'])?"":$_GET['uname'];
	$msg = !isset($_GET['msg'])?"":$_GET['msg'];
	$recipient = !isset($_GET['recipient'])?"":$_GET['recipient'];
	chat::saveChat($uname,$msg,$recipient);
?>