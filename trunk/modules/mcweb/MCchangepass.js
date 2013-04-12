var changepassdom = jQuery.noConflict();

changepassdom(document).ready(function(){	
	changepassdom("#change").click(function(e){	
		changepassdom("#changepassform").validationEngine();
		if ( !changepassdom('#changepassform').validationEngine('validate') ) {	
			return false;
		}else{
			return true;
		}	
	});
});


