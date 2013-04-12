$(document).ready(function(){
	// send data
	$("#cache_btn_OK").click(function(){
		$.post("ajax.php?path=system&fnc=system.setting.process", {
			'act': 'config_cache',
			'cache_enable': $('#cache_enable:checked').val(),
			'cache_sql': $('#cache_sql:checked').val(),
			'cache_sql_time': $('#cache_sql_time').val(),
			'cache_uri': $('#cache_uri:checked').val(),
			'cache_uri_time': $('#cache_uri_time').val(),
			'cache_module': $('#cache_module:checked').val(),
			'cache_module_time': $('#cache_module_time').val()
			}, function(response){
				return responseProcess(response);
			}
		);
	});
});