function init(){
	$.ajax({
		url: baseurl('timf/get/ALL/json'),
		dataType: 'json',
		success: function (json) {
			var config = json.Config; 
			if(config.pub != undefined){
				if (validate(config.pub.firstName)) {
					if (config.pub.firstName.show) {
						$('#first_yes').attr('checked', '');
						$('#firstname').removeAttr('disabled', '');
					}
					else {
						$('#first_no').attr('checked', '');
						$('#firstname').attr('disabled', '');
					}
					if (config.pub.firstName.value == '') {
						$('#firstname').attr('value', json.First);	
					}
					else {
						$('#firstname').attr('value', config.pub.firstName.value);
					}
				}
				else {
				 console.log('firstName Configuration is not Valid.');
				}
				if (validate(config.pub.lastName)) {
					if (config.pub.lastName.show) {
						$('#last_yes').attr('checked', '');
					}
					else{
						$('#last_no').attr('checked', '');
					}
					if (config.pub.lastName.value == '') {
						$('#lastname').attr('value', json.Last);	
					}
					else {
						$('#lastname').attr('value', config.pub.lastName.value);
					}
				}
				else {
				 console.log('lastName Configuration is not Valid.');
				}
				if (validate(config.pub.avatar)) {
					if (config.pub.avatar.show) {
						$('#avatar_yes').attr('checked', '');
					}
					else{
						$('#avatar_no').attr('checked', '');
					}
				}
				else {
				 console.log('avatar Configuration is not Valid.');
				}
				if (config.pub.show != undefined) {
					if(json.Config.pub.show == 'true'){
						$('.pub').show();
						$('#showProfile').attr('checked', '');
					}
					else if(json.Config.pub.show == 'false'){
						$('.pub').hide();
						$('#showProfile').removeAttr('checked');
					}
				}
				else {
					console.log('showProfile Configuration is not Valid.');
					$('.pub').show();
					$('#showProfile').attr('checked', '');
				}
			}
		},
		failure: function () {
			$('#info').html('AJAX Request Failed.');
			setTimeout($('#info').hide(900).delay(1000).html('').show(900), 10000);
		}
	});
}
function setConfig(part, form, target) {
	if(part == "pub"){
		var showFirst = getChecked(form.showFirstname).value;
		var showLast = getChecked(form.showLastname).value;
		var showAvatar = getChecked(form.showAvatar).value;
		var showProfile = form.showProfile.checked;
		$.ajax({
			url: baseurl('timf/get/ALL/json'),
			dataType: 'json',
			success: function (json) {
				json.Config.pub.show = showProfile;
				json.Config.pub.firstName = {'show': showFirst, 'value': form.firstname.value};
				json.Config.pub.lastName = {'show': showLast, 'value': form.lastname.value};
				json.Config.pub.avatar = {'show': showAvatar, 'value': ''};
				console.log(json);
				$.ajax({
					url: baseurl('timf/config/set'),
					type: 'post',
					dataType: 'json',
					data: {'json': json},
					success: function (resp) {
						console.log(resp);	
					},
					failure: function () {
						$(target).html('AJAX Request Failed.');
					}
				});
			}
		}).done(function (resp) {
				if(resp.success == 'true'){
					$(target).html('Gespeichert :)') + resp;
				}
				else if(resp.success == 'false'){
					$(target).html('Fehler: ' + resp.response);
				}
			});
		//$(target).html('Fehler :/');		
	}
	else if (part == "gen") {
		$.ajax({
			url: baseurl('timf/config/avatar'),
			data: {'json': {'url': form.avatar.value}},
			type: "POST",
			dataType: 'json',
			success: function (resp) {
				if(resp.success){
					$(target).html('Gespeichert :)');
				}
				else {
					$(target).html('Fehler: ' + resp.response);
				}
			},
			failure: function () {
				$(target).html('AJAX Request Failed.');
			}
		}).done(function (resp) {console.log(resp)});
	}
	else {
		$('#info').html('Unbekannte Aktion.');
	}
}
function validate(value){
	return value.show != undefined && value.value != undefined
}