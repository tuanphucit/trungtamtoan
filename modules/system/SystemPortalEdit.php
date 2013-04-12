<?php
/**
 * @desc			
 * @author 			HoangNV<longhoangvnn@gmail.com> 
 * @package 		modules
 * @subpackage 		system
 * @version 		Id: SystemPortalEdit.php v1.0 03/01/2011 hoangnv
 * @since 			CGS v 2.0
 * @copyright 		CGS.,JSC (c) 2011
 *
 */
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );
require_once CGS_MODEL_PATH.'db'.DS.'DbPortalPeer.php';
require_once CGS_SYSTEM_PATH.'system.forms.view.php';
class SystemPortalEdit extends CgsModules{
	function __construct(){
		
	}
	
	function execute(){
		Page::header('Quản trị PORTAL - CGS system','Quản trị hệ thống','cgs,system,portal,page');
		
		Page::regValidateForm();
		Page::reg('js', 'modules/system/SystemPortalEdit.js');
		
		$form = new CgsFormsView('system'.DS.'SystemPortal.xml');
		$view = $form->getView('SystemPortalEditView');
		
		// Khoi tao con tro db
		$dbObj = new DbPortalPeer();
		
		// get id value of add/edit
		$portal_id = Page::getRequest('portal_id','int',0);
		if ($portal_id>0){
			$rs = $dbObj->getRow($portal_id, 'id,portal_name,brief,publish_flg');
			if (!empty($rs)){
				$view->mapData($rs, array(	'portal_id'		=> 'id',
											'portal_brief'	=> 'brief',
											'portal_publish'=> 'publish_flg'
										)
								);
				
				$view->setValidate(true);				
				$this->assign('FORM_BEGIN', $view->getFormBegin());
				$this->assign('FORM_END', 	$view->getFormEnd());
				$this->assign('id', $rs['id']);
				$this->assign('portal_id', 			$view->getHtml('portal_id'));
				$this->assign('portal_name', 		$view->getHtml('portal_name'));
				$this->assign('portal_brief', 		$view->getHtml('portal_brief'));
				$this->assign('portal_publish', 	$view->getHtml('portal_publish'));
				$this->assign('portal_btn_OK', 		$view->getHtml('portal_btn_OK'));
				$this->assign('portal_btn_RESET', 	$view->getHtml('portal_btn_RESET'));
			} else {
				Page::goLink(null,'portal','system');
			}
		} else {
			Page::goLink(null,'portal','system');
		}
		
		return $this->output();
	}
}