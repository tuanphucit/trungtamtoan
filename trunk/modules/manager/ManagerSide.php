<?php
class ManagerSide extends CgsModules
{
	function __construct(){
		
	}
	
	function execute(){
		if (Page::getRequest('IS_MANAGER_LOGIN','def',false,'SESSION')==false) {
			Page::goLink(null,'login','manager');
		}
		Page::header('Quản trị MC web');
		$this->assign('manageProvince', Page::link(null,'province','manager'));
		$this->assign('manageArticle', Page::link(null,'article','manager'));
		$this->assign('manageGiasu', Page::link(null,'teacher','manager'));
		$this->assign('manageHocsinh', Page::link(null,'pupil','manager'));
		$this->assign('manageComment', Page::link(null,'comment','manager'));		
		$this->assign('manageAvatar', Page::link(null,'ManagerAvatar','manager'));	
		$this->assign('manageCategory', Page::link(null,'ManageCategory','manager'));
		$this->assign('manageClass', Page::link(null,'ManageClass','manager'));	
		$this->tpl(Page::pathTpl().'ManagerSide.htm');	
		return $this->output();
	}
}