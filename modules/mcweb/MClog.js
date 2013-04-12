var j = jQuery.noConflict();

j(document).ready(function(){	
	j("#login").click(function(e){	
		j("#userlogin").validationEngine();
		if ( !j('#userlogin').validationEngine('validate') ) {	
			return false;
		}else{
			return true;
		}	
	});
});


