$(document).ready(function(){
	$('#hint_layout_color, #hint_block_color').ColorPicker({
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onSubmit: function(hsb, hex, rgb, el) {
			$(el).val(hex);
			$(el).ColorPickerHide();
			$('#view_'+$(el).attr('id')).css('background-color','#'+hex);
			$("#demo-hint-layout").css('border-color','#' + $('#hint_layout_color').val());
			$("#demo-hint-block").css('border-color','#' + $('#hint_block_color').val());
		},
		onBeforeShow: function () {
			$(this).ColorPickerSetColor(this.value);
		}
	})
	.bind('keyup', function(){
		$(this).ColorPickerSetColor(this.value);
	});
	
	// send data
	$("#hint_btn_OK").click(function(){
		$.post("ajax.php?path=system&fnc=system.setting.process", {
			'act': 'config_hint',
			'hint_layout_enable': $('#hint_layout_enable:checked').val(),
			'hint_layout_color'	: $('#hint_layout_color').val(),
			'hint_layout_style'	: $('#hint_layout_style').val(),
			'hint_layout_width'	: $('input[name="hint_layout_width"]:checked').val(),
			'hint_block_enable': $('#hint_block_enable:checked').val(),
			'hint_block_color'	: $('#hint_block_color').val(),
			'hint_block_style'	: $('#hint_block_style').val(),
			'hint_block_width'	: $('input[name="hint_block_width"]:checked').val(),
			'hint_system_module_enable': $('#hint_system_module_enable:checked').val()
			}, function(response){
				return responseProcess(response);
			}
		);
	});
	
	// onChange to demo
	$("#hint_layout_style").change(function(){
		$("#demo-hint-layout").css('border-style',$(this).val());
	});
	$("input[name='hint_layout_width']").change(function(){
		$("#demo-hint-layout").css('border-width',$(this).val());
	});
	
	$("#hint_block_style").change(function(){
		$("#demo-hint-block").css('border-style',$(this).val());
	});
	$("input[name='hint_block_width']").change(function(){
		$("#demo-hint-block").css('border-width',$(this).val());
	});
});