<?php
	include("class.php");
	$stat=!isset($_SESSION['status'])?"":$_SESSION['status'];
	$uname=!isset($_SESSION['uname'])?"":$_SESSION['uname'];
	if($stat!="Admin"||$uname==""){
		echo"<script>document.location.href='.?pg=home&msg=Invalid Access to Admin Page!'</script>";
	}
	else{
		include("top.php");
		if($_POST){
			may::update("Admin");
		}
		$prev=!isset($_GET['prev'])?"":$_GET['prev']; 
		$admin=1;
		$msg=!isset($_GET['msg'])?"":$_GET['msg'];
		echo "<span style='color:#922'>".$msg."</span><br/><br/>";
?>
	<div id="logout">
		Logged in as <?php echo $uname ; ?>&nbsp;&nbsp;&nbsp;&nbsp;<a href='?pg=logout'>Logout</a>
	</div>
	<form method="post" action="">
		<div style="height:40px;margin-bottom:30px;">
			<span style="width:150px;float:left;">
				Old Password
			</span>
			<span style="width:150px;float:left;">
				<input type="password" name="opwd" id="opwd" onblur="confPassword('Admin')" />
			</span>
		</div>
		<div style="height:40px;margin-bottom:30px;">
			<span style="width:150px;float:left;">
				New Password
			</span>
			<span style="width:150px;float:left;">
				<input type="password" name="npwd" id="npwd" />
			</span>
		</div>
		<div style="height:40px;margin-bottom:30px;">
			<span style="width:150px;float:left;">
				Re-type New Password
			</span>
			<span style="width:150px;float:left;">
				<input type="password" name="rnpwd" id="rnpwd" />
			</span>
		</div>
		<div style="height:40px;margin-bottom:30px;">
			<input type="submit" name="sbm" id="sbm" value="Update Password" />
		</div>
	</form>
	<a href=".?pg=<?php echo $prev==""?"may":$prev; ?>">Back</a>
<?php
		include("foot.php");
	}
?>