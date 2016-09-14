<?php
	include("class.php");
	$stat=!isset($_SESSION['status'])?"":$_SESSION['status'];
	$uname=!isset($_SESSION['uname'])?"":$_SESSION['uname'];
	if($stat!="Regular"||$uname==""){
		echo"<script>document.location.href='.?pg=home&msg=Invalid Access to Employee Page!'</script>";
	}
	else{
		include("top.php");
		if($_POST){
			may::update("Regular");
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
		<form method="post" action="">
		<div style="height:40px;margin-bottom:10px;">
			<span style="float:left;margin-right:30px;">
				<span style="width:150px;float:left;">
					Old Password
				</span>
				<span style="width:150px;float:left;">
					<input type="password" name="opwd" id="opwd" onblur="confPassword('Admin')" />
				</span>
			</span>
		</div>
		<div style="height:40px;margin-bottom:10px;">
			<span style="float:left;margin-right:30px;">
				<span style="width:150px;float:left;">
					New Password
				</span>
				<span style="width:150px;float:left;">
					<input type="password" name="npwd" id="npwd" />
				</span>
			</span>
			<span style="float:left;margin-right:30px;">
				<span style="width:150px;float:left;">
					Re-type New Password
				</span>
				<span style="width:150px;float:left;">
					<input type="password" name="rnpwd" id="rnpwd" />
				</span>
			</span>
		</div>
		<div style="height:40px;margin-bottom:10px;">
			<span style="float:left;margin-right:30px;">
				<span style="width:150px;float:left;">
					Surname
				</span>
				<span style="width:150px;float:left;">
					<input type="text" name="sname" id="sname" value="<?php if(!isset($_GET['sname'])){$_GET['sname']="";} else{echo $_GET['sname'];} ?>" />
				</span>
			</span>
			<span style="float:left;margin-right:30px;">
				<span style="width:150px;float:left;">
					Other Names
				</span>
				<span style="width:150px;float:left;">
					<input type="text" name="oname" id="oname" value="<?php if(!isset($_GET['oname'])){$_GET['oname']="";} else{echo $_GET['oname'];} ?>" />
				</span>
			</span>
		</div>
		<div style="height:40px;margin-bottom:10px;">
			<span style="float:left;margin-right:30px;">
				<span style="width:150px;float:left;">
					Phone
				</span>
				<span style="width:150px;float:left;">
					<input type="text" name="phone" id="phone" value="<?php if(!isset($_GET['phone'])){$_GET['phone']="";} else{echo $_GET['phone'];} ?>" />
				</span>
			</span>
			<span style="float:left;margin-right:30px;">
				<span style="width:150px;float:left;">
					Email
				</span>
				<span style="width:150px;float:left;">
					<input type="text" name="email" id="email" size="70" value="<?php if(!isset($_GET['email'])){$_GET['email']="";} else{echo $_GET['email'];} ?>" />
				</span>
			</span>
		</div>
		<div style="height:40px;margin-bottom:30px;">
			<input type="submit" name="sbm" id="sbm" value="Update Account" />
		</div>
	</form>
	<a href=".?pg=<?php echo $prev==""?"may":$prev; ?>">Back</a>
<?php
		include("foot.php");
	}
?>