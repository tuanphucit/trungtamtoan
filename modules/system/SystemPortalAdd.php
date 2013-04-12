<?php
/**
 * @desc			
 * @author 			HoangNV<longhoangvnn@gmail.com> 
 * @package 		modules
 * @subpackage 		system
 * @version 		Id: SystemPortalAdd.php v1.0 03/01/2011 hoangnv
 * @since 			CGS v 2.0
 * @copyright 		CGS.,JSC (c) 2011
 *
 */
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );
require_once CGS_SYSTEM_PATH.'system.forms.view.php';
class SystemPortalAdd extends CgsModules{
	function __construct(){
		
	}
	
	function execute(){
		Page::header('Quản trị PORTAL - CGS system','Quản trị hệ thống','cgs,system,portal,page');
		
		Page::regValidateForm();
		Page::reg('js', 'modules/system/SystemPortalAdd.js');
		
		$form = new CgsFormsView('system'.DS.'SystemPortal.xml');
		$view = $form->getView('SystemPortalAddView');
		$view->setValidate(true);
		
		$this->assign('FORM_BEGIN', $view->getFormBegin());
		$this->assign('FORM_END', 	$view->getFormEnd());
		
		$this->assign('portal_name', 		$view->getHtml('portal_name'));
		$this->assign('portal_brief', 		$view->getHtml('portal_brief'));
		$this->assign('portal_publish', 	$view->getHtml('portal_publish'));
		$this->assign('portal_btn_OK', 		$view->getHtml('portal_btn_OK'));
		$this->assign('portal_btn_RESET', 	$view->getHtml('portal_btn_RESET'));
		
		return $this->output();
	}
}