function loadSnippet(id, to){
	var xmlhttp;
	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.status==200 && xmlhttp.readyState==4){
			document.getElementById(to).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET", "/timf/Internal/Snippet/"+id, true)
	xmlhttp.send();
}