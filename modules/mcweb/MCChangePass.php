<?php


/**
 * @desc			
 * @author 			HoangNV<longhoangvnn@gmail.com> 
 * @package 		modules
 * @subpackage 		system
 * @version 		Id: SysPage.php v1.0 03/01/2011 hoangnv
 * @since 			CGS v 2.0
 * @copyright 		CGS.,JSC (c) 2011
 *
 */
defined('IN_CGS') or die('Restricted Access');
require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultGiasuPeer.php';

class MCChangePass extends CgsModules {
	function __construct() {
	}

	function execute() {
	Page::reg('css',CGS_WEBSKINS_PATH.'plugins/formValidator.2.2/css/validationEngine.jquery.css');
	Page::reg('js',CGS_WEBSKINS_PATH.'plugins/formValidator.2.2/js/languages/jquery.validationEngine-vi2.js','footer');
	Page::reg('js',CGS_WEBSKINS_PATH.'plugins/formValidator.2.2/js/jquery.validationEngine.js','footer');
	Page::reg('js',CGS_WEBSKINS_PATH.'plugins/formValidator.2.2/js/contrib/other-validations.js','footer');
	Page :: reg('js', Page :: pathMod() . 'MCchangepass.js');
		
		
	$message = '<span style="color: blue;">Mời nhập đủ các thông tin bên dưới</span>';
	if (!Page :: isLogIn()) {
			Page :: goLink(null, 'index', 'mc_web');
	}
	$old ='';
	$newPassword = '';
	$confirmPassword = '';
		
	if($_POST['change']!=NULL){
		$giasuObj = new DefaultGiasuPeer();	
		$old = trim(Page :: getRequest('currentPass', 'str', NULL, 'POST'));
		$newPassword = trim(Page :: getRequest('newPass', 'str', NULL, 'POST'));
		$confirmPassword = trim(Page :: getRequest('reNewPass', 'str', NULL, 'POST'));
		
		if($old!='' && $newPassword!='' && $confirmPassword!=''){
			$username = Page :: getRequest('username', 'str', NULL, 'SESSION');
			$password = Page :: getRequest('password', 'str', NULL, 'SESSION');
							
			if($old == $password){
				if($newPassword ==  $confirmPassword){
					$oldPassword = md5(Page :: getRequest('currentPass', 'str', NULL, 'POST'));
					$user = $giasuObj->selectOne("giasu", 'giasu_id', "`username` = '{$username}' AND `password` = '{$oldPassword}' AND `status` = 1");	
					if($user){
						$password = MD5($newPassword);
						$update = $giasuObj->updateId($user['giasu_id'],array('password'=>$password));	
						if($update){
							$message = '<span style="color: green;">Đổi pass thành công, mời đăng nhập lại</span>';
							Page::clearRequest('IS_LOG_IN', 'SESSION');	
							Page::clearRequest('username','SESSION');
							Page::clearRequest('password', 'SESSION');	
							$old ='';
							$newPassword = '';
							$confirmPassword = '';
						}		
					}
				}else{
					$message =  '<span style="color: red;">Mật khẩu mới và mật khẩu nhập lại không khớp nhau</span>';
				}
			}else{
				$message = '<span style="color: red;">Mật khẩu hiện tại không đúng</span>';
			}
		}else{
			$message = '<span style="color: red;">Bạn chưa nhập đủ các ô</span>';
		}	
	}
		$this->assign('old',$old);
		$this->assign('new',$newPassword);
		$this->assign('confirm',$confirmPassword);		
		$this->assign('message',$message);
		$html = $this->output();
		return $html;
	}
		
}