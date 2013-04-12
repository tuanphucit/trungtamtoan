$(document).ready(function(){
	// send data
	$("#debug_btn_OK").click(function(){
		$.post("ajax.php?path=system&fnc=system.setting.process", {
			'act': 'config_debug',
			'debug_enable': 	$('#debug_enable:checked').val(),
			'debug_error': 		$('#debug_error:checked').val(),
			'debug_general_information': 	$('#debug_general_information:checked').val(),
			'debug_layout_position_flugin': $('#debug_layout_position_flugin:checked').val(),
			'debug_sql_query': 		$('#debug_sql_query:checked').val(),
			'debug_includes_file': 	$('#debug_includes_file:checked').val(),
			'debug_var': 		$('#debug_var:checked').val(),
			'debug_request': 	$('#debug_request:checked').val(),
			'debug_lang': 		$('#debug_lang:checked').val()
			}, function(response){
				return responseProcess(response);
			}
		);
	});
});