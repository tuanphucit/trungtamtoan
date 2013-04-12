var findMarkDom = jQuery.noConflict();
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=471449872880599";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function markSearch() {
		var university_code = findMarkDom('#university').val();
		var searchType = findMarkDom('#searchType').val();
		var name_search = findMarkDom('#name_search').val();  
		
		findMarkDom('#content').html('<center><a rel="0" style="color:blue;"><img width="30" height="15" border="0" src="webskins/skins/default/main/images/loading.gif"></a></center>');
		findMarkDom.ajax({
			      	url:"ajax.php?path=mcweb&fnc=mcweb.findmark.process",
			  		type:"POST",
			  		data:  {
			  			'action'	: 'markfind',
			  			'matruong'	: university_code,	
			  			'searchType'	: searchType,
			  			'tensbd'	: name_search,	
			  			},
			  		dataType: 'json',
			  		success: function(data){
			  			if(data){	    				
			  				findMarkDom('#content').html(data);
			  			}  		
			  		}
			 });
		
		return false;
	}

findMarkDom(document).ready(function() {
	findMarkDom('#submit-btn').click(function(object) {
			markSearch();	
			Dialog.show(object);
	});
});