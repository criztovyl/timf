function oop(arg){
	var xmlhttp;
	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.status==200 && xmlhttp.readyState==4){
			//do it!
		}
	}
	xmlhttp.open(/*POST/GET*/, /*URL*/, true);
	/*POST:
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.setRequestHeader("Content-Length", arg.length);
	xmlhttp.setRequestHeader("Connection", "close");
	xmlhttp.send("arg="+arg);*/
	xmlhttp.send();
}