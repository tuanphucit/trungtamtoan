$(document).ready(function(){
	// send data
	$("#log_btn_OK").click(function(){
		$.post("ajax.php?path=system&fnc=system.setting.process", {
			'act': 'config_log',
			'log_enable': $('#log_enable:checked').val(),
			'log_error': $('#log_error:checked').val(),
			'log_sql': $('#log_sql:checked').val(),
			'log_sql_view': $('#log_sql_view:checked').val(),
			'log_sql_add': $('#log_sql_add:checked').val(),
			'log_sql_edit': $('#log_sql_edit:checked').val(),
			'log_sql_delete': $('#log_sql_delete:checked').val(),
			'log_sql_other': $('#log_sql_other:checked').val(),
			'log_sql_slow': $('#log_sql_slow:checked').val(),
			'log_sql_slow_time': $('#log_sql_slow_time').val()
			}, function(response){
				return responseProcess(response);
			}
		);
	});
});