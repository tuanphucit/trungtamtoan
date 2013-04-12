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

class MClog extends CgsModules {
	function __construct() {
	}

	function execute() {
		
		if($_POST['logout']!=NULL){
			Page::clearRequest('username','SESSION');
			Page::clearRequest('password', 'SESSION');	
			Page::clearRequest('IS_LOG_IN', 'SESSION');	
			$_POST['logout']= NULL;
		}
		Page::reg('css',CGS_WEBSKINS_PATH.'plugins/formValidator.2.2/css/validationEngine.jquery.css');
  		Page::reg('js',CGS_WEBSKINS_PATH.'plugins/formValidator.2.2/js/languages/jquery.validationEngine-vi2.js','footer');
  		Page::reg('js',CGS_WEBSKINS_PATH.'plugins/formValidator.2.2/js/jquery.validationEngine.js','footer');
  		Page::reg('js',CGS_WEBSKINS_PATH.'plugins/formValidator.2.2/js/contrib/other-validations.js','footer');
  		Page :: reg('js', Page :: pathMod() . 'MClog.js');
		
		if($_POST['login']!=NULL){
		$giasu = trim(Page :: getRequest('username1', 'str', NULL, 'POST'));
		$password = trim(Page :: getRequest('password1', 'str', NULL, 'POST'));
			if($giasu != '' && $password!=''){
				$giasuObj = new DefaultGiasuPeer();	
				$pass = MD5($password);
				$user = $giasuObj->selectOne("giasu", 'giasu_id, username, firstname, lastname, avatar, provinceID', "`username` = '{$giasu}' AND `password` = '{$pass}' AND `status` = 1");	
				if($user){
					Page::setRequest('username', $giasu, 'SESSION');
					Page::setRequest('zone', $user['provinceID'], 'SESSION');
					Page::setRequest('password', $password, 'SESSION');
					Page::setRequest('IS_LOG_IN', true, 'SESSION');	
				}
				
			}			
				$_POST['login'] = NULL;
		}	
			
		if (Page :: isLogIn()) {								
			$giasu = trim(Page :: getRequest('username', 'str', NULL, 'SESSION'));
			$password = trim(Page :: getRequest('password', 'str', NULL, 'SESSION'));
			if($giasu != '' && $password!=''){
				$giasuObj = new DefaultGiasuPeer();	
				$pass = MD5($password);
				$user = $giasuObj->selectOne("giasu", 'giasu_id, username, firstname, lastname, avatar', "`username` = '{$giasu}' AND `password` = '{$pass}' AND `status` = 1");	
				if($user){
										
					$avatar = $user['avatar']!=NULL?$user['avatar']:"noavatar.gif";
					$profileLink = Page::link(array('id'=>$user['giasu_id']),'profile','mc_web');
					$uploadLink = Page::link(null,'uploadDoc','mc_web');
					$yourDocLink = Page::link(array('id'=>$user['giasu_id']),'yourdoc','mc_web');
					$avatarLink = Page::displayImage(CGS_AVATAR_PATH.'thumb'.DS.$avatar,"avatar","250","200");
					$logtemp = "<div><form method = 'POST' action = ''><center><table width='210px'>".
							"<tr><td><center>".$avatarLink."</center></td></tr>".
							"<tr><td colspan='2'><center><a style='color: blue;' href='".$profileLink."'>Thông tin cá nhân</a></center></td></tr>".
									"<tr><td><center>".
							"<input type='submit' name='logout' value='Đăng xuất'/><center></td>" .
							"</tr>".
							"</table></center></form></div>" .
							"<div>
								<span class='headactions'></span>
								<h2><span>Quản lý tài liệu</span></h2>
								<ul id='menu_block_DB_Manager'>
								<li class=''><h3><a href='".$uploadLink."'>Tải tài liệu lên</a></h3></li>" .
								"<li class=''><h3><a href='".$yourDocLink."'>Tài liệu của bạn</a></h3></li>	
								</ul>
								";
					
					$this->assign('logname',"Xin chào: <b>".$user['firstname']." ".$user['lastname']);
					$this->assign('logtemp', $logtemp);	
					$html = $this->output();
					return $html;
				}
			}
		}else{				
			$passwordForget = Page::link(null,'resetPassword','mc_web');	
			$regist = Page::link(null,'regTeach','mc_web');	
			$logtemp = "<form method = 'POST' action = ''  id='userlogin'><center><table width='210px'><tr>" .
					"<td style='text-align:left;'>Tên đăng nhập:</td>" .
					"<td><center><input type='text' id='username1' name ='username1' style='width:110px;' class='validate[required,custom[onlyLetterNumber]]' /></center></td>" .
					"</tr>" .
					"<tr>" .
					"<td style='text-align:left;'>Mật khẩu:</td>" .
					"<td><center><input type='password' id ='password1' name ='password1' style='width:110px;' class='validate[required]'></center></td>" .
					"</tr>" .
					"<tr>" .
					"<td colspan='2'><center><input type='submit' name='login' id='login' value='Đăng nhập'/> <input type='reset' name='reset' value='Nhập lại'/></center></td>" .
					"</tr><tr><td colspan='2'><center><a style='color: blue;' href='".$regist."'>Đăng ký</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a style='color: blue;' href='".$passwordForget."'>Quên mật khẩu</a></center></td></tr>".
					"</table></center></form>";
			
			$this->assign('logname', 'Đăng nhập');
			$this->assign('logtemp', $logtemp);	
			$html = $this->output();
			return $html;
		}	
	}			
	
}