<?php
	include("class.php");
	$status=!isset($_SESSION['status'])?"":$_SESSION['status'];
	$uname=!isset($_SESSION['uname'])?"":$_SESSION['uname'];
	if($status!="Admin"){
		echo"<script>document.location.href='.?pg=home&msg=Invalid Access to Admin Page $uname!'</script>";
	}
	else{
	include("top.php");
	$prev=!isset($_GET['prev'])?"":$_GET['prev']; 
	$admin=1;
	
?>
<span style="float:right; background-color:#eef;font-size:16px;"><a href=".?pg=logout">Logout</a></span>
<div style="" class="cont2">
<div style="clear:both;">
<span style="float:none;">
	<input type="button" value="Generate Pins" onclick="generatePins()" style="margin-right:20px; width:120px" />
	<input type="button" value="View Pins" onclick="viewPins()" style="margin-right:20px; width:120px" />
</span>
</div>
	<!--h3><?php //echo $_GET['info'] ; ?></h3-->
	
<div id="pinGenPage" style="display:none">
	Welcome to the Create Pins page, please note that you can not create more than 10 pins at a time. Fill in the textbox below to indicate how many pins you want to generate, in the range of 1 to 10.
		<form name = "createpins" id = "createpins" method="post" action="">
			<input type="text" name="amount" id="amount"  />&nbsp;&nbsp;&nbsp;
			<input type="submit" value="Submit" name="submit" id="submit" />
		</form><br/><br/>
		<?php
			if($_POST){
				chat::pins_generator() ;
			}
		?>
</div>


<div id="pinViewPage" style="display:none;margin-bottom:30px;margin-top:30px;">
	Welcome to the View Pins page, to view pins, kindly select the category you wish.
	<br/>
	<input type="button" value="View All Pins" onclick="allPins()" style="margin-right:20px; width:120px" />
	<input type="button" value="View Used Pins" onclick="usedPins()" style="margin-right:20px; width:120px" />
	<input type="button" value="View Unused Pins" onclick="unusedPins()" style="margin-right:20px; width:120px" />
	<div id="allPinPage" style="display:none;margin-bottom:30px;margin-top:30px;">
		<?php chat::view_pins() ; ?>
	</div>
	<div id="usedPinPage" style="display:none;margin-bottom:30px;margin-top:30px;">
		<?php chat::list_assigned_pins() ; ?>
	</div>
	<div id="unusedPinPage" style="display:none;margin-bottom:30px;margin-top:30px;">
		<?php chat::list_unassigned_pins() ; ?>
	</div>
</div>
	<a href=".?pg=<?php echo $prev==""?"may":$prev; ?>">Back</a>
	<!--div style="height:200px;">
		&nbsp;
	</div-->
		
</div>
<?php
	include("foot.php") ;
	}
?>