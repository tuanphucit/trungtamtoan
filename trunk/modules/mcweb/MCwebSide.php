<?php
class MCwebSide extends CgsModules
{
	function __construct(){
		
	}
	
	function execute(){
		$this->assign('regTeach', Page::link(null,'regTeach','mc_web'));
		$this->assign('regLearn', Page::link(null,'regLearn','mc_web'));
		$this->assign('listTeacher', Page::link(null,'listTeacher','mc_web'));
		$this->assign('listTeacherb', Page::link(null,'listTeacherb','mc_web'));
		$this->assign('listClass', Page::link(null,'listClass','mc_web'));
		$this->assign('index', Page::link(null,'index','mc_web'));		
			
		$this->tpl(Page::pathTpl().'MCwebSide.htm');
		return $this->output();
	}
}