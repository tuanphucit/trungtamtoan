<?php
/**
 * @desc			
 * @author 			HoangNV<longhoangvnn@gmail.com> 
 * @package 		modules
 * @subpackage 		system
 * @version 		Id: SystemDebug.php v1.0 2011/07/23 hoangnv
 * @since 			CGS v 2.0
 * @copyright 		CGS.,JSC (c) 2011
 */
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );
//require_once CGS_MODEL_PATH.'db'.DS.'setting.base.php';
require_once CGS_SYSTEM_PATH.'system.forms.view.php';
class SystemDebug extends CgsModules{
	function __construct(){
		
	}
	
	function execute(){
		Page::header('Cấu hình hệ thống - CGS system','Quản trị hệ thống','cgs,system,page,page');
		Page::reg('js', Page::pathMod().'SystemDebug.js');
		
		$form = new CgsFormsView('system'.DS.'SystemSetting.xml');
		$view = $form->getView('SystemDebugView');
		$this->assign('FORM_BEGIN', $view->getFormBegin());
		$this->assign('FORM_END', 	$view->getFormEnd());
		$this->assign('debug_btn_OK', 		$view->getHtml('debug_btn_OK'));
		$this->assign('debug_btn_RESET', 	$view->getHtml('debug_btn_RESET'));
		
		// Set value default
		$view->set('debug_enable',					CgsGlobal::getSetting('DEBUG_ENABLE'));
		$view->set('debug_error',					CgsGlobal::getSetting('DEBUG_ERROR'));
		$view->set('debug_general_information',		CgsGlobal::getSetting('DEBUG_GENERAL_INFORMATION'));
		$view->set('debug_layout_position_flugin',	CgsGlobal::getSetting('DEBUG_LAYOUT_POSITION_FLUGIN'));
		$view->set('debug_sql_query',				CgsGlobal::getSetting('DEBUG_SQL_QUERY'));
		$view->set('debug_includes_file',			CgsGlobal::getSetting('DEBUG_INCLUDES_FILE'));
		$view->set('debug_var',						CgsGlobal::getSetting('DEBUG_VAR'));
		$view->set('debug_request',					CgsGlobal::getSetting('DEBUG_REQUEST'));
		$view->set('debug_lang',					CgsGlobal::getSetting('DEBUG_LANG'));
		
		// Send value to template
		$this->assign('debug_enable', 					$view->getHtml('debug_enable'));
		$this->assign('debug_error', 					$view->getHtml('debug_error'));
		$this->assign('debug_general_information', 		$view->getHtml('debug_general_information'));
		$this->assign('debug_layout_position_flugin',	$view->getHtml('debug_layout_position_flugin'));
		$this->assign('debug_sql_query', 				$view->getHtml('debug_sql_query'));
		$this->assign('debug_includes_file', 			$view->getHtml('debug_includes_file'));
		$this->assign('debug_var', 						$view->getHtml('debug_var'));
		$this->assign('debug_request', 					$view->getHtml('debug_request'));
		$this->assign('debug_lang', 					$view->getHtml('debug_lang'));

		$html = $this->output();
		return $html;
	}
}