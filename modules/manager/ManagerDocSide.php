<?php
class ManagerDocSide extends CgsModules
{
	function __construct(){
		
	}
	
	function execute(){
		if (Page::getRequest('IS_MANAGER_LOGIN','def',false,'SESSION')==false) {
			Page::goLink(null,'login','manager');
		}
		Page::header('Quản trị Tài liệu');
		$this->assign('ManageDocCate', Page::link(null,'ManagerDocCate','manager'));	
		$this->assign('ManageAllDoc', Page::link(null,'ManageAllDoc','manager'));	
		$this->tpl(Page::pathTpl().'ManagerDocSide.htm');	
		return $this->output();
	}
}