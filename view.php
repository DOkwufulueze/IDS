<?php
session_start();
require_once 'connection.php';
$username=!isset($_SESSION['uname'])?"":$_SESSION['uname'];

$sql = "SELECT users.image, messages.message_time, messages.username, messages.message, messages.recipient FROM messages LEFT JOIN users ON (users.username=messages.username) where messages.username='$username' OR messages.recipient='$username' ORDER BY message_time";
$qry = $con->prepare($sql);
$qry->execute();
$fetch = $qry->fetchAll();
foreach ($fetch as $row):

	$time = date("Y-m-d",strtotime($row['message_time']));
	$now = date("Y-m-d");
	if (($row['username'] == $username) && ($time == $now)) {
		$user = '<strong style="color:green;">'.$row['username'].'</strong>'.'-->'.$row['recipient']; 
	}else{
		$user = '<strong style="color:blue;">'.$row['username'].'</strong>'; 			
	}	
	if ($time == $now) {
		$hourAndMinutes = date("h:i A", strtotime($row['message_time']));
	}else{
		$hourAndMinutes = date("Y-m-d", strtotime($row['message_time']));
	}
	echo '<p>'.$user.':<em>('.$hourAndMinutes.')</em>'.'<br/>'.' '.'<img src="Images/img2/spechbubble_sq_line.png" width="10" height="10">'.' '. $row['message']. '</p>';

endforeach; 

?>