<?php
	if (isset($_GET['error'])) {
		$error = $_GET['error'];
		include("top.php");
?>
	<div class="holder">
		<label for="errormsg">Note: </label><label for="error"><?php echo $error; ?></label>
	</div>	
	</body>
</html>
<?php
		include("foot.php");
	}
?>