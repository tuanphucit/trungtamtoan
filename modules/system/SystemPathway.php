<?php
/**
 * Menu Left
 * @author longhoangvnn
 *
 */
class SystemPathway extends CgsModules{
	function __construct(){
		
	}
	
	function execute(){
		$this->tpl('system/SystemPathway.htm');
		return $this->output();
	}
}