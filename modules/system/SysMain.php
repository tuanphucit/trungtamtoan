<?php
/**
 * Menu Left
 * @author longhoangvnn
 *
 */
class SysMain extends CgsModules{
	function __construct(){
		
	}
	
	function execute(){
		$this->tpl('system/sys_main.htm');
		return $this->output();
	}
}