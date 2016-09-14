<?php 
   include("class.php"); 
   session_destroy();
   session_start();
   include("top.php") ;
   if($_POST)
   {
      chat::reg() ;
   }
?>
<span style="margin-left:60px;color:#ff0033"><?php echo !isset($_GET['msg'])?"":$_GET['msg']; ?><br/><br/></span>
<form action ="" method = "post" class="cont" enctype="multipart/form-data">
	<div style="padding-right:auto; padding-left:auto; clear:both;text-align:center;padding-bottom:60px;position:absolute;left:35%;" >
		<div style="float:none;width:100%">
			<label for = "secret"><span style = "color : #ff0000 ">*</span>Enter your 10-digit Pin</label>&nbsp;&nbsp;
         	<input type = "password" name = "secret" id = "secret" value="" onblur="crssChck()" onkeyup="crssChck()" />
			<input type = "button" name = "vm" id = "vm" value = "Continue" onclick="viewReg()" />
    	</div>
	</div>
	<div class='lineBreak'> &nbsp; </div>
	<div class='lineBreak'> &nbsp; </div>
	<!--div id="phantom" style="height:400px;">
		&nbsp;
	</div-->
	<div style="margin-left:60px; margin-right:auto;margin-top:50px;" name="regForm" id="regForm">
		<div id="mainForm" name="mainForm" style="display:block;">
			<div style="clear:both; padding-bottom:50px;">
				<span style="float:left;width:420px">
					<label for = "sname"><span style = "color : #ff0000 ">*</span>Username</label><br/>
					<input type = "text" name = "uname" id = "uname" size="30" value="<?php echo !isset($_GET['uname'])?"":$_GET['uname'] ; ?>" />
				</span>
				<span style="float:left;width:420px">
					<label for = "oname"><span style = "color : #ff0000 ">*</span>Password</label><br/>
					<input type = "password" name = "pwd" id = "pwd" size="30" />
				</span>
			</div>
		    <div style="clear:both; padding-bottom:50px;">
				<span style="float:left;width:420px">
					<label for = "sname"><span style = "color : #ff0000 ">*</span>Surname </label><br/>
					<input type = "text" name = "sname" id = "sname" size="30" value="<?php echo !isset($_GET['sname'])?"":$_GET['sname'] ; ?>" />
				</span>
				<span style="float:left;width:420px">
					<label for = "oname"><span style = "color : #ff0000 ">*</span>Other Names </label><br/>
					<input type = "text" name = "oname" id = "oname" size="60" value="<?php echo !isset($_GET['oname'])?"":$_GET['oname'] ; ?>" />
				</span>
			</div>
	
			<div style="clear:both; padding-bottom:50px;">
				<span style="float:left;width:150px">
					<label for = "sex">Sex</label><br/>
					<select name = "sex" id = "sex">
						<option value = "">Select your sex</option>
						<option value = "Male">Male</option>
						<option value = "Female">Female</option>
					</select>
		      	</span>
				<span style="float:left;width:150px">
					<label for = "pic">Image</label><br/>
					<input type="file" name="pic" id="pic" />
		      	</span>
			</div>
	
			<div style="clear:both; padding-bottom:50px;">
				<span style="float:left;width:300px">
					<label for = "email">Email Address</label>
        			<input type = "text" name = "email" id = "email" size = "40" value="<?php echo !isset($_GET['email'])?"":$_GET['email'] ; ?>" />
				</span>
		      	<span style="float:left;width:200px">
					<label for = "phone"><span style = "color : #ff0000 ">*</span> Phone Number</label><br/>
		        	<input type = "text" name = "phone" id = "phone" size="15" value="<?php echo !isset($_GET['phone'])?"":$_GET['phone'] ; ?>" />
      			</span>
			</div>
   
			<div style="clear:both; padding-bottom:50px;">
				<span style="float:left;width:auto">
					<label for = "add"><span style = "color : #ff0000 ">*</span>Address</label><br/>
					<input type = "text" name = "add" id = "add" size="70" value="<?php echo !isset($_GET['add'])?"":$_GET['add'] ; ?>" />
    		    </span>
			</div>
 
		 	<div style="clear:both; padding-top:20px;padding-bottom:40px;">
				<span style="float:left;width:170px">
					<input type = "button" name = "next" id = "next" value = "Next" onmousedown="validateReg()" />
				</span>
				<span style="float:left;width:170px">
					<input type = "reset" name = "resets" id = "resets" value = "Reset" />
				</span>
			</div>
		</div><!--End of mainForm-->
		<div id="review">
			This is a review of your data.<br /><br />
			<div style="clear:both; padding-bottom:50px;">
				<span style="float:left;width:120px">
					<label for = "revUname"><span style = "color : #ff0000 ">*</span>Username</label>
				</span>
				<span style="float:left;width:420px" id="revUname">
					 &nbsp; 
				</span>
			</div>
		    <div style="clear:both; padding-bottom:50px;">
				<span style="float:left;width:120px">
					<label for = "revSname"><span style = "color : #ff0000 ">*</span>Surname </label>
				</span>
				<span style="float:left;width:420px" id="revSname">
					&nbsp;
				</span>
			</div>
			<div style="clear:both;padding-bottom:50px;">
				<span style="float:left;width:120px">
					<label for = "revOname"><span style = "color : #ff0000 ">*</span>Other Names </label><br/>
				</span>
				<span style="float:left;width:420px" id="revOname">
					&nbsp;
				</span>
			</div>
			<div style="clear:both; padding-bottom:50px;">
				<span style="float:left;width:120px">
					<label for = "revSex">Sex</label>
		      	</span>
				<span style="float:left;width:420px" id="revSex">
					&nbsp;
				</span>
			</div>
			
			<div style="clear:both; padding-bottom:50px;">
				<span style="float:left;width:120px">
					<label for = "revPic">Image</label>
		      	</span>
				<span style="float:left;width:420px" id="revPic">
					&nbsp;
				</span>
			</div>
	
			<div style="clear:both; padding-bottom:50px;">
				<span style="float:left;width:120px">
					<label for = "revEmail">Email Address</label>
				</span>
				<span style="float:left;width:420px" id="revEmail">
					&nbsp;
				</span>
			</div>
			<div style="clear:both;padding-bottom:50px;">
		      	<span style="float:left;width:120px">
					<label for = "revPhone"><span style = "color : #ff0000 ">*</span> Phone Number</label>
      			</span>
				<span style="float:left;width:420px" id="revPhone">
					&nbsp;
				</span>
			</div>
   
			<div style="clear:both; padding-bottom:50px;">
				<span style="float:left;width:120px">
					<label for = "revAdd"><span style = "color : #ff0000 ">*</span>Address</label>
    		    </span>
				<span style="float:left;width:420px" id="revAdd">
					&nbsp;
				</span>
			</div>
 
		 	<div style="clear:both; padding-top:40px;padding-bottom:20px;">
				<span style="float:left;width:170px">
					<input type = "submit" name = "submit" id = "submit" value = "Submit" />
				</span>
				<span style="float:left;width:170px">
					<input type = "button" name = "edit" id = "edit" value = "Edit" onclick="editPage()" />
				</span>
			</div>
		</div><!--End of review-->
	</div><!--End of regForm-->
</form>
<?php include("foot.php") ;?>