<?php
/**
 * @desc			
 * @author 			HoangNV<longhoangvnn@gmail.com> 
 * @package 		modules
 * @subpackage 		system
 * @version 		Id: SystemCache.php v1.0 2011/07/23 hoangnv
 * @since 			CGS v 2.0
 * @copyright 		CGS.,JSC (c) 2011
 */
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );
require_once CGS_SYSTEM_PATH.'system.forms.view.php';
class SystemCache extends CgsModules{
	function __construct(){
		
	}
	
	function execute(){
		Page::header('Cấu hình hệ thống - CGS system','Quản trị hệ thống','cgs,system,page,page');
		Page::regColorpicker();
		Page::reg('js', Page::pathMod().'SystemCache.js');
		
		$form = new CgsFormsView('system'.DS.'SystemSetting.xml');
		$view = $form->getView('SystemCacheView');
		$this->assign('FORM_BEGIN', $view->getFormBegin());
		$this->assign('FORM_END', 	$view->getFormEnd());
		$this->assign('cache_btn_OK', 		$view->getHtml('cache_btn_OK'));
		$this->assign('cache_btn_RESET',	$view->getHtml('cache_btn_RESET'));
		
		// Set value default
		$view->set('cache_enable',			CgsGlobal::getSetting('CACHE_ENABLE'));
		$view->set('cache_sql',				CgsGlobal::getSetting('CACHE_SQL'));
		$view->set('cache_sql_time',		CgsGlobal::getSetting('CACHE_SQL_TIME'));
		$view->set('cache_uri',				CgsGlobal::getSetting('CACHE_URI'));
		$view->set('cache_uri_time',		CgsGlobal::getSetting('CACHE_URI_TIME'));
		$view->set('cache_module',			CgsGlobal::getSetting('CACHE_MODULE'));
		$view->set('cache_module_time',		CgsGlobal::getSetting('CACHE_MODULE_TIME'));
		$view->set('cache_js',				CgsGlobal::getSetting('CACHE_JS'));
		$view->set('cache_js_time',			CgsGlobal::getSetting('CACHE_JS_TIME'));
		$view->set('cache_css',				CgsGlobal::getSetting('CACHE_CSS'));
		$view->set('cache_css_time',		CgsGlobal::getSetting('CACHE_CSS_TIME'));
		
		// Send value to template
		$this->assign('cache_enable', 		$view->getHtml('cache_enable'));
		$this->assign('cache_sql', 			$view->getHtml('cache_sql'));
		$this->assign('cache_sql_time',		$view->getHtml('cache_sql_time'));
		$this->assign('cache_uri', 			$view->getHtml('cache_uri'));
		$this->assign('cache_uri_time', 	$view->getHtml('cache_uri_time'));
		$this->assign('cache_module', 		$view->getHtml('cache_module'));
		$this->assign('cache_module_time', 	$view->getHtml('cache_module_time'));
		$this->assign('cache_js', 			$view->getHtml('cache_js'));
		$this->assign('cache_js_time', 		$view->getHtml('cache_js_time'));
		$this->assign('cache_css', 			$view->getHtml('cache_css'));
		$this->assign('cache_css_time', 	$view->getHtml('cache_css_time'));

		$html = $this->output();
		return $html;
	}
}