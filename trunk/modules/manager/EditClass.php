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
require_once CGS_MODEL_PATH.'default'.DS.'DefaultClassPeer.php';

class EditClass extends CgsModules {
	function __construct() {
	}

	function execute() {
		if (Page::getRequest('IS_MANAGER_LOGIN','def',false,'SESSION')==false) {
			Page::goLink(null,'login','manager');
		}
		if($_POST['submit']){
			$data = array ();
			$id= Page :: getRequest('class_id', 'int', 0, 'POST');
			$data['name'] = Page :: getRequest('name', 'str', '', 'POST');
			$data['description'] = Page :: getRequest('description', 'str', '', 'POST');
			$data['status'] = Page :: getRequest('status','int' , '', 'POST');	
			$data['username'] = Page::getRequest('username','str','','SESSION');
			$data['updatetime'] = current();				
			$dbObj = new DefaultClassPeer();
			$dbObj->updateId($id, $data);
			if($id == 0){
				$dbObj->insert("class",$data);
			}else{
				$dbObj->updateId($id, $data);	
			}	
			Page::goLink(null,'ManageClass','manager');
		}
		
		Page :: header('Chỉnh sửa quận/huyện');
		Page :: reg('js', Page :: pathMod() . 'EditProvice.js');
		
		$id = Page :: getRequest('id', 'int', 0, 'GET');
		$dbObj = new DefaultClassPeer();
		$rs = $dbObj->getRow($id);
		$form = new CgsFormsView('manager' . DS . 'EditClass.xml');
		$view = $form->getView('EditClassView');
		if (!empty ($rs)) {
			$view->mapData($rs, array (
				'class_id' => 'class_id',
				'name' => 'name',
				'description' => 'description',
				'status' => 'status',				
			));
		}else{
			$view->mapData(array('class_id'=>0), array (
				'class_id' => 'class_id'));
		}
		$view->setValidate(true);
		$this->assign('FORM_BEGIN', $view->getFormBegin());
		$this->assign('FORM_END', $view->getFormEnd());
		$this->assign('class_id', $view->getHtml('class_id'));
		$this->assign('name', $view->getHtml('name'));
		$this->assign('description', $view->getHtml('description'));
		$this->assign('status', $view->getHtml('status'));
		
		$html = $this->output();
		return $html;
	}
}