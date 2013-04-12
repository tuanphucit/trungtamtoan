$(document).ready(function(){
	// Xóa một đối tượng
	$('.item-del').click(function(){
		var id = $(this).attr('rel');
		jConfirm('Bạn có thực sự muốn xóa không?','Xác nhận hành động', function(ok){
			if (ok){
				$.post("ajax.php?path=system&fnc=system.portal.process", {
					'act'	: 'del',
					'id'	: id
					}, function(response){	//response
						response = '<return>' + response + '</return>';

						var xmlDoc = $.parseXML( response );
					    var $xml = $( xmlDoc );
					    var $response = $xml.find( "response" );
					    
					    if ($response.attr('type') != undefined) {
							var $status = $xml.find( "status" );

							if ($status.text() == 'SUCC'){
								jAlert('Sửa thành công', 'Thông báo', function(ok){
									if (ok) 
										document.location.reload();
								});
								document.location.reload();
								return true;
							} else if ($status.text() == 'NOT_SUCC'){
								jAlert($status.attr('value'), 'Thông báo');
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
		$.post("ajax.php?path=system&fnc=system.portal.process", {
			'act'	: 'change_publish',
			'data'	: data
			}, function(response){	//response
				response = '<return>' + response + '</return>';

				var xmlDoc = $.parseXML( response );
			    var $xml = $( xmlDoc );
			    var $response = $xml.find( "response" );
			    
			    if ($response.attr('type') != undefined) {
					var $status = $xml.find( "status" );

					if ($status.text() == 'SUCC'){
						document.location.reload();
						return true;
					} else if ($status.text() == 'NOT_SUCC'){
						jAlert($status.attr('value'), 'Thông báo');
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
		);
	});
});