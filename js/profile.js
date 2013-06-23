function update(update, target) {
	$.ajax({
		url: baseurl("timf/update"),
		method: 'POST',
		data: {'update': update},
		success: function (response) {
			console.log(target);
			$(target).show().html('Status wurde erneuert :)<br>' + response);
			setTimeout(function () {$(target).hide(900).delay(1000).html('').show()}, 5000);
		},
		failure: function () {
			$(target).show().html('AJAX Request Failed.');
			setTimeout(function () {$(target).hide(900).delay(1000).html('').show()}, 5000);
		}
	});
	lastUpdates(target);
}
function lastUpdates(target) {
	$.ajax({
		url: baseurl('timf/lastUpdates/li/updates/20'),
		success: function (response) {
			$(target).html(response);
		},
		failure: function () {
			$(target).html('AJAX Request Failed');
		}
	});
}