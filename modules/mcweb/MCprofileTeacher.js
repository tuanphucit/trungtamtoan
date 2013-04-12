	
var getTeachDom = jQuery.noConflict();	
getTeachDom(document).ready(function(){
	  getTeachDom("#register").click(function(){	
		  getTeachDom("#MCwebTeacherView").validationEngine();
			if ( !getTeachDom('#MCwebTeacherView').validationEngine('validate') ) {	
				return false;
			}else{
				return true;
			}	
		});
});