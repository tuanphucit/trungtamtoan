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
require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultProvincePeer.php';
require_once CGS_MODEL_PATH.'default'.DS.'DefaultLocationPeer.php';

class EditProvince extends CgsModules {
	function __construct() {
	}

	function execute() {
		if (Page::getRequest('IS_MANAGER_LOGIN','def',false,'SESSION')==false) {
			Page::goLink(null,'login','manager');
		}
		
		if($_POST['submit']){
			$data = array ();
			$id = Page :: getRequest('id', 'int', 0, 'POST');
			$data['name'] = Page :: getRequest('name', 'str', '', 'POST');
			$data['description'] = Page :: getRequest('description', 'str', '', 'POST');
			$data['locate'] = Page :: getRequest('locate', 'str', '', 'POST');
			$data['status'] = Page :: getRequest('status','int' , '', 'POST');
			$data['username']= Page::getRequest('username','str','','SESSION');
			$data['updatetime']=  current();
				
			$dbObj = new DefaultProvincePeer();
			if($id == 0){
				$dbObj->insert("province",$data);
				Page::goLink(null,'province','manager');
			}else{
				$dbObj->updateId($id, $data);	
			}
		}
		
		Page :: header('Chỉnh sửa tỉnh thành');
		Page :: reg('js', Page :: pathMod() . 'EditProvice.js');
		
		$id = Page :: getRequest('id', 'int', 0, 'GET');
		$dbObj = new DefaultProvincePeer();
		$rs = $dbObj->getRow($id);
		$form = new CgsFormsView('manager' . DS . 'EditProvince.xml');
		$view = $form->getView('EditProvinceView');
		if (!empty ($rs)) {
			$view->mapData($rs, array (
				'id' => 'id',
				'name' => 'name',
				'description' => 'description',
				'locate' => 'locate',
				'status' => 'status',				
			));
		}else{
			$view->mapData(array('id'=>0), array (
				'id' => 'id'));
		}
		$view->setValidate(true);
		$this->assign('FORM_BEGIN', $view->getFormBegin());
		$this->assign('FORM_END', $view->getFormEnd());
		$this->assign('id', $view->getHtml('id'));
		$this->assign('name', $view->getHtml('name'));
		$this->assign('description', $view->getHtml('description'));
		$this->assign('locate', $view->getHtml('locate'));
		$this->assign('status', $view->getHtml('status'));
		
		//danh sach huyen cua tinh
		$dbObjLocation = new DefaultLocationPeer();
		$allDistricts = $dbObjLocation->select('location', '*', "`provinceID` = {$id}", 'location_id ASC');
		$this->block('BlockList');
		$stt = 1;
		foreach ($allDistricts as $row){
			
			$this->assign('stt', $stt);
			$this->assign('districtID', $row['location_id']);
			$this->assign('DistrictStatus', ($row['status']==0?'Ẩn':'Hiện'));
			$this->assign('DistrictName', $row['name']);
			$this->assign('DistrictUsername', $row['username']);
			$this->assign('DistrictUpdate', $row['updatetime']);			
			$this->assign('detail_link', Page::link(array('location_id'=>$row['location_id'],'provinceID'=>$row['provinceID']),'EditDistrict','manager'));
			$this->add_block('BlockList');
			$stt++;
		}
		$this->assign('newDistrict', Page::link(array('location_id'=>0,'provinceID'=>$id),'EditDistrict','manager'));
		
		$html = $this->output();
		return $html;
	}
}