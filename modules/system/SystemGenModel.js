$(document).ready(function(){

	
	// onChange to demo
	$("#connection").bind('change', function () {
		var url = $(this).attr('rel');
		var conn = $(this).val();
		document.location.href = url + conn;
	});
	
	// checkall
	$('#checkall').bind('change', function () {
		var isChecked = $(this).is(':checked');
		$('.itemLs').each(function(){
			this.checked = isChecked;
		});
	});
});