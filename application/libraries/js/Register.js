function register(email, password, first, last, to){
	var xmlhttp;
	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.status==200 && xmlhttp.readyState==4){
			document.getElementById(to).innerHTML=xmlhttp.responseText;
		}
		if(xmlhttp.status==500 && xmlhttp.readyState==4){
			document.getElementById(to).innerHTML=xmlhttp.responseText;
		}
	}
	var args="email="+email+"&password="+password;
	if(first != ""){
		args= args+"&first="+first;
	}
	if(last != ""){
		args= args+"&last"+last;
	}
	xmlhttp.open("POST", "/timf/Internal/Register", true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.setRequestHeader("Content-Length", args.length);
	xmlhttp.setRequestHeader("Connection", "close");
	xmlhttp.send(args);
}
function check(email, password, password2, first, last, to){
	if(email != ""){
		if(password != ""){
			if(password == password2){
				register(email, password, first, last, to);
			}
			else{
				document.getElementById(to).innerHTML="Passwörter stimmen nicht überein!";
			}
		}
		else{
			document.getElementById(to).innerHTML="Kein Passwort eingegeben!";
		}
	}
	else{
		document.getElementById(to).innerHTML="eMail wird benötig!";
	}
}