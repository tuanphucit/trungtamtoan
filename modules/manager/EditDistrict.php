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
require_once CGS_MODEL_PATH.'default'.DS.'DefaultLocationPeer.php';

class EditDistrict extends CgsModules {
	function __construct() {
	}

	function execute() {
		if (Page::getRequest('IS_MANAGER_LOGIN','def',false,'SESSION')==false) {
			Page::goLink(null,'login','manager');
		}
		if($_POST['submit']){
			$data = array ();
			$provinceID = Page :: getRequest('provinceID', 'int', 0, 'GET');			
			$location_id = Page :: getRequest('location_id', 'int', 0, 'POST');
			$data['name'] = Page :: getRequest('name', 'str', '', 'POST');
			$data['description'] = Page :: getRequest('description', 'str', '', 'POST');
			$data['status'] = Page :: getRequest('status','int' , '', 'POST');
			$data['username'] = Page::getRequest('username','str','','SESSION');
			$data['updatetime'] = current();
							
			$dbObj = new DefaultLocationPeer();
			$dbObj->updateId($location_id, $data);
			if($location_id == 0){
				$data['provinceID'] = $provinceID;
				$dbObj->insert("location",$data);
			}else{
				$dbObj->updateId($location_id, $data);	
			}	
			Page::goLink(array('id'=>$provinceID),'EditProvince','manager');
		}
		
		Page :: header('Chỉnh sửa quận/huyện');
		Page :: reg('js', Page :: pathMod() . 'EditProvice.js');
		
		$id = Page :: getRequest('location_id', 'int', 0, 'GET');
		$dbObj = new DefaultLocationPeer();
		$rs = $dbObj->getRow($id);
		$form = new CgsFormsView('manager' . DS . 'EditProvince.xml');
		$view = $form->getView('EditDistrictView');
		if (!empty ($rs)) {
			$view->mapData($rs, array (
				'location_id' => 'location_id',
				'provinceID' => 'provinceID',
				'name' => 'name',
				'description' => 'description',
				'status' => 'status',				
			));
		}else{
			$view->mapData(array('id'=>0), array (
				'id' => 'id'));
		}
		$view->setValidate(true);
		$this->assign('FORM_BEGIN', $view->getFormBegin());
		$this->assign('FORM_END', $view->getFormEnd());
		$this->assign('location_id', $view->getHtml('location_id'));
		$this->assign('provinceID', $view->getHtml('provinceID'));		
		$this->assign('name', $view->getHtml('name'));
		$this->assign('description', $view->getHtml('description'));
		$this->assign('status', $view->getHtml('status'));
		
		$html = $this->output();
		return $html;
	}
}