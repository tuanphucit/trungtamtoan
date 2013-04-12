<?php
/**
 * 
 * @author longhoangvnn
 *
 */
class CodegenHeader extends CgsModules {
	function __construct() {
		
	}
	
	function execute() {
		$this->assign('abc','hello');
		return $this->output();
	}
}