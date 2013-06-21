function login(user, password, failure) {
	$(failure).html('');
	if (user != '' && password != '') {
		user = user.replace('@', '%40');
		var auth = SHA1(password);
		$.ajax({
			url: baseurl() + "timf/login/" + user,
			data: {'auth': auth};
			success: function (response) {
				if(response == "true"){
					window.location = baseurl() + "timf/view/profile";
				}
				else{
					$(failure).html(response);
				}
			},
			failure:  function () {
				$(failure).html('AJAX Request Failed.');
			}
		});	
	}
	else {
		if(user == ''){
			$(failure).html('Username is emtpy!');
		}
		else{
			$(failure).html('No Password entered!');
		}
	}
}
function logout(failure) {
	$.ajax{
		url: baseurl() + "timf/logout",
		success: function () {
			window.location = baseurl();
		},
		failure: function () {
			$(failure).html('AJAX Request Failed.');
		}
	}
}