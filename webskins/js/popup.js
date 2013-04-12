
	$(".show-list").click( function(){		
		openPopup($(this));
	});				
	$(".show-tip").mouseover(function(){		
		openPopup($(this));
	});
	$(".popup-close").click(function(){			
		closePopup();
	});
	$(".close").click(function(){			
		closePopup();
	});
	
	$(".button-close").click(function(){			
		closePopup();
	});
	$(".popup-background").click(function(){
		closePopup();
	});
	
	$(document).keypress(function(e){
		if(e.keyCode==27 && popupFlag==1){
			closePopup();
		}
	});		
	
	var popupFlag = 0;
	
	function openPopup(obj){
		if(popupFlag==0){			
			//var pos = obj.position();	
			var thisParent = obj.parent();
			//var parentTop = thisParent.offset().top;
			var parentTop = obj.position().top;
			var rel = obj.attr('rel');
			var windowWidth = $(window).width();
			var windowHeight = $(window).height();
			var divWidth = $("#"+rel).width(); 
			var divHeight = $("#"+rel).height(); 
			var left = (windowWidth - divWidth)/2;
			//var left = thisParent.offset().left + obj.width()/2 -  divWidth/2;
			if(left+divWidth > windowWidth) left = windowWidth - divWidth;
			var sp = rel.split('-');
			var name = sp[0];
			var id = sp[1];	
			//var top = parentTop + divHeight + 10;
			var top = - (divHeight)/2;
			$("#"+name+"-"+id).css({
				"position": "absolute",
				"top": (windowHeight-divHeight) / 2+getPageScroll()[1],				
				"left" : left
				//"top": pos.top,
				//"left": pos.left				
			});		
	
			$(".popup-background").css({
				"-moz-opacity": 0,
				"opacity": 0.0,
				"z-index": 10,								
				"top": 0,
				"left": 0
			});
	
			$(".popup-background").fadeIn("fast");
			
			$("#"+name+"-"+id).fadeIn("fast");
			
			popupFlag = rel;
		}
	}
	 function getPageScroll() {
		    var xScroll, yScroll;
		    if (self.pageYOffset) {
		      yScroll = self.pageYOffset;
		      xScroll = self.pageXOffset;
		    } else if (document.documentElement && document.documentElement.scrollTop) {	 // Explorer 6 Strict
		      yScroll = document.documentElement.scrollTop;
		      xScroll = document.documentElement.scrollLeft;
		    } else if (document.body) {// all other Explorers
		      yScroll = document.body.scrollTop;
		      xScroll = document.body.scrollLeft;	
		    }
		    return new Array(xScroll,yScroll) 
		  }
	function closePopup(){
		if(popupFlag != 0){
			$(".popup-background").fadeOut("fast");
			$(".popup-choose").fadeOut("fast");
			resetForm('form-'+popupFlag);
			popupFlag = 0;
		}
	}
	
	function resetForm(id) {
		if($('#'+id).length > 0)
		{
			$('#'+id).each(function(){
		        this.reset();
			});
		}		
	}