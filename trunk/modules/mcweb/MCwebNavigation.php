<?php
class MCwebNavigation extends CgsModules
{
	function __construct(){
		
	}
	
	function execute(){
		Page :: reg('js', Page :: pathMod() . 'MCwebNavigation.js');
		$page = Page :: getRequest('page','str','index', 'GET');
		
		$class1 = ($page=='index')?'current':'';
		$this->assign('index','class="'.$class1.'" ><a href='.Page::link(null,'index','mc_web'));
		
		$class2 = ($page=='intro')?'current':'';
		$this->assign('introduce','class="'.$class2.'" ><a href='.Page::link(null,'intro','mc_web'));
		
		$class4 = ($page=='help')?'current':'';
		$this->assign('help','class="'.$class4.'" ><a href='.Page::link(null,'help','mc_web'));
		
		$class5 = ($page=='NewDoc'||$page=='DocOfClass'||$page=='DocDetail'||$page=='uploadDoc'||$page=='yourdoc')?'current':'';
		$this->assign('tailieu','class="'.$class5.'" ><a href='.Page::link(null,'NewDoc','mc_web'));
		
		$this->tpl(Page::pathTpl().'MCwebNavigation.htm');
		return $this->output();
	}
}