<?php
/**
 * Menu Left
 * @author longhoangvnn
 *
 */
class SystemNavigation extends CgsModules{
	function __construct(){
		
	}
	
	function execute(){
		$this->assign('link_admin', Page::link(null,'index','admin'));
		$this->assign('link_system', Page::link(null,'index','system'));
		$this->assign('link_logout', Page::link(null,'logout','system'));
		return $this->output();
	}
}