			</div><!--End of div#main-->
			<div id="foot">
				<span style="float:left;font-weight:normal;">
					<?php
						$prev=!isset($_GET['pg'])?"":$_GET['pg']; 
						$uname=!isset($_SESSION['uname'])?"":$_SESSION['uname']; 
						$status=!isset($_SESSION['status'])?"":$_SESSION['status'];
						if($uname==""){ 
							echo "<a href='.?pg=home&prev=$prev' id='a1' style='color:#da251d;text-decoration:none;' onmouseover=\"changeColor('a1')\">Home</a>&nbsp;&nbsp;&nbsp;&middot;&nbsp;&nbsp;&nbsp;<a href='.?pg=form&prev=$prev' id='a10' style='color:#da251d;text-decoration:none;' onmouseover='changeColor(\"a10\")'>New User</a>&nbsp;&nbsp;&nbsp;&middot;&nbsp;&nbsp;&nbsp;";
						} 
						else if(($status=="Admin")){ 
							echo "<a href='.?pg=createpins&prev=$prev' id='a3' style='color:#da251d;text-decoration:none;' onmouseover=\"changeColor('a3')\">Generate Pins</a>&nbsp;&nbsp;&nbsp;&middot;&nbsp;&nbsp;&nbsp;<a href='.?pg=updateAdmin&prev=$prev' id='a8' style='color:#da251d;text-decoration:none;' onmouseover=\"changeColor('a8')\">Security</a>&nbsp;&nbsp;&nbsp;&middot;&nbsp;&nbsp;&nbsp;";
						}
						else if($status=="Regular"){ 
							echo "<a href='.?pg=updateRegular&prev=$prev' id='a9' style='color:#da251d;text-decoration:none;' onmouseover=\"changeColor('a9')\">Security</a>&nbsp;&nbsp;&nbsp;&middot;&nbsp;&nbsp;&nbsp;";
						}
					?>
					<a href=".?pg=about&prev=<?php echo $prev ; ?>" id="a11" style="color:#da251d;text-decoration:none;"  onmouseover="changeColor('a11')">About</a>
				</span>
				<div style="clear:both;float:right;color:#26327F;margin-right:auto;margin-top:5px;">&copy Udebuani CHAT (IDPS)&reg; 2014.</div>
			</div>
		</div><!-- End of div#wrap -->
	</body>
</html>
