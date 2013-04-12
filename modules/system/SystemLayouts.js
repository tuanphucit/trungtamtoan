$(document).ready(function(){
	// Scan layout
	$('#f_btnOk').click(function(){
		$.post("ajax.php?path=system&fnc=system.layouts.process",{
			'act'	: 'scan'
		}, function(response){
			response = '<return>' + response + '</return>';

			var xmlDoc = $.parseXML( response );
		    var $xml = $( xmlDoc );
		    var $response = $xml.find( "response" );
		    
		    if ($response.attr('type') != undefined) {
				var $status = $xml.find( "status" );
				//var $data_json = $xml.find( "data" );
				//var $data_type = $data.attr('type');
				//var $data_obj = $.parseJSON($data.text());
		
				if ($status == 'SUCC'){
					document.location.reload();
					return true;
				} else if ($status == 'NOT_SUCC'){
					jAlert($status.attr('value'), 'Thông báo');
					return true;
				} else if ($status == 'NOT_PROCESSING') {
					jAlert($status.attr('value'), 'Thông báo');
					return true;
				} else if ($status == 'MSG') {
					var $data_json = $xml.find( "data" );
					jAlert($.parseJSON($data.text()), 'Thông báo');
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
		});
	});
});