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
require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultClassPeer.php';
require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultGiasuPeer.php';
require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultLocationPeer.php';
require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultSessionsPeer.php';

class MCprofileTeacher extends CgsModules {
	function __construct() {
	}

	function execute() {
		$id = Page :: getRequest('id', 'int', 0, 'GET');
		Page :: header('Thông tin cá nhân');
		Page :: reg('js', Page :: pathMod() . 'MCprofileTeacher.js');
		Page::reg('css',CGS_WEBSKINS_PATH.'plugins/formValidator.2.2/css/validationEngine.jquery.css');
  		Page::reg('js',CGS_WEBSKINS_PATH.'plugins/formValidator.2.2/js/languages/jquery.validationEngine-vi2.js','footer');
  		Page::reg('js',CGS_WEBSKINS_PATH.'plugins/formValidator.2.2/js/jquery.validationEngine.js','footer');
  		Page::reg('js',CGS_WEBSKINS_PATH.'plugins/formValidator.2.2/js/contrib/other-validations.js','footer');
		
		
		if (!Page :: isLogIn()) {
			Page :: goLink(null, 'index', 'mc_web');
		}		
		$giasuObj = new DefaultGiasuPeer();
		$dataSelected = $giasuObj->selectOne('giasu', '*', '`giasu_id` = ' . $id);
		
		$classObj = new DefaultClassPeer();
		$allClass = $classObj->select("class", "class_id,name", "`status` = 1", "name DESC");
		$localObj = new DefaultLocationPeer();
		$zone = $dataSelected['provinceID'];
		$allLocal = $localObj->select("location", "location_id,name", "`status` = 1 AND `provinceID` = {$zone}", "name ASC");
		$sessionlObj = new DefaultSessionsPeer();
		$allSessions = $sessionlObj->select("sessions", "sessions_id,session,day", "", "sessions_id ASC");
		$newAllSessions = array ();
		foreach ($allSessions as $session) {
			$newAllSessions[] = array (
				'session_id' => $session['sessions_id'],
				'session' => $session['session'] . " " . $session['day']
			);
		}

		$form = new CgsFormsView('mcweb' . DS . 'MCwebTeacher.xml');
		$view = $form->getView('MCwebTeacherView');
		$view->setValidate(true);


		$view->setListData('location', $allLocal, 'location_id,name');
		$view->setListData('classes', $allClass, 'class_id,name');
		$view->setListData('sessions', $newAllSessions, 'session_id,session');
		$view->setListData('teachat', $allLocal, 'location_id,name');
		if (!empty ($dataSelected)) {
			$view->mapData($dataSelected, array (
				'username' => 'username',
				'firstname' => 'firstname',
				'lastname' => 'lastname',
				'avatarLink' => 'avatar',
				'gender' => 'gender',
				'email' => 'email',
				'mobile' => 'mobile',
				'address' => 'address',
				'level' => 'level',
				'school' => 'school',
				'location' => 'location_id',
				'fee' => 'expected_fee',
				'faculty' => 'faculty',
				'introduction' => 'introduction',	
				'isNeedValid'=>'isNeedValid',			
			));
			
			$view->mapData(array('birthday' => Date('d-m-Y', strtotime($dataSelected['birthday']))),array('birthday'=>'birthday'));			
			$view->mapListData('sessions', $dataSelected['teach_sessions'], '');
			$view->mapListData('classes', $dataSelected['teach_classes'], '');
			$view->mapListData('teachat', $dataSelected['teach_locations'], '');
		}

		$this->assign('message', "");
		$this->assign('FORM_BEGIN', $view->getFormBegin(array (
			'enctype' => "multipart/form-data"
		)));
		$this->assign('FORM_END', $view->getFormEnd());
		$this->assign('username', $dataSelected['username']);
		$this->assign('avatar', '<input type="file" name="avatarLink" id="avatarLink" accept="image/*" size="30"/>');
		$this->assign('birthday', $view->getHtml('birthday'));
		$this->assign('gender', $view->getHtml('gender'));
		$this->assign('firstname', $view->getHtml('firstname'));
		$this->assign('lastname', $view->getHtml('lastname'));
		$this->assign('email', $view->getHtml('email'));
		$this->assign('mobile', $view->getHtml('mobile'));
		$this->assign('address', $view->getHtml('address'));
		$this->assign('location', $view->getHtml('location'));
		$this->assign('classes', $view->getHtml('classes'));
		$this->assign('sessions', $view->getHtml('sessions'));
		$this->assign('teachat', $view->getHtml('teachat'));
		$this->assign('level', $view->getHtml('level'));
		$this->assign('school', $view->getHtml('school'));
		$this->assign('faculty', $view->getHtml('faculty'));
		$this->assign('fee', $view->getHtml('fee'));
		$this->assign('introduction', $view->getHtml('introduction'));
		$this->assign('isNeedValid', $view->getHtml('isNeedValid'));
		
		
		$linkchangePassword = Page::link(null,'changePass','mc_web');
		$this->assign('changePassword','<a style="color: blue;" href="'.$linkchangePassword.'">Đổi mật khẩu</a>');
		$submit = Page :: getRequest('register', 'str', '', 'POST');
		$newName = '';
		if ($submit) {
			$avatarLink = Page :: getRequest('avatarLink', 'def', null, 'FILE');
			if ($avatarLink['size'] != 0) {			
				$type = explode(".", $avatarLink["name"]);
				$type = $type[count($type)-1];
				$newName = $id."_".time().".".$type;
				move_uploaded_file($avatarLink["tmp_name"], CGS_AVATAR_PATH.$newName);
				CgsFunc::createThumbs(CGS_AVATAR_PATH.$newName,CGS_AVATAR_PATH.'thumb',500);
				unlink(CGS_AVATAR_PATH.'thumb'.DS.$dataSelected['avatar']);
				unlink(CGS_AVATAR_PATH .$newName);
			}

			$birthday = Page :: getRequest('birthday', 'str', '', 'POST');
			$gender = Page :: getRequest('gender', 'str', '', 'POST');
			$firstname = Page :: getRequest('firstname', 'str', '', 'POST');
			$lastname = Page :: getRequest('lastname', 'str', '', 'POST');
			$email = Page :: getRequest('email', 'str', '', 'POST');
			$mobile = Page :: getRequest('mobile', 'str', '', 'POST');
			$address = Page :: getRequest('address', 'str', '', 'POST');
			$location_id = Page :: getRequest('location', 'int', '', 'POST');
			$address = Page :: getRequest('address', 'str', '', 'POST');
			$level = Page :: getRequest('level', 'str', '', 'POST');
			$school = Page :: getRequest('school', 'str', '', 'POST');
			$faculty = Page :: getRequest('faculty', 'str', '', 'POST');
			$fee = Page :: getRequest('fee', 'str', '', 'POST');
			$introduction = Page :: getRequest('introduction', 'str', '', 'POST');
			$classes = implode(',', Page :: getRequest('classes', 'str', '', 'POST'));
			$sessions = implode(',', Page :: getRequest('sessions', 'str', '', 'POST'));
			$teachat = implode(',', Page :: getRequest('teachat', 'str', '', 'POST'));
			$isNeedValid = Page :: getRequest('isNeedValid', 'int', '0', 'POST');
			
			$data = array (
				'birthday' => Date('Y-m-d H:i:s', strtotime($birthday)),
				'firstname' => $firstname,
				'lastname' => $lastname,
				'gender' => $gender,
				'email' => $email,
				'mobile' => $mobile,
				'address' => $address,
				'location_id' => $location_id,
				'updatetime' => Date('Y-m-d H:i:s', time()),
				'level' => $level,
				'school' => $school,
				'expected_fee' => $fee,
				'faculty' => $faculty,
				'introduction' => $introduction,
				'teach_sessions' => $sessions,
				'teach_classes' => $classes,
				'teach_locations' => $teachat,
				'isNeedValid'=>$isNeedValid,
							
			);
			if($newName != ''){
				$data['avatar'] = $newName;
			}
			$update = $giasuObj->updateId($id, $data);
			$submit = null;
			if($update){
				if($dataSelected['validate'] == 1)
					Page::goLink(null,'listTeacher','mc_web');
				else
					Page::goLink(null,'listTeacherb','mc_web');				
			}	
		}
		$html = $this->output();
		return $html;
	}
}