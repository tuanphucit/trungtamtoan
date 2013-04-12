<?php
/**
 * @desc			
 * @author 			HoangNV<longhoangvnn@gmail.com> 
 * @package 		modules
 * @subpackage 		system
 * @version 		Id: SystemLayouts.php v1.0 03/01/2011 hoangnv
 * @since 			CGS v 2.0
 * @copyright 		CGS.,JSC (c) 2011
 *
 */
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );
require_once CGS_MODEL_PATH.'db'.DS.'DbLayoutPeer.php';
class SystemLayouts extends CgsModules{
	function __construct(){
		
	}
	
	function execute(){
		Page::header('Quản trị PORTAL - CGS system','Quản trị hệ thống','cgs,system,layout,page');
		Page::reg('js', 'modules/system/SystemLayouts.js');
		
		// Khoi tao con tro db
		$dbObj = new DbLayoutPeer();
		
		// Get data
		$data = $dbObj->getListAll();
		$this->block('BlockList');
		$stt = 0;
		foreach ($data as $row){
			$this->assign('stt', ++$stt);
			$this->assign('ls_id', $row['id']);
			$this->assign('ls_name', $row['layout_name']);
			$this->assign('ls_brief', $row['brief']);
			$this->add_block('BlockList');
		}
		
		return $this->output();
	}
}