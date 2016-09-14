var piin="";
piin2="";
var prevLoad=0;
var admined=0;
var prev=""; 
var foldIndicate=0;
var foldIndicate2=0;

function valLogin(){
	var uname=document.getElementById("uname").value;
	var pwd=document.getElementById("pwd").value;
	if(uname==""&&pwd==""){
		alert("Please fill in your username and password!");
		return;
	}
	else if(uname==""&&pwd!=""){
		alert("Please fill in your username!");	
		return;
	}
	else if(uname!=""&&pwd==""){
		alert("Please fill in your password!");	
		return;
	}
}

function showLoginDiv(){
	$("document").ready(function(){
		//$("#head").fadeOut(1000);
		$(".intro").hide(1000);
		$("#loginDiv").show(1000);
	});
}

function changeColor(str){
	var elm=document.getElementById(str);
	elm.style.color="#551111";
	elm.onmouseout=function(){
		elm.style.color="#da251d";
	}
}

function validateReg(){
	var uname=document.getElementById("uname").value;
	var pwd=document.getElementById("pwd").value;
	var sname=document.getElementById("sname").value;
	var oname=document.getElementById("oname").value;
	var sex=document.getElementById("sex").options[document.getElementById("sex").selectedIndex].value;
	var pic=document.getElementById("pic").value;
	var email=document.getElementById("email").value;
	//var allocnum=document.getElementById("allocnum").value;
	var phone=document.getElementById("phone").value;
	var add=document.getElementById("add").value;
	var revUname=document.getElementById("revUname");
	var revSname=document.getElementById("revSname");
	var revOname=document.getElementById("revOname");
	var revSex=document.getElementById("revSex");
	var revPic=document.getElementById("revPic");
	var revEmail=document.getElementById("revEmail");
	var revPhone=document.getElementById("revPhone");
	var revAdd=document.getElementById("revAdd");
	if(uname==""||pwd==""||sname==""||oname==""||phone==""||add==""){
		alert(":::Please fill all Compulsory fields!");
	}
	else{
		if(window.XMLHttpRequest){
			var xhr=new XMLHttpRequest();	
		}
		else if(window.ActiveXObject){
			var xhr=new ActiveXObject("Microsoft.XMLHTTP");	
		}
		if(xhr){
			xhr.onreadystatechange=function(){
				if(xhr.readyState==4&&xhr.status==200){
					var msg=xhr.responseText;
					if(msg=="0"){
						alert(":::Username is not available!");
					}
					else if(msg=="1"){
						revUname.innerHTML=uname;
						revSname.innerHTML=sname;
						revOname.innerHTML=oname;
						revSex.innerHTML=(sex=="")?"Not Supplied":sex;
						revPic.innerHTML=(pic=="")?"Not Supplied":pic;
						revEmail.innerHTML=(email=="")?"Not Supplied":email;
						revPhone.innerHTML=phone;
						revAdd.innerHTML=add;
						$("document").ready(function(){
							$("#review").show(1300);
							$("#mainForm").slideUp(1300);
						});
					}
				}
			}
			xhr.open("GET", "checkUsername.php?uname="+uname,true);
			xhr.send(null);
		}
	}
}

function goToPinGen(){
	document.location.href='.?may=createpins&info=Welcome to the Pin generator page!';
}

function goBack(){
	var mid=document.getElementById("main");
	mid.style.display="none";
	mid.innerHTML=prev;
	$(document).ready(function(){
		$("#main").fadeIn(2000);					   
	});
}

function editPage(){
	$("document").ready(function(){
		$("#review").hide(1300);
		$("#mainForm").show(1300);
	});
}

function generatePins(){
	if(foldIndicate==0){
		$(document).ready(function(){
			$("#pinViewPage").hide(2000);
			$("#pinGenPage").slideDown(2000);					   
		});
		foldIndicate=1;
	}
	else{
		$(document).ready(function(){
			$("#pinViewPage").hide(2000);
			$("#pinGenPage").fadeIn(2000);					   
		});	
	}
}

function viewPins(){
	if(foldIndicate==0){
		$(document).ready(function(){
			$("#pinGenPage").hide(2000);
			$("#pinViewPage").slideDown(2000);					   
		});
		foldIndicate=1;
	}
	else{
		$(document).ready(function(){
			$("#pinGenPage").hide(2000);
			$("#pinViewPage").fadeIn(2000);					   
		});	
	}
}

function allPins(){
	if(foldIndicate2==0){
		$(document).ready(function(){
			$("#pinGenPage").hide(2000);
			$("#allPinPage").show(2000);
		});
		foldIndicate2=1;
	}
	else{
		$(document).ready(function(){
			$("#pinGenPage").hide(2000);
			$("#unusedPinPage").hide(2000);
			$("#usedPinPage").fadeOut(2000);	
			$("#allPinPage").slideDown(2000);
		});	
	}
}

