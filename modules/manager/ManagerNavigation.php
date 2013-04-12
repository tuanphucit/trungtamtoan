<?php
class ManagerNavigation extends CgsModules
{
	function __construct(){
		
	}
	
	function execute(){		
		$this->assign('goMainWeb', Page::link(null,'index','mc_web'));
		$this->tpl(Page::pathTpl().'ManagerNavigation.htm');
		return $this->output();
	}
}