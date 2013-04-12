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

class EditHocsinh extends CgsModules {
	function __construct() {
	}

	function execute() {
		$id = Page :: getRequest('id', 'int', 0, 'GET');
		Page :: header('Sửa thông tin của học sinh');
		if (Page::getRequest('IS_MANAGER_LOGIN','def',false,'SESSION')==false) {
			Page::goLink(null,'login','manager');
		}
		
		$hocsinhObj = new DefaultHocsinhPeer();
		$dataSelected = $hocsinhObj->selectOne('hocsinh', '*', '`hocsinh_id` = ' . $id);
		
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

		$form = new CgsFormsView('manager' . DS . 'MCwebPupil.xml');
		$view = $form->getView('MCwebPupilView');
		$view->setValidate(true);

		$view->setListData('class_id', $allClass, 'class_id,name');
		$view->setListData('sessions', $newAllSessions, 'session_id,session');
		$view->setListData('location', $allLocal, 'location_id,name');
		
		if (!empty ($dataSelected)) {
			$view->mapData($dataSelected, array (
				'mothername' => 'mothername',
				'starttime' => 'starttime',
				'expected_gender' => 'expected_gender',
				'pupilnumber' => 'pupilnumber',
				'gender' => 'gender',
				'email' => 'email',
				'mobile' => 'mobile',
				'address' => 'address',
				'createtime' => 'createtime',
				'expected_fee' => 'expected_fee',
				'expected_level' => 'expected_level',
				'duringtime' => 'duringtime',
				'introduction' => 'introduction',
				'status' => 'status',	
				'isNeedGoodTeacher'=>'isNeedGoodTeacher',
			));
			$view->mapListData('sessions', $dataSelected['teach_sessions'], '');
			$view->mapListData('class_id', $dataSelected['class_id'], '');
			$view->mapListData('location', $dataSelected['location_id'], '');
		}

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
		$this->assign('status', $view->getHtml('status'));
		$this->assign('isNeedGoodTeacher', $view->getHtml('isNeedGoodTeacher'));
		$submit = Page :: getRequest('register', 'str', '', 'POST');
		$newName = '';
		
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
			$status = Page :: getRequest('status', 'str', '', 'POST');
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
				'status'=>$status,	
				'userupdate' => Page::getRequest('username','str','','SESSION'),
				'isNeedGoodTeacher'=>$isNeedGoodTeacher,								
			);
			$hocsinhObj->updateId($id, $data);
			$submit = null;
			Page::goLink(null,'pupil','manager');
		}
		$html = $this->output();
		return $html;
	}
}