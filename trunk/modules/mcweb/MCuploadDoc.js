	
var uploadDom = jQuery.noConflict();	
uploadDom(document).ready(function(){
	jConfirm('Bạn sẽ chịu hoàn toàn trách về những file mình tải lên?','Điều kiện tải file lên trungtamtoan.com', function(ok){
		if (ok){
			return true;
		}else{
			history.go(-1);
		}
	});

	uploadDom('#fileUpload').fileValidator({
		  onInvalid:    function(type, file){
			  uploadDom(this).val(null);
			  jAlert('Trungtamtoan.com chỉ cho phép tải lên file có kích thước nhỏ hơn 2Mb'); },
			  maxSize:      '2m', //optional
		});
	


	  uploadDom("#upload").click(function(){
		  uploadDom("#MCuploadDocView").validationEngine();
			if ( !uploadDom('#MCuploadDocView').validationEngine('validate') ) {	
				return false;
			}else{
				return true;
			}	
		});
});
