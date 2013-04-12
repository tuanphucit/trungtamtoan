var listTeacherDom = jQuery.noConflict();	
function loadPage(currentID){
	listTeacherDom('#nextPage').html('<center><a rel="0" style="color:blue;"><img width="30" height="15" border="0" src="webskins/skins/default/main/images/loading.gif"></a></center>');
	  listTeacherDom.ajax({
      	url:"ajax.php?path=mcweb&fnc=mcweb.giasu.process",
  		type:"POST",
  		data:  {
  			'type'	: 'type1',
  			'act'	: 'next',
  			'currentID'	: currentID,				
  			},
  		dataType: 'json',
  		success: function(data){
  			if(data.ok){	    				
  				  listTeacherDom('#listGiasuContent').append(data.notice);
  				listTeacherDom('#nextPage').html(data.next);
  				
  			}else{
  				listTeacherDom('#nextPage').html(data.next);
  			}  		
  		}
      });
	
}

listTeacherDom(document).ready(function(){	 
	loadPage(0);
	listTeacherDom("#nextPage").click(function(){
		var currentID = listTeacherDom("#nextPage a").attr('rel');
		if(currentID != -1)	loadPage(currentID);
	});
});