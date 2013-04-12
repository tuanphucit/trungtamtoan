<?php
class DefaultSide extends CgsModules
{
	function __construct(){
		
	}
	
	function execute(){
		$this->tpl(Page::pathTpl().'side.htm');
		return $this->output();
	}
}