<?php
	include("class.php");
	chat::db();
	$pin=$_GET['pin'];
	$q=mysql_query("SELECT * FROM secret_numbers WHERE pins='$pin' ") or die(mysql_error());
	$n=mysql_num_rows($q);
	if($n==0){
		echo "Invalid";
	}
	else{
		while($row=mysql_fetch_array($q)){
			$stat=$row['status'];
			if($stat=="Valid"){
				echo "Valid";
			}
			else if($stat=="Used"){
				echo "Used";
			}
		}
	}
?>