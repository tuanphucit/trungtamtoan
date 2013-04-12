<?php
class MCpromotion extends CgsModules
{
	function __construct(){
		
	}
	
	function execute(){
		$promotion = Page::displayImage(CGS_IMAGES_DATA.'promotion'.DS.'khamphabian.png',"promotion1","140","205");
		$this->assign('promotion',$promotion);
		$this->tpl(Page::pathTpl().'MCpromotion.htm');
		return $this->output();
	}
}