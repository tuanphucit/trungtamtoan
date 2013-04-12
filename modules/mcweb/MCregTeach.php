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
require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultProvincePeer.php';

class MCregTeach extends CgsModules {
	function __construct() {
	}

	function execute() {
		Page :: header('Đăng ký làm gia sư');
		Page :: reg('js', Page :: pathMod() . 'MCregTeach.js');
		Page::reg('css',CGS_WEBSKINS_PATH.'plugins/formValidator.2.2/css/validationEngine.jquery.css');
  		Page::reg('js',CGS_WEBSKINS_PATH.'plugins/formValidator.2.2/js/languages/jquery.validationEngine-vi2.js','footer');
  		Page::reg('js',CGS_WEBSKINS_PATH.'plugins/formValidator.2.2/js/jquery.validationEngine.js','footer');
  		Page::reg('js',CGS_WEBSKINS_PATH.'plugins/formValidator.2.2/js/contrib/other-validations.js','footer');
		
		$zone = Page :: getRequest('zone', 'str', '0', 'SESSION');	
		$this->createLoctionForm($zone);	
		
		$classObj = new DefaultClassPeer();
		$allClass = $classObj->select("class", "class_id,name","`status` = 1","class_id ASC");		
		$localObj = new DefaultLocationPeer();
		$allLocal = $localObj->select("location", "location_id,name","`status` = 1 AND `provinceID` = {$zone}","name ASC");
		$sessionlObj = new DefaultSessionsPeer();
		$allSessions = $sessionlObj->select("sessions", "sessions_id,session,day","","sessions_id ASC");
		$newAllSessions = array ();
		foreach ($allSessions as $session) {
			$newAllSessions[] = array (
				'session_id' => $session['sessions_id'],
				'session' => $session['session'] . " " . $session['day']
			);
		}

		$form = new CgsFormsView('mcweb' . DS . 'MCwebTeacher.xml');
		$view = $form->getView('MCwebTeacherView');
		$view->setValidate(false);
		$view->setListData('location', $allLocal, 'location_id,name');
		$view->setListData('classes', $allClass, 'class_id,name');
		$view->setListData('sessions', $newAllSessions, 'session_id,session');
		$view->setListData('teachat', $allLocal, 'location_id,name');
		$this->assign('message', "");
		$this->assign('FORM_BEGIN', $view->getFormBegin());
		$this->assign('FORM_END', $view->getFormEnd());
		$this->assign('username', $view->getHtml('username'));
		$this->assign('password', $view->getHtml('password'));
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

		$submit = Page :: getRequest('register', 'str', '', 'POST');
		if ($submit) {
			$username = Page :: getRequest('username', 'str', '', 'POST');
			$password = MD5(Page :: getRequest('password', 'str', '', 'POST'));
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
			$giasuObj = new DefaultGiasuPeer();
	
			$data = array (
				'username' => $username,
				'password' => $password,
				'birthday' => Date('Y-m-d H:i:s', strtotime($birthday)),
				'firstname' => $firstname,
				'lastname' => $lastname,
				'gender' => $gender,
				'email' => $email,
				'mobile' => $mobile,
				'address' => $address,
				'location_id' => $location_id,
				'createtime' => Date('Y-m-d H:i:s', time()),
				'level' => $level,
				'school' => $school,
				'expected_fee' => $fee,
				'faculty' => $faculty,
				'introduction' => $introduction,
				'teach_sessions' => $sessions,
				'teach_classes' => $classes,
				'teach_locations' => $teachat,
				'provinceID'=>$zone,
				'isNeedValid'=>$isNeedValid,				
			);
			$insert = $giasuObj->insert("giasu", $data);	
			if($insert){
				if($data['email']!=''){
					include_once (CGS_LIB_PATH.'sendmail/class.tttmail.php');
					$htmlcontent = "Chào bạn ".$data['lastname'].", <br>" .
									"Chúc mừng bạn đã trở thành thành viên của TRUNG TÂM TOÁN!" .
									" TRUNG TÂM TOÁN sẽ liên hệ với bạn sớm nhất khi có lớp phù hợp với bạn, " .
									" hoặc bạn có thể vào DANH SÁCH HỌC SINH để tìm lớp phù hợp." .
									" Trung tâm rất mong nhận được sự ủng hộ của các bạn với trung tâm bằng việc giới thiệu cho bạn bè," .
									" chia sẻ tài liệu trên website của trung tâm," .
									" cùng góp phần giúp nền toán học nước nhà phát triển!<br><br>" .
									"Trân trọng cám ơn!<br>" .
									"<a href='trungtamtoan.com'>Trung Tâm Toán<a>";
					$mail = new TrungTamToanMail();
					$status = $mail->sendMail('trungtamtoan', $data['email'], NULL, "Thong bao dang ky thanh cong", $htmlcontent, null);
				}	
				Page::goLink(null,'listTeacherb','mc_web');
			}			
		}

		$html = $this->output();
		return $html;
	}
	
	private function createLoctionForm($zone){
		$provinceObj = new DefaultProvincePeer();
		$allprovince 	= $provinceObj->getListAll('*');
		$form = new CgsFormsView('mcweb' . DS . 'MCgetLocation.xml');
		$view = $form->getView('MCgetLocationInPage');
		$view->setListData('provinceChange', $allprovince, 'id,name');
		$view->mapListData('provinceChange', $zone, '');
		$this->assign('provinceName',"Khu vực: ".$view->getHtml('provinceChange'));
	}
}