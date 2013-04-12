var dialogDOM = jQuery.noConflict();
var Dialog = new Object();
Dialog.show = function(e) {
	//Cancel the link behavior
	e.preventDefault();
	
	//Get the A tag
	var id = '#dialog';

	//Get the screen height and width
	var maskHeight = dialogDOM(document).height();
	var maskWidth = dialogDOM(window).width();

	//Set heigth and width to mask to fill up the whole screen
	dialogDOM('#mask').css({'width':maskWidth,'height':maskHeight});
	
	//transition effect		
	dialogDOM('#mask').fadeIn(1000);	
	dialogDOM('#mask').fadeTo("slow",0.8);	

	//Get the window height and width
	var winH = dialogDOM(window).height();
	var winW = dialogDOM(window).width();

	//Set the popup window to center
	
	dialogDOM(id).css('top',  winH/2-dialogDOM(id).height()/2);
	dialogDOM(id).css('left', winW/2-dialogDOM(id).width()/2);

	//transition effect
	dialogDOM(id).fadeIn(2000); 
	
	//if close button is clicked
	dialogDOM('.window .close').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		
		dialogDOM('#mask').hide();
		dialogDOM('.window').hide();
	});		
	
	//if mask is clicked
	dialogDOM('#mask').click(function () {
		dialogDOM(this).hide();
		dialogDOM('.window').hide();
	});	
}