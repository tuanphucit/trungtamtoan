<?php
/**
 * @desc			
 * @author 			HoangNV<longhoangvnn@gmail.com> 
 * @package 		modules
 * @subpackage 		system
 * @version 		Id: SystemPageAdd.php v1.0 03/01/2011 hoangnv
 * @since 			CGS v 2.0
 * @copyright 		CGS.,JSC (c) 2011
 *
 */
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );
require_once CGS_MODEL_PATH.'db'.DS.'DbPagePeer.php';
require_once CGS_SYSTEM_PATH.'system.forms.view.php';
class SystemPageAdd extends CgsModules{
	function __construct(){
		
	}
	
	function execute(){
		Page::header('Quản trị PORTAL - CGS system','Quản trị hệ thống','cgs,system,page,page');
		
		Page::regValidateForm();
		
        Page::reg('css', CGS_JS_SYSTEM_PATH.'popup.css', 'header');
        Page::reg('js', CGS_JS_SYSTEM_PATH.'jqDnR.js', 'footer');
        Page::reg('js', CGS_JS_SYSTEM_PATH.'popup.js', 'footer');
        
		Page::reg('js', 'modules/system/SystemPageAdd.js');
		
		// Khoi tao con tro db
		$dbObj = new DbPagePeer();
		
		$data_layout = $dbObj->select('layout', 'id,layout_name',null,null,null,'id');
		$data_portal = $dbObj->select('portal', 'id,portal_name',null,null,null,'id');
		
		$form = new CgsFormsView('system'.DS.'SystemPage.xml');
		$view = $form->getView('SystemPageAddView');
		$view->setValidate(true);
		$view->setListData('layout', $data_layout, 'layout_name,layout_name');
		$view->setListData('portal_id', $data_portal, 'id,portal_name');
		
		$portal_id = Page::getRequest('portal_id','int',0,'GET');
		$view->set('portal_id', $portal_id);

		$this->assign('FORM_BEGIN', $view->getFormBegin());
		$this->assign('FORM_END', 	$view->getFormEnd());
		
		$this->assign('page_name', 		$view->getHtml('page_name'));
		$this->assign('brief', 			$view->getHtml('brief'));
		$this->assign('layout', 		$view->getHtml('layout'));
		$this->assign('master_page_id', $view->getHtml('master_page_id'));
		$this->assign('portal_id', 		$view->getHtml('portal_id'));
		$this->assign('publish', 		$view->getHtml('publish'));
		$this->assign('page_title', 		$view->getHtml('page_title'));
		$this->assign('page_description', 	$view->getHtml('page_description'));
		$this->assign('page_keyword', 		$view->getHtml('page_keyword'));
		
		$this->assign('page_btn_OK', 	$view->getHtml('page_btn_OK'));
		$this->assign('page_btn_RESET', $view->getHtml('page_btn_RESET'));
		
		$html = $this->output();
		return $html;
	}
}