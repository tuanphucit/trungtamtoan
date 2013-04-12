var jforgetPass = jQuery.noConflict();

jforgetPass(document).ready(function(){	
	jforgetPass("#sendRequest").click(function(e){	
		jforgetPass("#forgetpassform").validationEngine();
		if ( !jforgetPass('#forgetpassform').validationEngine('validate') ) {	
			return false;
		}else{
			return true;
		}	
	});
});


