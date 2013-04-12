$(document).ready(function(){
	$("#portal_btn_OK").click(function(){
		if ( !$('#SystemPortalAddView').validationEngine('validate') ) return;

		$.post("ajax.php?path=system&fnc=system.portal.process", {
			'act'	: 'add',
			'name'	: $('#portal_name').val(),
			'brief'	: $('#portal_brief').val(),
			'publish': $('#portal_publish:checked').val()
			}, function(response){	//response
				response = '<return>' + response + '</return>';

				var xmlDoc = $.parseXML( response );
			    var $xml = $( xmlDoc );
			    var $response = $xml.find( "response" );
			    
			    if ($response.attr('type') != undefined) {
					var $status = $xml.find( "status" );

					if ($status.text() == 'SUCC'){
						jAlert('Tạo thành công', 'Thông báo', function(ok){
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
	});
});