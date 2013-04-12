<?php
/**
 * @desc			
 * @author 			HoangNV<longhoangvnn@gmail.com> 
 * @package 		modules
 * @subpackage 		system
 * @version 		Id: SystemPortal.php v1.0 03/01/2011 hoangnv
 * @since 			CGS v 2.0
 * @copyright 		CGS.,JSC (c) 2011
 *
 */
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );
require_once CGS_MODEL_PATH.'db'.DS.'DbPortalPeer.php';
require_once CGS_SYSTEM_PATH.'system.forms.view.php';
class SystemPortal extends CgsModules{
	function __construct(){
		
	}
	
	function execute(){
		Page::header('Quản trị PORTAL - CGS system','Quản trị hệ thống','cgs,system,portal,page');
		Page::reg('js', 'modules/system/SystemPortal.js');
		
		$form = new CgsFormsView('system'.DS.'SystemPortal.xml');
		$view = $form->getView('SystemPortalView');
		
		// Khoi tao con tro db
		$dbObj = new DbPortalPeer();
		
		// Get data
		$data = $dbObj->getListAll();
		$this->block('BlockList');
		foreach ($data as $row){
			$view->mapData($row, array(	'portal_id'		=> 'id',
											'portal_brief'	=> 'brief',
											'portal_publish'=> 'publish_flg'
										)
								);
			$this->assign('id', $row['id']);
			$this->assign('name', $view->getDisplay('portal_name'));
			$this->assign('brief', $view->getDisplay('portal_brief'));
			$this->assign('publish_flg', $row['publish_flg'] ? 0 : 1);
			$this->assign('publish_label', $row['publish_flg'] ? $this->lang('enable',false) : $this->lang('disable',false));
			$this->assign('publish_class', $row['publish_flg'] ? 'icon-lock_16' : 'icon-locked_16');
			$this->assign('time_inserted', ($row['time_inserted']>0 ? date('Y-m-d H:i:s', $row['time_inserted']) : 0));
			$this->assign('time_updated', ($row['time_updated']>0 ? date('Y-m-d H:i:s', $row['time_updated']) : 0));
			
			$this->assign('portal_link', Page::link(array('portal_id'=>$row['id']),'page','system'));
			$this->assign('item_link_edit', Page::link(array('portal_id'=>$row['id']),'portal_edit','system'));
			
			$this->add_block('BlockList');
		}
		
		return $this->output();
	}
}