<?php
class DefaultNavigation extends CgsModules
{
	function __construct(){
		
	}
	
	function execute(){
		$this->tpl(Page::pathTpl().'navigation.htm');
		return $this->output();
	}
}