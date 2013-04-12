$(document).ready(function(){
	// Hien thi button edit language
	$('.debug-lang').hover(
		function(){ // over
			$(this).append('<span class="debug-lang_append">Edit</span>');
		},
		function(){ // out
			$(this).find('.debug-lang_append').remove();
		}
	);
	
	$('.debug-lang_append').live('click',function(){
		var parent = $(this).parent();
		var data = parent.attr('rel');
		parent.find('.debug-lang_append').remove();
		var old_val = parent.html();
		
		strArr = data.split('|',3);

		jPrompt('lang.'+strArr[2]+' = ',old_val,'Thay đổi nhãn hiển thị', function(new_val){
			if (new_val != null && new_val != '' && new_val != old_val) {
				
				$.post("ajax.php?path=config&fnc=lang.set.process", {
					'data'	: data,
					'val'	: new_val
					}, function(rsp){	//response
						if (rsp == 'SUCC'){
							parent.html(new_val);
							return true;
						} else if (rsp == 'NOT_SUCC'){
							jAlert('Không thành công', 'Thông báo');
							return true;
						} else {
							jAlert(rsp, 'Có vấn đề xảy ra');
							return false;
						}
					}
				);
			}
		});
		
	