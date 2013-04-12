$(document).ready(function(){
	$('.item-del').click(function(){
		var id = $(this).attr('rel');
		jConfirm('Bạn có thực sự muốn xóa không?','Xác nhận hành động', function(ok){
			if (ok){
				$.post("ajax.php?path=system&fnc=syspage.process", {
					'act'	: 'del',
					'id'	: id
					}, function(response){	//response
						return responseProcess(response);
					}
				);
			}
		});
	});
	
	// Link đến trang EDIT
	$('.item-edit').click(function(){
		var url = $(this).attr('rel');
		document.location.href = url;
	});
	
	// Thay đổi trạng thái
	$('.change_publish').click(function(){
		var data = $(this).attr('rel');
		$.post("ajax.php?path=system&fnc=syspage.process", {
			'act'	: 'change_publish',
			'data'	: data
			}, function(response){	//response
				return responseProcess(response);
			}
		);
	});
});