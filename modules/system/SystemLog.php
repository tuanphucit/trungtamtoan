<?php
/**
 * @desc			
 * @author 			HoangNV<longhoangvnn@gmail.com> 
 * @package 		modules
 * @subpackage 		system
 * @version 		Id: SystemLog.php v1.0 2011/07/23 hoangnv
 * @since 			CGS v 2.0
 * @copyright 		CGS.,JSC (c) 2011
 */
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );
require_once CGS_SYSTEM_PATH.'system.forms.view.php';
class SystemLog extends CgsModules{
	function __construct(){
		
	}
	
	function execute(){
		Page::reg('js', Page::pathMod().'SystemLog.js');
		
		$form = new CgsFormsView('system'.DS.'SystemSetting.xml');
		$view = $form->getView('SystemLogView');
		$this->assign('FORM_BEGIN', $view->getFormBegin());
		$this->assign('FORM_END', 	$view->getFormEnd());
		$this->assign('log_btn_OK', 	$view->getHtml('log_btn_OK'));
		$this->assign('log_btn_RESET', 	$view->getHtml('log_btn_RESET'));
		
		// Set value default
		$view->set('log_enable',		CgsGlobal::getSetting('LOG_ENABLE'));
		$view->set('log_error',			CgsGlobal::getSetting('LOG_ERROR'));
		$view->set('log_sql',			CgsGlobal::getSetting('LOG_SQL'));
		$view->set('log_sql_view',		CgsGlobal::getSetting('LOG_SQL_VIEW'));
		$view->set('log_sql_add',		CgsGlobal::getSetting('LOG_SQL_ADD'));
		$view->set('log_sql_edit',		CgsGlobal::getSetting('LOG_SQL_EDIT'));
		$view->set('log_sql_delete',	CgsGlobal::getSetting('LOG_SQL_DELETE'));
		$view->set('log_sql_other',		CgsGlobal::getSetting('LOG_SQL_OTHER'));
		$view->set('log_sql_slow',		CgsGlobal::getSetting('LOG_SQL_SLOW'));
		$view->set('log_sql_slow_time',	CgsGlobal::getSetting('LOG_SQL_SLOW_TIME'));

		// Send value to template
		$this->assign('log_enable', 	$view->getHtml('log_enable'));
		$this->assign('log_error', 		$view->getHtml('log_error'));
		$this->assign('log_sql', 		$view->getHtml('log_sql'));
		$this->assign('log_sql_view',	$view->getHtml('log_sql_view'));
		$this->assign('log_sql_add', 	$view->getHtml('log_sql_add'));
		$this->assign('log_sql_edit', 	$view->getHtml('log_sql_edit'));
		$this->assign('log_sql_delete',$view->getHtml('log_sql_delete'));
		$this->assign('log_sql_other', 	$view->getHtml('log_sql_other'));
		$this->assign('log_sql_slow', 	$view->getHtml('log_sql_slow'));
		$this->assign('log_sql_slow_time',	$view->getHtml('log_sql_slow_time'));
		
		$html = $this->output();
		return $html;
	}
}