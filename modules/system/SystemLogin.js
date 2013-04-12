$(document).ready(function(){
	// send data
	$("#login_btn_OK").click(function(){
		jQuery("#SystemLoginView").validationEngine();
		if ( !$('#SystemLoginView').validationEngine('validate') ) return;
		
		$.post("ajax.php?path=system&fnc=system.login.process", {
			'act': 'login',
			'username': $('#username').val(),
			'password'	: $('#password').val(),
			'save_password': $('#save_password:checked').val()
			}, function(response){
				return responseProcess(response);
			}
		);
	});
});

function responseProcess(response) {
	response = '<return>' + response + '</return>';

	var xmlDoc = $.parseXML( response );
    var $xml = $( xmlDoc );
    var $response = $xml.find( "response" );
    
    if ($response.attr('type') != undefined) {
		var $status = $xml.find( "status" );

		if ($status.text() == 'SUCC'){
			jAlert('Thực hiện thành công','Thông báo');
			document.location.reload();
			return true;
		} else if ($status.text() == 'NOT_SUCC'){
			jAlert('Đăng nhập sai', 'Thông báo');
			return true;
		} else if ($status.text() == 'NOT_PROCESSING') {
			jAlert($status.attr('value'), 'Thông báo');
			return true;
		} else if ($status.text() == 'MSG') {
			var $data_json = $xml.find( "data" );
			//var $data_type = $data.attr('type');
			jAlert($.parseJSON($data_json.text()), 'Thông báo');
			return true;
		} else {
			jAlert($status.attr('value'), 'Có vấn đề xảy ra', function (ok) {
				//if (ok) document.location.reload();
			});
			return false;
		}
	} else {
		jAlert($xml.find( "return" ).text(), 'Có vấn đề xảy ra');
	}
}