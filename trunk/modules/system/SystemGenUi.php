<?php
/**
 * @desc			
 * @author 			HoangNV<longhoangvnn@gmail.com> 
 * @package 		modules
 * @subpackage 		system
 * @version 		Id: SysPage.php v1.0 03/01/2011 hoangnv
 * @since 			CGS v 2.0
 * @copyright 		CGS.,JSC (c) 2011
 *
 */
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );
require_once CGS_MODEL_PATH.'db'.DS.'page.base.php';
require_once CGS_MODEL_PATH.'db'.DS.'dbConn.class.php';
class SystemPage extends CgsModules{
	function __construct(){
		
	}
	
	function execute(){		
		$this->tpl(Page::pathTpl().'SystemGenUi.htm');
		Page::reg('js', Page::pathMod().'SystemGenUi.js');
		
		// Khoi tao con tro db
		$dbObj = new DbPageBase();
		
		// Danh sach portal
		$data_portal = $dbObj->select('portal', 'id,portal_name',null,null,null,'id');
		$portal_id = Page::getRequest('portal_id','int',0,'GET');
		
		// print portal list
		$this->block('BlockPortal');
		foreach ($data_portal as $row){
			$this->assign('portal_id', $row['id']);
			$this->assign('portal_title', $row['portal_name']);
			$this->assign('portal_link', Page::link(array('portal_id'=>$row['id']),'page','system'));
			$this->assign('portal_class', ($row['id']==$portal_id ? 'current' : ''));
			$this->add_block('BlockPortal');
		}
		
		// Print data page
		$wh = ($portal_id>0 ? "`portal_id`='{$portal_id}'" : '');
		$data = $dbObj->select('page','id,page_name,brief,layout,publish_flg,master_id,portal_id',$wh,'page_name ASC',null,'id');
		$this->block('BlockList');
		foreach ($data as $row){
			$this->assign('id', $row['id']);
			$this->assign('name', $row['page_name']);
			$this->assign('brief', $row['brief']);
			$this->assign('layout', $row['layout']);
			$this->assign('publish_flg', $row['publish_flg'] ? 0 : 1);
			$this->assign('publish_label', $row['publish_flg'] ? 'Enable' : 'Disable');
			$this->assign('publish_class', $row['publish_flg'] ? 'icon-lock_16' : 'icon-locked_16');
			$this->assign('master_id', $row['master_id']);
			$this->assign('page_link', Page::link(null,$row['page_name'],isset($data_portal[$row['portal_id']]['portal_name'])
																				? $data_portal[$row['portal_id']]['portal_name']
																				: 'NULL'));
			$this->assign('item_link_edit', Page::link(array('page_id'=>$row['id']),'page_edit'));
			$this->add_block('BlockList');
		}

		$html = $this->output();
		return $html;
	}
}