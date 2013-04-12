var commentDom = jQuery.noConflict();

(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=471449872880599";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));


commentDom(document).ready(function(){
	
	var validateUsername = commentDom('#validateUsername');
	 commentDom('#fullname').keyup(function () {
		    var t = this; 
		    if (this.value != this.lastValue) {
		      if (this.timer) clearTimeout(this.timer);
		      validateUsername.removeClass('error').html('<span style="color: blue;"> **Đang kiểm tra...</span>');
		      
		      this.timer = setTimeout(function () {
		    	  commentDom.ajax({
		        	url:"ajax.php?path=mcweb&fnc=mcweb.giasu.process",
		    		type:"POST",
		    		data:  {
		    			'act'	: 'validate',
		    			'username'	: commentDom('#fullname').val(),				
		    			},
		    		dataType: 'json',
		    		success: function(data){
		    			if(data.ok){	    				
		    				  validateUsername.html("<span style='color:red;'> **Không dùng tên của thành viên khi chưa đăng nhập</span>");
		    				  commentDom("#cm-submit").attr('disabled','disabled');
		    				return false;
		    			}
		    			 commentDom("#cm-submit").removeAttr('disabled');
		    			 validateUsername.html("<span style='color:green;'> **Có thể dùng tên này để viết bình luận</span>");
		    		}
		        });
		      }, 200);
		      
		      this.lastValue = this.value;
		    }
		  });
	
	var currentLink = commentDom('#currentLink').text();
	load(currentLink);
	commentDom('#mc_tab').click(function(){
		commentDom('#fb_tab').removeClass('active');
		commentDom(this).addClass('active');
		commentDom('#fb_comment').hide();
		commentDom('#mc_comment').show();
	});
	
	commentDom('#fb_tab').click(function(){
		commentDom('#mc_tab').removeClass('active');
		commentDom(this).addClass('active');
		commentDom('#fb_comment').show();
		commentDom('#mc_comment').hide();
	});
	
	
	commentDom("#cm-submit").click(function(){
		var fullname = commentDom.trim(commentDom('#fullname').val());
		var yourcomment = commentDom.trim(commentDom('#yourcomment').val());
		
		if(fullname == ''){
			jAlert('Bạn chưa nhập họ tên');
			return false;
		}
		
		if(yourcomment == ''){
			jAlert('Bạn chưa nhập nội dung bình luận');
			return false;
		}
		
		commentDom.ajax({
				url:"ajax.php?path=mcweb&fnc=mcweb.comment.process",
				type:"POST",
				data:  {
					'act'	: 'add',
					'currentLink'	: currentLink,
					'fullname'		: commentDom('#fullname').val(),
					'yourcomment'		: commentDom('#yourcomment').val(),
					},
				dataType: 'json',
				success: function(data){
					if(data.notice = "success"){
						load(currentLink);
					}
						
				}
		});	

		return false;
	});
});

function load(urlLink){
	commentDom.ajax({
		url:"ajax.php?path=mcweb&fnc=mcweb.comment.process",
		type:"POST",
		data:  {
			'act'	: 'load',
			'urlLink' : urlLink,
			},
		dataType: 'json',
		success: function(data){
			commentDom('#mc_comment_content').html(data.content);			
		}
	});			
	
}
