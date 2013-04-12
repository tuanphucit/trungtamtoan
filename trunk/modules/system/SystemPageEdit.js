$(document).ready(function(){
	$("#page_btn_OK").click(function(){
		if ( !$('#SystemPageEditView').validationEngine('validate') ) return;
		
		$.post("ajax.php?path=system&fnc=system.page.process", {
			'act'	: 'edit',
			'page_id'	: $('#page_id').val(),
			'page_name'		: $('#page_name').val(),
			'brief'			: $('#brief').val(),
			'layout'		: $('#layout').val(),
			'master_id'		: $('#master_page_id').val(),
			'portal_id'		: $('#portal_id').val(),
			'publish_flg'	: $('#publish:checked').val(),
			'title'			: $('#page_title').val(),
			'description'	: $('#page_description').val(),
			'keyword'		: $('#page_keyword').val(),
			'is_empty_module': $('#empty_module:checked').val()
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
	
	// Click choose plugin module
	$('.plugin_mod').click(function(){
		var pos = $(this).attr('pos');
		$('#popup_position').val(pos);
	});
	
	// Empty
	$('.empty_mod').click(function(){
		var pos = $(this).attr('pos');
		jConfirm('Bạn có thực sự muốn xóa hết Các module đã cắm không?','Xác nhận',function(ok){
			if (ok){
				$.post("ajax.php?path=system&fnc=system.page.edit.process", {
					'act'	: 'empty_module',
					'page_id'	: $('#page_id').val(),
					'position'	: pos
					}, function(response){	//response
						return responseProcess(response);
					}
				);
			}
		});
	});
	
	$('#popup_btnOk').click(function(){
		if (!$('#popup_position').val() || !$('#popup_module').val()){
			jAlert('Không thể thực hiện', 'Thông báo');
			return false;
		}
		
		$.post("ajax.php?path=system&fnc=system.page.edit.process", {
			'act'	: 'plugin_module',
			'page_id'	: $('#page_id').val(),
			'position'	: $('#popup_position').val(),
			'module'	: $('#popup_module').val()
			}, function(response){	//response
				return responseProcess(response);
			}
		);
	});
	
	//un plugin
	$('.unplugin_mod').click(function(){
		var data = $(this).attr('rel');
		$.post("ajax.php?path=system&fnc=system.page.edit.process", {
			'act'	: 'unplugin_module',
			'page_id'	: $('#page_id').val(),
			'data'	: data
			}, function(response){	//response
				return responseProcess(response);
			}
		);
	});
	
	
	//up
	$('.up_mod').click(function(){
		var data = $(this).attr('rel');
		$.post("ajax.php?path=system&fnc=system.page.edit.process", {
			'act'	: 'up_module',
			'page_id'	: $('#page_id').val(),
			'data'	: data
			}, function(response){	//response
				return responseProcess(response);
			}
		);
	});
	
	//down
	$('.down_mod').click(function(){
		var data = $(this).attr('rel');
		$.post("ajax.php?path=system&fnc=system.page.edit.process", {
			'act'	: 'down_module',
			'page_id'	: $('#page_id').val(),
			'data'	: data
			}, function(response){	//response
				return responseProcess(response);
			}
		);
	});
	
	////////////////////////
	// load module
	$(".reload_mod-module").click(function(){
		$.post("ajax.php?path=system&fnc=system.module.process", {
			'act'	: 'scan_all'
			}, function(response){	//response
				return responseProcess(response);
			}
		);
	});
});