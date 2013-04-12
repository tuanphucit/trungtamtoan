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

class ManagerLog extends CgsModules {
	function __construct() {
	}

	function execute() {
		
		if($_POST['logout']!=NULL){
			Page::clearRequest('username','SESSION');
			Page::clearRequest('password', 'SESSION');	
			Page::clearRequest('IS_MANAGER_LOGIN', 'SESSION');	
			$_POST['logout']= NULL;
		}
		
		if($_POST['login']!=NULL){
		$giasu = trim(Page :: getRequest('username1', 'str', NULL, 'POST'));
		$password = trim(Page :: getRequest('password1', 'str', NULL, 'POST'));
			if($giasu != '' && $password!=''){
				$giasuObj = new DefaultGiasuPeer();	
				$pass = MD5($password);
				$user = $giasuObj->selectOne("giasu", 'giasu_id, username, firstname, lastname, avatar', "`username` = '{$giasu}' AND `password` = '{$pass}' AND `status` = 1 AND `permission` = 1");	
				if($user){
					Page::setRequest('username', $giasu, 'SESSION');
					Page::setRequest('password', $password, 'SESSION');
					Page::setRequest('IS_MANAGER_LOGIN', true, 'SESSION');	
				}
				
			}			
				$_POST['login'] = NULL;
		}	
			
		if (Page::getRequest('IS_MANAGER_LOGIN','def',false,'SESSION')) {								
			$giasu = trim(Page :: getRequest('username', 'str', NULL, 'SESSION'));
			$password = trim(Page :: getRequest('password', 'str', NULL, 'SESSION'));
			if($giasu != '' && $password!=''){
				$giasuObj = new DefaultGiasuPeer();	
				$pass = MD5($password);
				$user = $giasuObj->selectOne("giasu", 'giasu_id, username, firstname, lastname, avatar', "`username` = '{$giasu}' AND `password` = '{$pass}' AND `status` = 1");	
				if($user){
										
					$avatar = $user['avatar']!=NULL?$user['avatar']:"noavatar.gif";
					$quanly = Page::link(null,'base','manager');
					$avatarLink = Page::displayImage(CGS_AVATAR_PATH.'thumb'.DS.$avatar,"avatar","150","150");
					$logtemp = "<form method = 'POST' action = ''><center><table width='210px'>".
							"<tr><td><center>".$avatarLink."</center></td></tr>".
							"<tr><td colspan='2'><center><a style='color: blue;' href='".$quanly."'>Vào quản lý</a></center></td></tr>".
									"<tr><td><center>".
							"<input type='submit' name='logout' value='Đăng xuất'/><center></td>" .
							"</tr>".
							"</table></center></form>";
					
					$this->assign('logname',"Xin chào: <b>".$user['firstname']." ".$user['lastname']);
					$this->assign('logtemp', $logtemp);	
					$html = $this->output();
					return $html;
				}
			}
		}else{				
			$passwordForget = Page::link(null,'resetPassword','mc_web');	
			$regist = Page::link(null,'regTeach','mc_web');	
			$logtemp = "<form method = 'POST' action = ''><center><table width='210px'><tr>" .
					"<td style='text-align:left;'>Tên đăng nhập:</td>" .
					"<td><center><input type='text' id='username1' name ='username1' style='width:110px;'/></center></td>" .
					"</tr>" .
					"<tr>" .
					"<td style='text-align:left;'>Mật khẩu:</td>" .
					"<td><center><input type='password' id ='password1' name ='password1' style='width:110px;'></center></td>" .
					"</tr>" .
					"<tr>" .
					"<td colspan='2'><center><input type='submit' name='login' value='Đăng nhập'/> <input type='reset' name='reset' value='Nhập lại'/></center></td>" .
					"</tr><tr><td colspan='2'><center><a style='color: blue;' href='".$regist."'>Đăng ký</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a style='color: blue;' href='".$passwordForget."'>Quên mật khẩu</a></center></td></tr>".
					"</table></center></form>";
			
			$this->assign('logname', 'ĐĂNG NHẬP');
			$this->assign('logtemp', $logtemp);	
			$html = $this->output();
			return $html;
		}	
	}			
	
}