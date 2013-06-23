function baseurl(str = '') {
	base = "https://joinout.de/tests/timf/";	
	if(str.substr(0, 1) == '/'){
		return base + str.substr(1, str.length);
	}
	else {
		return base + str;	
	}
}
function toggle(id) {
	$(id).slideToggle(900);
}
function getChecked(list) {
	for(var i = 0; i < list.length; i++){
		if (list[i].checked) {
			return list[i];	
		}
	}
}
function sleep(ms, func) {
	setTimeout(func(), ms);
}