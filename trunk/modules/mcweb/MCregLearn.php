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
require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultHocsinhPeer.php';
require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultLocationPeer.php';
require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultSessionsPeer.php';
require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultProvincePeer.php';


class MCregLearn extends CgsModules {
	
	private $messageArray = array();
	
	function __construct() {
	}

	function execute() {
		Page :: header('Đăng ký tìm gia sư');
		Page :: reg('js', Page :: pathMod() . 'MCregLearn.js');
		Page::reg('css',CGS_WEBSKINS_PATH.'plugins/formValidator.2.2/css/validationEngine.jquery.css');
  		Page::reg('js',CGS_WEBSKINS_PATH.'plugins/formValidator.2.2/js/languages/jquery.validationEngine-vi2.js','footer');
  		Page::reg('js',CGS_WEBSKINS_PATH.'plugins/formValidator.2.2/js/jquery.validationEngine.js','footer');
  		Page::reg('js',CGS_WEBSKINS_PATH.'plugins/formValidator.2.2/js/contrib/other-validations.js','footer');
		
		$zone = Page :: getRequest('zone', 'str', '0', 'SESSION');	
		$this->createLoctionForm($zone);	
		
		$classObj = new DefaultClassPeer();
		$allClass = $classObj->select("class", "class_id,name","`status` = 1","name ASC");		
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

		$form = new CgsFormsView('mcweb' . DS . 'MCwebPupil.xml');
		$view = $form->getView('MCwebPupilView');
		$view->setValidate(false);
		
		$view->setListData('location', $allLocal, 'location_id,name');
		$view->setListData('class_id', $allClass, 'class_id,name');
		$view->setListData('sessions', $newAllSessions, 'session_id,session');
	

		$submit = Page :: getRequest('register', 'str', '', 'POST');
		if ($submit) {
			$mothername = Page :: getRequest('mothername', 'str', '', 'POST');
			$giasu_gender = Page :: getRequest('giasu_gender', 'str', '', 'POST');
			$gender = Page :: getRequest('gender', 'str', '', 'POST');
			$starttime = Page :: getRequest('starttime', 'str', '', 'POST');
			$email = Page :: getRequest('email', 'str', '', 'POST');
			$mobile = Page :: getRequest('mobile', 'str', '', 'POST');
			$address = Page :: getRequest('address', 'str', '', 'POST');
			$location_id = Page :: getRequest('location', 'int', '', 'POST');
			$level = Page :: getRequest('level', 'str', '', 'POST');
			$class_id = Page :: getRequest('class_id', 'str', '', 'POST');
			$pupilnumber = Page :: getRequest('pupilnumber', 'str', '', 'POST');
			$fee = Page :: getRequest('fee', 'str', '', 'POST');
			$introduction = Page :: getRequest('introduction', 'str', '', 'POST');
			$duringtime = Page :: getRequest('duringtime', 'str', '', 'POST');
			$sessions = implode(',', Page :: getRequest('sessions', 'str', '', 'POST'));
			$isNeedGoodTeacher = Page :: getRequest('isNeedGoodTeacher', 'int', '1', 'POST');
			$hocsinhObj = new DefaultHocsinhPeer();
	
			$data = array (
				'mothername' => $mothername,
				'starttime' => Date('Y-m-d H:i:s', strtotime($starttime)),
				'expected_gender' => $giasu_gender,
				'pupilnumber' => $pupilnumber,
				'gender' => $gender,
				'email' => $email,
				'mobile' => $mobile,
				'address' => $address,
				'location_id' => $location_id,
				'createtime' => Date('Y-m-d H:i:s', time()),
				'class_id' => $class_id,
				'expected_fee' => $fee,
				'expected_level' => $level,
				'duringtime' => $duringtime,
				'introduction' => $introduction,
				'teach_sessions' => $sessions,
				'provinceID'=>$zone,
				'isNeedGoodTeacher'=>$isNeedGoodTeacher,				
			);
			
			if($this->validateData($data)){
				$insert = $hocsinhObj->insert("hocsinh", $data);	
				if($insert){
					Page::goLink(null,'listClass','mc_web');
				}	
			}else{
				$view->mapData($data, array (
				'mothername' => 'mothername',
				'starttime' => 'starttime',
				'pupilnumber' => 'pupilnumber',
				'gender' => 'gender',
				'email' => 'email',
				'mobile' => 'mobile',
				'address' => 'address',
				'class_id' => 'class_id',
				'fee' => 'expected_fee',
				'expected_level' => 'expected_level',
				'duringtime' => 'duringtime' ,
				'introduction' => 'introduction',
				'provinceID'=>'provinceID',
				'isNeedGoodTeacher'=>'isNeedGoodTeacher',			
				));			
				$view->mapListData('sessions',$data['teach_sessions'], '');
				$view->mapListData('location', $data['location_id'], '');
				$view->mapListData('giasu_gender', $data['expected_gender'], '');
				$view->mapListData('pupilnumber', $data['pupilnumber'], '');	
				$view->mapListData('gender', $data['gender'], '');	
				$view->mapListData('level', $data['expected_level'], '');				
			}					
		}

		$this->assign('mothername_error', $this->messageArray['mothername']);
		$this->assign('mobile_error', $this->messageArray['mobile']);
		$this->assign('location_id_error', $this->messageArray['location_id']);
		$this->assign('email_error', $this->messageArray['email']);
		$this->assign('address_error', $this->messageArray['address']);
			
		$this->assign('FORM_BEGIN', $view->getFormBegin());
		$this->assign('FORM_END', $view->getFormEnd());
		$this->assign('mothername', $view->getHtml('mothername'));
		$this->assign('pupilname', $view->getHtml('pupilname'));
		$this->assign('gender', $view->getHtml('gender'));
		$this->assign('giasu_gender', $view->getHtml('giasu_gender'));
		$this->assign('starttime', $view->getHtml('starttime'));
		$this->assign('email', $view->getHtml('email'));
		$this->assign('mobile', $view->getHtml('mobile'));
		$this->assign('address', $view->getHtml('address'));
		$this->assign('location', $view->getHtml('location'));
		$this->assign('sessions', $view->getHtml('sessions'));
		$this->assign('level', $view->getHtml('level'));
		$this->assign('class_id', $view->getHtml('class_id'));
		$this->assign('pupilnumber', $view->getHtml('pupilnumber'));
		$this->assign('fee', $view->getHtml('fee'));
		$this->assign('duringtime', $view->getHtml('duringtime'));
		$this->assign('introduction', $view->getHtml('introduction'));
		$this->assign('isNeedGoodTeacher', $view->getHtml('isNeedGoodTeacher'));
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
	
	private function validateData($data = array()){
		$flag = true;
		if(trim($data['mothername']) == null || trim($data['mothername']) == ''){
			$this->messageArray['mothername'] = 'Bạn chưa nhập tên phụ huynh';
			$flag = false;
		}
		if(trim($data['address']) == null || trim($data['address']) == ''){
			$this->messageArray['address'] = 'Chưa nhập địa chỉ liên hệ';
			$flag = false;
		}
		if($data['starttime'] == '0000-00-00 00:00:00'){
			$this->messageArray['starttime'] = 'Thời gian bắt đầu không hợp lệ';
			$flag = false;
		}
		if (!preg_match('/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/',$data['email'])){
			$this->messageArray['email'] = 'Email không hợp lệ';
			$flag = false;
		}
		if(!preg_match('/^\(?[0-9]{3}\)?|[0-9]{3}[-. ]? [0-9]{3}[-. ]?[0-9]{4}$/', $data['mobile'])){
			$this->messageArray['mobile'] = 'mobile không hợp lệ';
			$flag = false;
		}
		if((int)$data['location_id'] == 0){
			$this->messageArray['location_id'] = 'Quận(huyện) không hợp lệ';
			$flag = false;
		}
		if((int)$data['provinceID'] == 0){
			$this->messageArray['provinceID'] = 'Khu vực không hợp lệ';
			$flag = false;
		}
		return $flag;
	}
}