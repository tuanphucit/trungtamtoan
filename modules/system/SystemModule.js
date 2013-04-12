$(document).ready(function(){
	$("#f_btnOk_Scan_all").click(function(){
		$.post("ajax.php?path=system&fnc=system.module.process", {
			'act'	: 'scan_all'
			}, function(response) {
				responseProcess(response);
			});
	});
	
	$("#f_btnOk_Scan_custom").click(function(){
		$.post("ajax.php?path=system&fnc=system.module.process", {
			'act'	: 'scan_custom'
			}, function(response) {
				return responseProcess(response);
			});
	});
});