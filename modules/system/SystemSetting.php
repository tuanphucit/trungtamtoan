<?php
/**
 * @desc			
 * @author 			HoangNV<longhoangvnn@gmail.com> 
 * @package 		modules
 * @subpackage 		system
 * @version 		Id: SystemSetting.php v1.0 03/01/2011 hoangnv
 * @since 			CGS v 2.0
 * @copyright 		CGS.,JSC (c) 2011
 */
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );
require_once CGS_MODEL_PATH.'db'.DS.'DbSettingPeer.php';
class SystemSetting extends CgsModules{

	function execute(){
		//Page::header('Cấu hình hệ thống - CGS system','Quản trị hệ thống','cgs,system,page,page');
		Page::reg('js', Page::pathMod().'SystemSetting.js');
		
		$form = new CgsFormsView('system'.DS.'SystemSetting.xml');
		$view = $form->getView('SystemSettingView');
		
		// Set value default
		$view->set('rewrite_url', CgsGlobal::getSetting('REWRITE_URL'));
		
		$this->assign('FORM_BEGIN', $view->getFormBegin('page_name'));
		$this->assign('FORM_END', 	$view->getFormEnd());
		
		$this->assign('rewrite_url', 	$view->getHtml('rewrite_url'));
		
		$this->assign('setting_btn_OK', 	$view->getHtml('setting_btn_OK'));
		$this->assign('setting_btn_RESET', $view->getHtml('setting_btn_RESET'));

		$html = $this->output();
		return $html;
	}
}