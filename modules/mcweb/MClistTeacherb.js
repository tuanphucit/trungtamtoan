var listTeacherDomB = jQuery.noConflict();	
function loadPage(currentID){
	listTeacherDomB('#nextPage').html('<center><a rel="0" style="color:blue;"><img width="30" height="15" border="0" src="webskins/skins/default/main/images/loading.gif"></a></center>');
	  listTeacherDomB.ajax({
      	url:"ajax.php?path=mcweb&fnc=mcweb.giasu.process",
  		type:"POST",
  		data:  {
  			'type'	: 'type0',
  			'act'	: 'next',
  			'currentID'	: currentID,
  			},
  		dataType: 'json',
  		success: function(data){
  			if(data.ok){	    				
  				  listTeacherDomB('#listGiasuContent').append(data.notice);
  				listTeacherDomB('#nextPage').html(data.next);
  				
  			}else{
  				listTeacherDomB('#nextPage').html(data.next);
  			}  		
  		}
      });
	
}

listTeacherDomB(document).ready(function(){	 
	loadPage(0);
	listTeacherDomB("#nextPage").click(function(){
		var currentID = listTeacherDomB("#nextPage a").attr('rel');
		if(currentID != -1)	loadPage(currentID);
	});
});