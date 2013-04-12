$(document).ready(function(){
	$("#setting_btn_OK").click(function(){
		$.post("ajax.php?path=system&fnc=system.setting.process", {
			'act'	: 'setting_public',
			'rewrite_url': $('#rewrite_url:checked').val()
			}, function(response){
				return responseProcess(response);
			}
		);
	});
});