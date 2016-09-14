<?php
	include ("top.php");
	if($_POST){
		include("class.php");
		chat::login();
	}
	$msg=!isset($_GET['msg'])?"":$_GET['msg'];
	$bypass=!isset($_GET['bypass'])?"":$_GET['bypass'];
?>
	<div class="intro" style='<?php if($bypass==1){ echo "display:none;"; }else{ echo "display:block;";} ?>'>
		<br /><br /><br />
		<input type="button" value="Continue>>" onclick="showLoginDiv()" />
	</div>
	<div>
		<b style='color:#ba5353;'><?php echo $msg; ?></b>
	</div>
	<div id='loginDiv' style='<?php if($bypass!=1){ echo "display:none;"; }else{ echo "display:block;";} ?>'>
		<form method="post" id="logForm" action="" >
			<div> &nbsp;</div>
			<div> &nbsp;</div>
			<div>
				<span style="width:80px;float:left;"><label for="uname">Username</label></span>
				<span style="width:100px;float:left;"><input type="text" name="uname" id="uname" /></span>
			</div>
			<div> &nbsp;</div>
			<div>
				<span style="width:80px;float:left;"><label for="pwd">Password</label></span>
				<span style="width:100px;float:left;"><input type="password" name="pwd" id="pwd" /></span>
			</div>
			<div> &nbsp;</div>
			<div>
				<span style="width:80px;float:left;"><input type="submit" value="Login" onmousedown="valLogin()" /></span>
				<span style="width:100px;float:left;"><input type="reset" value="Clear" /></span>
			</div>
			<div> &nbsp;</div>
			<div> &nbsp;</div>
		</form>
	</div>
<?php
	include("foot.php");
?>