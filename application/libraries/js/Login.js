function check(elementId, email, password){
	var xmlhttp;
	var id = elementId;
	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.status==200 && xmlhttp.readyState==4){
				var resp = xmlhttp.responseText;			
			if(resp == "-1"){
				document.getElementById(id).innerHTML="kein Passwort vorhanden!";
			}
			else if(resp == "0"){
				document.getElementById(id).innerHTML="Diesen Benutzer gibt es nicht."
			}
			else if(resp == "10"){
				document.getElementById(id).innerHTML="Falsches Passwort!";
			}
			else if(resp == "11"){
				document.getElementById(id).innerHTML="Erfolgreich.";
			}
			else{
				document.getElementById(id).innerHTML="Unbekannte Antwort<br/>'"+resp+"'";
			}
		}
	}
	email = email.replace(/@/g, "%40");
	xmlhttp.open("POST", "/timf/Internal/Login/"+email, true)
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.setRequestHeader("Content-Length", password.length);
	xmlhttp.setRequestHeader("Connection", "close");
	xmlhttp.send("password="+password);
}