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

class MCforgetPass extends CgsModules {
	function __construct() {
	}

	function execute() {
		Page::reg('css',CGS_WEBSKINS_PATH.'plugins/formValidator.2.2/css/validationEngine.jquery.css');
  		Page::reg('js',CGS_WEBSKINS_PATH.'plugins/formValidator.2.2/js/languages/jquery.validationEngine-vi2.js','footer');
  		Page::reg('js',CGS_WEBSKINS_PATH.'plugins/formValidator.2.2/js/jquery.validationEngine.js','footer');
  		Page::reg('js',CGS_WEBSKINS_PATH.'plugins/formValidator.2.2/js/contrib/other-validations.js','footer');
  		Page :: reg('js', Page :: pathMod() . 'MCforgetPass.js');
		
		$message = '<span style="color: blue;">Bạn cần nhập đủ các thông tin</span>';
		$username = '';
		$email ='';
	if($_POST['sendRequest']!=NULL){
		$username = trim(Page :: getRequest('username', 'str', NULL, 'POST'));
		$email = trim(Page :: getRequest('email', 'str', NULL, 'POST'));
		if($username != '' && $email !=''){
			$giasuObj = new DefaultGiasuPeer();	
			$user = $giasuObj->selectOne("giasu", 'giasu_id', "`username` = '{$username}' AND `email` = '{$email}' AND `status` = 1");	
			if($user){
				$newPass = CgsFunc::passwordGenerator(rand(), 10);
				$password = MD5($newPass);
				$update = $giasuObj->updateId($user['giasu_id'],array('password'=>$password));
				if($update){
					include_once (CGS_LIB_PATH.'sendmail/class.tttmail.php');
					$htmlcontent = "Chào bạn! <br>" .
									"Bạn đã quên mật khẩu và yêu cầu cấp lại. Mật khẩu mới của bạn là:<br>" .
									"<b>".$newPass."</b><br>" .
									"Mời đăng nhập và thay đổi lại<br><br>" .
									"Trân trọng cám ơn!<br>" .
									"<a href='trungtamtoan.com'>Trung Tâm Toán<a>";
					$mail = new TrungTamToanMail();
					$status = $mail->sendMail('trungtamtoan', $email, NULL, "Reset Password", $htmlcontent, null);
					if($status){
						$message = '<span style="color: green;">Mật khẩu mới đã được gửi tới email: '.$email.' của bạn.Xin cám ơn</span>';
						$username = '';
						$email ='';
					}
				}	
			}else{
				$message = '<span style="color: red;">Thông tin bạn nhập vào không đúng</span>';				
			}
		}else{
			$message = '<span style="color: red;">Bạn chưa nhập đủ các thông tin</span>';
			
		}
	}	
		$this->assign('usernameV',$username);
		$this->assign('emailV',$email);
		$this->assign('message',$message);
		$html = $this->output();
		return $html;
	}
		
}