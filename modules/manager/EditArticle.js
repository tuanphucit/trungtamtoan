$(document).ready(function(){	
	CKEDITOR.replace( 'content' );
	
	$("#article_btn_OK").click(function(){
		var article_id = $('#article_id').val();
		var content = CKEDITOR.instances.content.getData();
		if(article_id == 0){
			$.ajax({
				url:"ajax.php?path=mcweb&fnc=mcweb.article.process",
				type:"POST",
				data:  {
					'act'	: 'add',
					'category_id'	: $('#category_id').val(),
					'subject'		: $('#subject').val(),
					'content'			: content,
					'introduction'		: $('#introduction').val(),
					'headImage'		: $('#headImage').val(),
					'status'		: $('#status').val(),
					},
				dataType: 'json',
				success: function(data){
					if(data.notice = "success")
						history.go(-1);
				}
			});			
		
		}else{
			$.ajax({
				url:"ajax.php?path=mcweb&fnc=mcweb.article.process",
				type:"POST",
				data:  {
					'act'	: 'edit',
					'article_id'	: $('#article_id').val(),
					'category_id'	: $('#category_id').val(),
					'subject'		: $('#subject').val(),
					'content'		: content,
					'introduction'	: $('#introduction').val(),
					'headImage'		: $('#headImage').val(),
					'status'		: $('#status').val(),
					},
				dataType: 'json',
				success: function(data){
					if(data.notice = "success")
						history.go(-1);
				}
			});
		}
	});
});