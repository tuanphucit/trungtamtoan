$(document).ready(function(){
	$("#page_btn_OK").click(function(){
		if ( !$('#SystemPageAddView').validationEngine('validate') ) return;
		
		$.post("ajax.php?path=system&fnc=system.page.process", {
			'act'	: 'add',
			'page_name'		: $('#page_name').val(),
			'brief'			: $('#brief').val(),
			'layout'		: $('#layout').val(),
			'master_id'		: $('#master_page_id').val(),
			'portal_id'		: $('#portal_id').val(),
			'publish_flg'	: $('#publish:checked').val(),
			'title'			: $('#page_title').val(),
			'description'	: $('#page_description').val(),
			'keyword'		: $('#page_keyword').val()
			}, function(response){	//response
				return responseProcess(response);
			}
		);
	});
	
	
	// Reload layout
	$('.item-reload_layout').click(function(){
		$.post("ajax.php?path=system&fnc=system.layouts.process", {
			'act'	: 'reload'
		}, function(response){	//response
				return responseProcess(response);
			}
		);
	});
});