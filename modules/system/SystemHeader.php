<?php
/**
 * Header
 * @author longhoangvnn
 *
 */
class SystemHeader extends CgsModules{
	function __construct(){
		
	}
	
	function execute(){
		Page::reg('css', 'webskins/skins/system/styles/common.css');
		Page::reg('css', 'webskins/skins/system/styles/common-ext.css');
		Page::reg('css', 'webskins/skins/system/styles/icon.css');
		Page::reg('js', 'webskins/js/jquery-1.6.4.js');
		Page::reg('css', 'webskins/skins/platform/jquery.alerts/jquery.alerts.css');
		Page::reg('js', 'webskins/js/jquery.alerts.js','header');
		Page::reg('js', 'webskins/skins/system/js/func.js','footer');
		Page::reg('js', 'webskins/skins/system/js/common.js','footer');
		
		$this->tpl($this->pathTpl().'SystemHeader.htm');
		return $this->output();
	}
}