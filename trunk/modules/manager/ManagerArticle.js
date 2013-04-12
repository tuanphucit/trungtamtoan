$(document).ready(function(){
	$('.item-del').click(function(){
		var id = $(this).attr('rel');
		jConfirm('Bạn có thực sự muốn xóa không?','Xác nhận hành động', function(ok){
			if (ok){
				$.ajax({
					url:"ajax.php?path=mcweb&fnc=mcweb.article.process",
					type:"POST",
					data:  {
						'act'	: 'del',	
						'article_id' : id
						},
					dataType: 'json',
					success: function(data){
						if(data.notice = "success"){							
							history.go(0);
						}	
					}
				});			
			}
		});
	});
});