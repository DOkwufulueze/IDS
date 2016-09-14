<?php
	include("class.php");
	$uname = !isset($_SESSION['uname'])?"":$_SESSION['uname'];
	chat::viewChat($uname);
?>