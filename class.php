<?php
	session_start();
	class chat{
		public static function db(){
			$b="";
			@mysql_connect("localhost","root",$b) or die(mysql_error());
			@mysql_select_db("chat") or die(mysql_error());
		}		
		public static function reg(){
			chat::db();
			$uname=htmlentities($_POST['uname']);
			$pwd=(htmlentities($_POST['pwd']));
			$pwdEnc=md5($pwd);
			$sname=htmlentities($_POST['sname']);
			$oname=htmlentities($_POST['oname']);
			$name=$sname." ".$oname;
			$sex=htmlentities($_POST['sex']);
			$pic=$_FILES['pic']['name'];
			$size=$_FILES['pic']['size'];
			$type=$_FILES['pic']['type'];
			$loc=$_FILES['pic']['tmp_name'];
			$newLoc="C:/wamp/www/chat/pics/";
			$email=htmlentities($_POST['email']);
			$phone=htmlentities($_POST['phone']);
			$add=htmlentities($_POST['add']);
			$pin=htmlentities($_POST['secret']);
			if($uname!=""&&$pwd!=""&&$sname!=""&&$oname!=""&&$phone!=""&&$add!=""&&$pin!=""){
				if((!@eregi('^[0-9_\.\$a-z]+'.'@'.'([0-9a-z]+\.)+'.'([0-9a-z]){2,4}$',$email))&&($email!="")){//First if
    	      		echo "<script>document.location.href='.?pg=form&msg=:::You entered an invalid email address!<br/>&uname=$uname&sname=$sname&oname=$oname&phone=$phone&email=$email&add=$add'</script>" ;
      			}
				else{
					if(($pic!="")&&($size>50000)){
						echo "<script>document.location.href='.?pg=form&msg=:::Please use an image of size not greater than 50KB!<br/>&uname=$uname&sname=$sname&oname=$oname&phone=$phone&email=$email&add=$add'</script>" ;
					}
					else{
						if(($pic!="")&&(($type!="image/jpeg")&&($type!="image/pjpeg")&&($type!="image/gif")&&($type!="image/png"))){
							echo "<script>document.location.href='.?pg=form&msg=:::Please use an image of any of the following formats: JPEG, GIF!<br/>&uname=$uname&sname=$sname&oname=$oname&phone=$phone&email=$email&add=$add'</script>" ;
						}
						else{
							if(($pic!="")&&(move_uploaded_file($loc,$newLoc.$pic))){
								mysql_query("INSERT INTO users(username, password, pin, name, sex, email, phone, address, image) 
		               VALUES('$uname', '$pwdEnc', '$pin', '$name', '$sex', '$email', '$phone', '$add','$pic')")or die(mysql_error());
						   		mysql_query("UPDATE secret_numbers SET status='Used', user='$uname' WHERE pins='$pin'") or die(mysql_error());
								echo"<script>document.location.href='.?pg=home&msg=:::Congratulations $name. Your Registration was successfully completed.'</script>";
							}
							else{
								mysql_query("INSERT INTO users(username, password, pin, name, sex, email, phone, address, image) 
		               VALUES('$uname', '$pwdEnc', '$pin', '$name', '$sex', '$email', '$phone', '$add', '')")or die(mysql_error());
						   		mysql_query("UPDATE secret_numbers SET status='Used', user='$uname' WHERE pins='$pin'") or die(mysql_error());
								echo"<script>document.location.href='.?pg=home&msg=:::Congratulations $name. Your Registration was successfully completed.'</script>";
							}
						}
					}
				}
			}
			else{
				echo "<script>document.location.href='.?pg=form&msg=Please fill all Compulsory Fields!<br/>&name=$name&add=$add&pow=$pow&phone=$phone&email=$email'</script>";
			}
		}
		
		public static function login(){
			chat::db();
			$username = $_POST['uname'];
			$password = $_POST['pwd'];
			$sql = "SELECT * FROM users where username='$username' and password=md5('$password')";
			$qry = mysql_query($sql) or die(mysql_error());
			$num=mysql_num_rows($qry);
			if ($num > 0) 
			{
				$_SESSION['uname'] = $username;
				$_SESSION['status'] = "Regular";
				echo "<script>document.location.href='.?pg=chat&msg=Welcome $username<br />'</script>";
				exit();
			}	
			else//Not a regular user
			{
				$sql = "SELECT * FROM admin where username='$username' and password=md5('$password')";
				$qry = mysql_query($sql) or die(mysql_error());
				$num=mysql_num_rows($qry);
				if ($num > 0) 
				{
					$_SESSION['uname'] = $username;
					$_SESSION['status'] = "Admin";
					echo "<script>document.location.href='.?pg=chat&msg=Welcome Admin User $username<br />'</script>";
					exit();
				}	
				else//Not an admin user too
				{
					$error = "Invalid Username or Password.";
					echo "<script>document.location.href='.?pg=home&msg=$error&bypass=1'</script>";
					exit();
				}
			}
		}
		
		public static function checkUsername($a){
			chat::db();
			$q=mysql_query("SELECT * FROM users WHERE username='$a'")or die(mysql_error());
			$n=mysql_num_rows($q);
			if($n>0){//Username is regular
				echo "0";
			}
			else if($n==0){
				echo"1";
			}
		}
		
		public static function view_pins(){
			chat::db() ;
			//$_SESSION['status'] = "Admin" ;
			$color[] = array("#ffffff", "#ffffff") ; 
			$k=0;
			$pin=array();$status=array();$user=array();
			$query = mysql_query("SELECT * FROM secret_numbers") or die(mysql_error()) ;
			while($rows=mysql_fetch_array($query)) {
				$pin[] = $rows['pins'] ;
				$status[] = $rows['status'] ;
				$user[] = $rows['user'];
			}
			if(count($pin) == 0){
				echo"<span style='color:#45e;'><b>There are no pins generated yet.</b></span>" ;
			}
			else{
				$iik=0;
				echo"<table class='tab' border = \"0\" cellpadding = \"3\" cellspacing = \"5\"><tr><th>PIN NUMBER</th><th>STATUS</th><th>USED BY</th></tr>" ;
				while($k < count($pin)) {
					$m= $k % 2 ;
					if($iik%2==0){
						echo"<tr bgcolor='#efefef'><td>".$pin[$k]."</td><td>".$status[$k]."</td><td>".$user[$k]."</td></tr>" ;
					}
					else if($iik%2!=0){
						echo"<tr bgcolor='#ffffff'><td>".$pin[$k]."</td><td>".$status[$k]."</td><td>".$user[$k]."</td></tr>" ;
					}
					$k++ ; $iik++;
				}
				echo"</table>" ;
			}
		}
		
		public static function list_unassigned_pins(){
			chat::db() ;
			$k=0;
			$false = "Valid" ;
			$pin=array();$status=array();$user=array();
			$query = mysql_query("SELECT * FROM secret_numbers WHERE status='$false'") or die(mysql_error()) ;
			while($rows=mysql_fetch_array($query)) {
				$pin[] = $rows['pins'] ;
				$status[] = $rows['status'] ; 
			}
			if(count($pin) == 0){
				echo"<span style='color:#45e;'><b>There are no unused pins yet.</b></span>" ;
			}
			else{
				$iik=0;
				echo"<table class='tab' border = \"0\" cellpadding = \"3\" cellspacing = \"5\"><tr><th>PIN NUMBER</th><th>STATUS</th></tr>" ;
				while($k < count($pin)) {
					$m= $k % 2 ;
					if($iik%2==0){
						echo"<tr bgcolor='#efefef'><td>".$pin[$k]."</td><td>".$status[$k]."</td></tr>" ;
					}
					else{
						echo"<tr bgcolor='#ffffff'><td>".$pin[$k]."</td><td>".$status[$k]."</td></tr>" ;
					}
					$k++ ; $iik++;
				}
				echo"</table>" ;
			}
		}
		
		public static function list_assigned_pins(){
			chat::db() ;
			$k=0;
			$true = "Used" ;
			$pin=array();$status=array();$user=array();
			$query = mysql_query("SELECT * FROM secret_numbers WHERE status='$true'") or die(mysql_error()) ;
			while($rows=mysql_fetch_array($query)) {
				$pin[] = $rows['pins'] ;
				$status[] = $rows['status'] ;
				$user[] = $rows['user'] ;
			}
			if(count($pin) == 0){
				echo"<span style='color:#45e;'><b>No pin had been issued to any member of staff yet.</b></span>" ;
			}
			else{
				$iik=0;
				echo"<table class='tab' border = \"0\" cellpadding = \"3\" cellspacing = \"5\"><tr><th>PIN NUMBER</th><th>STATUS</th><th>USED BY</th></tr>" ;
				while($k < count($pin)) {
					$m= $k % 2 ;
					if($iik%2==0){
						echo"<tr bgcolor='#efefef'><td>".$pin[$k]."</td><td>".$status[$k]."</td><td>".$user[$k]."</td></tr>" ;
					}
					else if($iik%2!=0){
						echo"<tr bgcolor='#ffffff'><td>".$pin[$k]."</td><td>".$status[$k]."</td><td>".$user[$k]."</td></tr>" ;
					}
					$k++ ; $iik++;
				}
				echo"</table>" ;
			}
		}
			
		public static function pins_generator(){
			chat::db() ;
			$false = "Valid" ;
			$i=0; $k=0 ;
			$amountstr = mysql_real_escape_string($_POST['amount']) ;
			$amount = (int)mysql_real_escape_string($_POST['amount']) ;
			$pin = "" ;
			$pins=array();$pins2=array();//$status=array();$user=array();
			$alphabet = "abcdefghijklmnopqrstuvwxyz0123456789" ;
			$length = 10 ;
			if(($amount <= 10)&&($amount > 0)&& ($amountstr != "")){
			while($i<$amount){
				for($j = 0 ; $j < $length ; $j++){
					$pin.= $alphabet[mt_rand(0, (strlen($alphabet)-1))] ;
				}
				$query = mysql_query("SELECT * FROM secret_numbers WHERE pins='$pin'") or die(mysql_error()) ;
				$num = mysql_num_rows($query) ;
				if($num == 0){
					if(strlen($pin)== 10){
						mysql_query("INSERT INTO secret_numbers(pins, status, user) VALUES('$pin', '$false', 'None')") or die(mysql_error());
						$pins[] = $pin ;
						$pin = "" ;
						$i++ ; 
					}
					else if(strlen($pin) < 10){
						$pins2[] = $pin ;
						$pin = "" ;
					}
				}
			}
			echo"<span style='color:#4455ee;'><b>These are the pins just generated by the Pin Generator.</b></span><br/><br/><table class='tab' border = \"0\" cellpadding = \"3\" cellspacing = \"5\"><tr><th>PINS</th><th>STATUS</th><th>USED BY</th></tr>" ;
			$iik=0;
			while($k<$amount){
				if($iik%2==0){
					echo "<tr bgcolor='#efefef' ><td>".$pins[$k]."</td><td>Valid</td><td>None</td></tr>" ;
				}
				else{
					echo "<tr bgcolor='#ffffff' ><td>".$pins[$k]."</td><td>Valid</td><td>None</td></tr>" ;
				}
				$k++ ; $iik++;
			}
			echo"</table>" ;
			}
			
			else{
				echo"<span style='color:#4455ee;'><b>Please create not more than 10 and not less than 1 pin(s) at a time!</b></span>" ;
			}
			echo "<script>document.getElementById('pinGenPage').style.display='block'</script>";
		}
		
		public static function validPin($pin){
			chat::db();
			$q=mysql_query("SELECT * FROM secret_numbers WHERE pins='$pin'") or die("Error Occured!");
			$num=mysql_num_rows($q);
			if($num==0){
				return "Invalid";
			}
			else if($num>0){
				while($r=mysql_fetch_array($q)){
					$stat=$r['status'];
				}
				if($stat=="Valid"){
					return "OK";
				}
				else if($stat=="Used"){
					return "Used";
				}
			}
		}
		
		public static function update($strr){
			chat::db();
			$uname=!isset($_SESSION['uname'])?"":$_SESSION['uname'];
			if($strr=="Regular"){
				$sname=htmlentities($_POST['sname']);
				$oname=htmlentities($_POST['oname']);
				$phone=htmlentities($_POST['phone']);
				$email=htmlentities($_POST['email']);
				$opwd=md5(htmlentities($_POST['opwd']));
				$npwd=md5(htmlentities($_POST['npwd']));
				$rnpwd=md5(htmlentities($_POST['rnpwd']));
				if($opwd!=""||$npwd!=""||$rnpwd!=""){//User intends to change password
					if($opwd==""||$npwd==""||$rnpwd==""){
						echo"<script>document.location.href='?pg=updateRegular&msg=If you must change your password, please fill all the password fields!&oname=$oname&sname=$sname&phone=$phone&email=$email'</script>";
					}
					else{
						$q=mysql_query("SELECT * FROM users WHERE username='$uname'")or die(mysql_error());
						$n=mysql_num_rows($q);
						if($n>0){
							while($row=mysql_fetch_array($q)){
								$pwd=$row['password'];
							}
							if($pwd!=$opwd){
								echo"<script>document.location.href='?pg=updateRegular&msg=Wrong Old Password!&oname=$oname&sname=$sname&phone=$phone&email=$email'</script>";
							}
							else{
								if($npwd!=$rnpwd){
									echo"<script>document.location.href='?pg=updateRegular&msg=Your confirmation password does not match the typed password!&oname=$oname&sname=$sname&phone=$phone&email=$email'</script>";	
								}
								else{//Password fields are satisfactorily filled
									if(!@eregi('^[0-9_\.\$a-z]+'.'@'.'([0-9a-z]+\.)+'.'([0-9a-z]){2,4}$',$email)&&$email!=""){
										echo"<script>document.location.href='?pg=updateRegular&msg=Either leave the Email field blank or fill in a correct Email address!!!&oname=$oname&sname=$sname&phone=$phone'</script>";
									}
									else{
										$ovals=array($sname,$oname,$phone,$email,$npwd); 
										$ostr=array("surname","other_names","phone","email","password");
										for($i=0;$i<count($ovals);$i++){//Selecting only the fields that were filled.
											if($ovals[$i]!=""){
												$val=$ovals[$i];
												$str=$ostr[$i];
												mysql_query("UPDATE users SET ".$str."='$val' WHERE username='$uname'") or die(mysql_error());
											}
										}
										echo"<script>document.location.href='?pg=updateRegular&msg=The Update was Successful!!!'</script>";
									}
								}
							}
						}
					}
				}
				else{//all password fileds are empty
					if(!@eregi('^[0-9_\.\$a-z]+'.'@'.'([0-9a-z]+\.)+'.'([0-9a-z]){2,4}$',$email)&&$email!=""){
						echo"<script>document.location.href='?pg=updateRegular&msg=Either leave the Email field blank or fill in a correct Email address!!!&oname=$oname&sname=$sname&phone=$phone'</script>";
					}
					else{
						$ovals=array($sname,$oname,$phone,$email); 
						$ostr=array("surname","other_names","phone","email");
						for($i=0;$i<count($ovals);$i++){//Selecting only the fields that were filled.
							if($ovals[$i]!=""){
								$val=$ovals[$i];
								$str=$ostr[$i];
								mysql_query("UPDATE users SET ".$str."='$val' WHERE username='$uname'") or die(mysql_error());
							}
						}
						echo"<script>document.location.href='?pg=updateRegular&msg=The Update was Successful!!!'</script>";
					}
				}
			}
			else if($strr=="Admin"){
				$opwd=htmlentities($_POST['opwd']);
				$npwd=htmlentities($_POST['npwd']);
				$rnpwd=htmlentities($_POST['rnpwd']);
				if($opwd==""||$npwd==""||$rnpwd==""){
					echo"<script>document.location.href='?pg=updateAdmin&msg=Please fill all fields!'</script>";
				}
				else{
					$q=mysql_query("SELECT * FROM admin WHERE username='$uname'")or die(mysql_error());
					$n=mysql_num_rows($q);
					if($n>0){
						while($row=mysql_fetch_array($q)){
							$pwd=$row['password'];
						}
						if($pwd!=$opwd){
							echo"<script>document.location.href='?pg=updateAdmin&msg=Wrong Old Password!'</script>";
						}
						else{
							if($npwd!=$rnpwd){
								echo"<script>document.location.href='?pg=updateAdmin&msg=Your confirmation password does not match the typed password!'</script>";	
							}
							else{
								mysql_query("UPDATE admin SET password='$npwd' WHERE username='$uname'")or die(mysql_error());
								echo"<script>document.location.href='?pg=updateAdmin&msg=Password Successfully Changed!'</script>";	
							}
						}
					}
				}
			}
		}
		
		public static function popUsers(){
			chat::db();
			$uname=!isset($_SESSION['uname'])?"":$_SESSION['uname'];
			$sql = "SELECT * FROM users WHERE username!='$uname' ORDER BY name";
			$qry = mysql_query($sql) or die(mysql_error());
			$num=mysql_num_rows($qry);
			if ($num > 0) 
			{
				echo "<option value=''>--Chat With--</option>";
				while($rows=mysql_fetch_assoc($qry)){
					$name = $rows['username'];
					$fullName = $rows['name'];
					echo "<option title='$uname'>$fullName"."[".$name."]</option>";
				}
			}	
			else{
				echo "<option value=''>No User to chat with for now</option>";
			}
		}
		
		public static function saveChat($username,$message,$recipient){
			chat::db();
			$date=date("Y-m-d H:i:s");
			$message=mysql_real_escape_string($message);
			$sql = "INSERT INTO messages(username,message,message_time,recipient)VALUES('$username','$message','$date','$recipient')";
			mysql_query($sql) or die(mysql_error());
		}
		
		public static function viewChat($username){
			chat::db();
			$sql = "SELECT users.image, messages.message_time, messages.username, messages.message, messages.recipient FROM messages LEFT JOIN users ON (users.username=messages.username) where messages.username='$username' OR messages.recipient LIKE '%[$username]%' ORDER BY message_time";
			$qry = mysql_query($sql) or die(mysql_error());
			$num=mysql_num_rows($qry);
			if ($num > 0) 
			{
				while($row=mysql_fetch_assoc($qry)){
					$time = date("Y-m-d",strtotime($row['message_time']));
					$now = date("Y-m-d");
					$pic = $row['image'];
					if (($row['username'] == $username) && ($time == $now)) {
						$user = '<strong style="color:green;">'.$row['username'].'</strong>'.' >> '.$row['recipient']; 
					}
					else{
						$user = '<strong style="color:blue;">'.$row['username'].'</strong>'; 			
					}	
					if ($time == $now) {
						$hourAndMinutes = date("h:i A", strtotime($row['message_time']));
					}
					else{
						$hourAndMinutes = date("Y-m-d", strtotime($row['message_time']));
					}
					echo '<p>'.$user.':<em>('.$hourAndMinutes.')</em>'.'<br />'.' '."<img src='pics/$pic' width='30' height='30' />".' '. $row['message']. '</p>';
				}
			}
			else{
				echo "No chat of yours for now</option>";
			}
		}
		
		public static function logout(){
			$uname = !isset($_SESSION['uname'])?"":$_SESSION['uname'];
			$uname=urlencode("<b>".$uname."</b>");
			$status = !isset($_SESSION['status'])?"":$_SESSION['status'];
			session_destroy();
			echo"<script>document.location.href='.?&msg=$uname Logged Out!'</script>";
		}
	}
?>