<?php
class DefaultHeader extends CgsModules
{
	function __construct(){
		
	}
	
	function execute(){
		
		$this->tpl(Page::pathTpl().'header.htm');
		$avatarLink = Page::displayImage(CGS_AVATAR_PATH."mathlogo.gif","avatar","100","400");
		$this->assign('mathlogo',$avatarLink);		
		Page::reg('css', 'webskins/skins/default/main/styles/common.css');
		Page::reg('css', 'webskins/skins/default/main/styles/common-ext.css');
		Page::reg('js', 'webskins/js/jquery-1.7.2.js');
		Page::reg('css', 'webskins/skins/platform/jquery.alerts/jquery.alerts.css');
			Page :: reg('js', Page :: pathMod() . 'DefaultHeader.js');	
		Page::reg('js', 'webskins/js/jquery.alerts.js','footer');
		return $this->output();
	}
}