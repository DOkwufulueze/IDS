<?php
session_start();
//require_once 'class.php';
require_once 'connection.php';

$username = $_POST['uname'];
$message = $_POST['message'];
$recipient = $_POST['recipient'];

$sql = "INSERT INTO messages
	(username,
	message,
	message_time,recipient)
	VALUES
	(:a,:b,:c,:d)";
$qry = $con->prepare($sql);
$date=date("Y-m-d H:i:s");
$qry->execute(array(':a'=>$username,':b'=>$message,':c'=>'now()',':d'=>$recipient));
?>