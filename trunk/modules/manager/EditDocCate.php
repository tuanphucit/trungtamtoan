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
require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultDoccatePeer.php';


class EditDocCate  extends CgsModules {
	function __construct() {
	}

	function execute() {
		$id = Page :: getRequest('id', 'int', 0, 'GET');
		Page :: header('Sửa thông tin của danh mục tài liệu');
		if (Page::getRequest('IS_MANAGER_LOGIN','def',false,'SESSION')==false) {
			Page::goLink(null,'login','manager');
		}
		
		$Obj = new DefaultDoccatePeer();
		$dataSelected = $Obj->selectOne('doccate', '*', '`id` = ' . $id);
		$allCate = $Obj->select('doccate', '*', '`status` = 1');
		$form = new CgsFormsView('manager' . DS . 'EditDocCate.xml');
		$view = $form->getView('EditDocCateView');

		if (!empty ($dataSelected)) {
			$view->mapData($dataSelected, array (
				'name' => 'name',
				'description' => 'description',				
				'status' => 'status',
				'parentID' => 'parentID',
			));
		}
		$all = array(array('id'=>'0','name'=>'--danh mục cha---'));
		foreach($allCate as $cate){
			$all[] = $cate;
		}
		$view->setListData('parentID', $all, 'id,name');
		
		$this->assign('FORM_BEGIN', $view->getFormBegin());
		$this->assign('FORM_END', $view->getFormEnd());
		$this->assign('name', $view->getHtml('name'));
		$this->assign('id', $view->getHtml('id'));
		$this->assign('description', $view->getHtml('description'));
		$this->assign('status', $view->getHtml('status'));
		$this->assign('parentID', $view->getHtml('parentID'));
		
		$submit = Page :: getRequest('register', 'str', '', 'POST');
		$newName = '';
		if ($submit) {
			$name = Page :: getRequest('name', 'str', '', 'POST');
			$description = Page :: getRequest('description', 'str', '', 'POST');
			$id = Page :: getRequest('id', 'str', '', 'POST');
			$status = Page :: getRequest('status', 'str', '', 'POST');
			$parentID = Page :: getRequest('parentID', 'str', '0', 'POST');
			$data = array (
				'name' => $name,
				'description' => $description,
				'status' => $status,
				'parentID'=>$parentID,	
				'userupdate'=>Page::getRequest('username','str','','SESSION'),
				'updatetime'=> current(),			
			);
			if($id != 0){
				$Obj->updateId($id, $data);
			}else{
				$Obj->insert("doccate",$data);
			}
			$submit = null;
			Page::goLink(null,'ManagerDocCate','manager');
		}
		$html = $this->output();
		return $html;
	}
}