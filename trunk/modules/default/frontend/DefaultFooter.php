<?php
class DefaultFooter extends CgsModules
{
	function __construct(){
		
	}
	
	function execute(){
		$this->tpl(Page::pathTpl().'footer.htm');
		return $this->output();
	}

}