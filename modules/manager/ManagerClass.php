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
require_once CGS_MODEL_PATH.'default'.DS.'DefaultClassPeer.php';

class ManagerClass extends CgsModules{
	function __construct(){
		
	}
	
	function execute(){		
		if (Page::getRequest('IS_MANAGER_LOGIN','def',false,'SESSION')==false) {
			Page::goLink(null,'login','manager');
		}
		
		Page::header('Quản lý danh mục lớp học');
		
		$dbObj = new DefaultClassPeer();
		$allClass = $dbObj->select('class', '*', "", 'class_id ASC');
		// print portal list
		$this->block('BlockList');
		$stt = 1;
		foreach ($allClass as $row){
			
			$this->assign('stt', $stt);
			$this->assign('id', $row['class_id']);
			$this->assign('status', ($row['status']==0?'Ẩn':'Hiện'));
			$this->assign('name', $row['name']);
			$this->assign('updatetime', $row['updatetime']);
			$this->assign('username', $row['username']);
			$this->assign('detail_link', Page::link(array('id'=>$row['class_id']),'EditClass','manager'));
			$this->add_block('BlockList');
			$stt++;
		}
		$this->assign('newClass', Page::link(array('id'=>'0'),'EditClass','manager'));
		$html = $this->output();
		return $html;
	}
}