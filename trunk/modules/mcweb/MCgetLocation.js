var getlocationDom = jQuery.noConflict();
var currentLink = location.href;
getlocationDom(document).ready(function() {
	var zoneID = getlocationDom('#zoneID').text();
	
	if(zoneID == 0){
		var screenW = 640, screenH = 480;
		if (parseInt(navigator.appVersion)>3) {
		 screenW = screen.width;
		 screenH = screen.height;
		}
		else if (navigator.appName == "Netscape" 
		    && parseInt(navigator.appVersion)==3
		    && navigator.javaEnabled()) 
		{
		 var jToolkit = java.awt.Toolkit.getDefaultToolkit();
		 var jScreenSize = jToolkit.getScreenSize();
		 screenW = jScreenSize.width;
		 screenH = jScreenSize.height;
		}
		
		var left = (screenW - 500)/2;
		getlocationDom('#dialog').css('display','block');
		getlocationDom('#dialog').css('left',left);
		getlocationDom('#mask').css('display','block');
		getlocationDom('#dialog').show();
		getlocationDom('#mask').show();
	}
	getlocationDom('#locationsubmit').click(function(){
		getlocationDom('#dialog').hide();
		getlocationDom('#mask').hide();
		return true;
	});
	
	getlocationDom("#provinceChange").change(function(){
		var zoneID = getlocationDom("#provinceChange").val();
		getlocationDom.ajax({
	      	url:"ajax.php?path=mcweb&fnc=mcweb.changlocation.process",
	  		type:"POST",
	  		data:  {
	  			'zone'	: zoneID,				
	  			},
	  		dataType: 'json',
	  		async: false,
			cache: false,	
	  		success: function(data){
	  			if(data.ok){   	
	  				document.location.href = currentLink; 	
	  			}else{
	  				alert("Sorry! Can not change.");
	  			}	
	  		}
		});
	});	
});	