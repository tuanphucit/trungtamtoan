	
var getLearnDom = jQuery.noConflict();	
getLearnDom(document).ready(function(){
	
	getLearnDom("#register").click(function(){	
		jQuery("#MCwebPupilView").validationEngine();
		if ( !getLearnDom('#MCwebPupilView').validationEngine('validate') ) {	
			return false;
		}else{
			return true;
		}	
	});
});