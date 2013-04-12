	
var getTeachDom = jQuery.noConflict();	
getTeachDom(document).ready(function(){
	
	var validateUsername = getTeachDom('#validateUsername');
	  getTeachDom('#username').keyup(function () {
	    var t = this; 
	    if (this.value != this.lastValue) {
	      if (this.timer) clearTimeout(this.timer);
	      validateUsername.removeClass('error').html('<span style="color: blue;">checking availability...</span>');
	      
	      this.timer = setTimeout(function () {
	        getTeachDom.ajax({
	        	url:"ajax.php?path=mcweb&fnc=mcweb.giasu.process",
	    		type:"POST",
	    		data:  {
	    			'act'	: 'validate',
	    			'username'	: getTeachDom('#username').val(),				
	    			},
	    		dataType: 'json',
	    		success: function(data){
	    			if(data.ok){	    				
	    				  validateUsername.html("<span style='color:red;'>"+ data.notice+"</span>");
	    				  getTeachDom("#register").attr('disabled','disabled');
	    				return false;
	    			}
	    			 getTeachDom("#register").removeAttr('disabled');
	    			 validateUsername.html("<span style='color:green;'>"+ data.notice+"</span>");
	    		}
	        });
	      }, 200);
	      
	      this.lastValue = this.value;
	    }
	  });
	  
	  getTeachDom("#register").click(function(){	
		  getTeachDom("#MCwebTeacherView").validationEngine();
			if ( !getTeachDom('#MCwebTeacherView').validationEngine('validate') ) {	
				return false;
			}else{
				return true;
			}	
		});
});