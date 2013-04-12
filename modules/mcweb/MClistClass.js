var listClassDom = jQuery.noConflict();	
function loadPage(currentID){
	listClassDom('#nextPage').html('<center><a rel="0" style="color:blue;"><img width="30" height="15" border="0" src="webskins/skins/default/main/images/loading.gif"></a></center>');
	  listClassDom.ajax({
      	url:"ajax.php?path=mcweb&fnc=mcweb.class.process",
  		type:"POST",
  		data:  {
  			'act'	: 'next',
  			'currentID'	: currentID,				
  			},
  		dataType: 'json',
  		success: function(data){
  			if(data.ok){	    				
  				  listClassDom('#listClassContent').append(data.notice);
  				listClassDom('#nextPage').html(data.next);
  				
  			}else{
  				listClassDom('#nextPage').html(data.next);
  			}  		
  		}
      });
	
}


listClassDom(document).ready(function(){	 
	loadPage(0);
	listClassDom("#nextPage").click(function(){
		var currentID = listClassDom("#nextPage a").attr('rel');
		if(currentID != -1)	loadPage(currentID);
	});
});