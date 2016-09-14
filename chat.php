<?php
	include("top.php");
	include("class.php");
	$username = !isset($_SESSION['uname'])?"":$_SESSION['uname'];
	if($username==""){
		echo "<script>document.location.href='.?pg=home&msg=:::Invalid access to chat page.<br />'</script>";
	}
	else{
		$msg=!isset($_GET['msg'])?"":$_GET['msg'];
?>
		<div id='logout'>
			<a href='?pg=logout'>Logout</a>
		</div>
		<label="welcomemsg"></label>
		<label for="name">
			<div>
				<b style='color:5353ba;'><?php echo $msg; ?></b>
			</div>
		</label>
		<div class="alpha">
			<b align="center">Chats:</b>
			<input name="uname" type="hidden" id="texta" value="<?php echo $username ?>"/>
			<div class="refresh">
			</div>
			<form name="newMessage" class="newMessage" action="" >
				<div style='float:left;width:70%;clear:none;margin-right:5%;'>
					<select name="recipient" id="recipient">
							<?php 
								chat::popUsers();
							?>
					</select>
					<textarea name="textb" id="textb" title='Enter Message'></textarea>
				</div>
				<div style='float:left;width:20%;clear:none;'>
					<input name="submit" type="button" value="Post" id="btn" onclick="saveChat()" />
				</div>
			</form>
		</div>
<?php
	}
	include("foot.php");
?>