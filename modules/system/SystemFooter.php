<?php
/**
 * Footer
 * @author longhoangvnn
 *
 */
class SystemFooter extends CgsModules{
	function __construct(){
		
	}
	
	function execute(){
		//Page::reg('js', 'webskins/skins/platform/js/jquery.lazyload.js', 'footer');
		Page::reg('js', 'webskins/js/validate-form.js', 'footer');
		$this->tpl('system/SystemFooter.htm');
		return $this->output();
	}
}