function usedPins(){
	if(foldIndicate2==0){
		$(document).ready(function(){
			$("#pinGenPage").hide(2000);
			//$("#allPinPage").slideUp(2000);
			$("#usedPinPage").slideDown(2000);					   
		});
		foldIndicate2=1;
	}
	else{
		$(document).ready(function(){
			$("#pinGenPage").hide(2000);
			$("#allPinPage").slideUp(2000);
			$("#unusedPinPage").hide(2000);
			$("#usedPinPage").fadeIn(2000);					   
		});	
	}
}

function unusedPins(){
	if(foldIndicate2==0){
		$(document).ready(function(){
			$("#pinGenPage").hide(2000);
			$("#unusedPinPage").slideDown(2000);					   
		});
		foldIndicate2=1;
	}
	else{
		$(document).ready(function(){
			$("#pinGenPage").hide(2000);
			$("#allPinPage").slideUp(2000);
			$("#usedPinPage").hide(2000);
			$("#unusedPinPage").fadeIn(2000);					   
		});	
	}
}

function viewReg(){
	var regForm=document.getElementById("regForm");
	var secret=document.getElementById("secret").value;
	var xhr;
	if(secret==""){
		alert("Please fill in a valid pin");
	}
	else{
		if(window.XMLHttpRequest){
			xhr=new XMLHttpRequest();	
		}
		else if(window.ActiveXObject){
			xhr=new ActiveXObject("Microsoft.XMLHTTP");
		}
		if(xhr){
			xhr.onreadystatechange=function(){
				if(xhr.readyState==4&&xhr.status==200){
					var msgs=xhr.responseText;
					if(msgs=="Invalid"){
						secret="";
						piin="";
						alert(":::Your Pin is Invalid!");
					}
					else if(msgs=="Valid"){
						piin=secret;
						regForm.style.display="none";
						$(document).ready(function(){
							$("#regForm").show(1500);
							$("#phantom").hide(500);
						});
					}
					else if(msgs=="Used"){
						secret="";
						piin="";
						alert(":::Your Pin had already been used!");
					}
				}
			}
			xhr.open("GET", "pin.php?pin="+secret, true);
			xhr.send();
		}
	}
}

function crssChck(){
	var regForm=document.getElementById("regForm");
	var secret=document.getElementById("secret").value;
	if(piin!=""&&secret!=piin){
		piin="";
		$(document).ready(function(){
			$("#regForm").hide(1200);
			$("#phantom").show(2500);
		});
	}
}


/*$(function() {
	$('#textb').click(function() {
		document.newMessage.textb.value = "";
	});
	
	$('#btn').click(function(){
		var username = $('#texta').val();
		var message = $('#textb').val();
		var recipient = $('#recipient').val();
		if (message == "" || message == "Enter your message here" || recipient == "" || recipient == "--Send Chat To--") {
			return false;
		}
		
		var dataString = 'username=' + username + '&message=' + message + '&recipient=' + recipient;
		
		$.ajax({
			type: "POST",url: "send_save_chat.php",data: dataString,success: function() {
																			document.newMessage.textb.value = "";
																		}
		});
		//saveChat();
	});
});*/

$.ajaxSetup ({
	cache: false	
});
$(setInterval(function(){
	$('.refresh').load('viewChat.php'); 
	$('.refresh').attr({ scrollTop: $('.refresh').attr('scrollHeight') })
}, 3000));
/*
$(setInterval(function(){
	$('.refresh').innerHTML=viewChat(); 
	$('.refresh').attr({ scrollTop: $('.refresh').attr('scrollHeight') })
}, 3000));
*/
function saveChat(){
	var uname=document.getElementById("texta")?document.getElementById("texta").value:"";
	var recipient=document.getElementById("recipient")?document.getElementById("recipient").options[document.getElementById("recipient").selectedIndex].value:"";
	var message=document.getElementById("textb")?document.getElementById("textb").value:"";
	var xhr;
	if(uname!=""&&recipient!=""&&message!=""){
		if(window.XMLHttpRequest){
			xhr=new XMLHttpRequest();	
		}
		else if(window.ActiveXObject){
			xhr=new ActiveXObject("Microsoft.XMLHTTP");
		}
		if(xhr){
			xhr.onreadystatechange=function(){
				if(xhr.readyState==4&&xhr.status==200){
					var msg=xhr.responseText;
					$('.refresh').innerHTML=viewChat();
					$('.refresh').attr({ scrollTop: $('.refresh').attr('scrollHeight') });
					document.newMessage.textb.value = "";
				}
			}
			xhr.open("GET", "saveChat.php?uname="+uname+"&msg="+message+"&recipient="+recipient, true);
			xhr.send();
		}
	}
}

function viewChat(){
	var xhr;
	if(window.XMLHttpRequest){
		xhr=new XMLHttpRequest();	
	}
	else if(window.ActiveXObject){
		xhr=new ActiveXObject("Microsoft.XMLHTTP");
	}
	if(xhr){
		xhr.onreadystatechange=function(){
			if(xhr.readyState==4&&xhr.status==200){
				var msg=xhr.responseText;//alert(msg);
				return msg;
			}
		}
		xhr.open("GET", "viewChat.php", true);
		xhr.send();
	}
	return
}