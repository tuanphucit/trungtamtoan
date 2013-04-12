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
require_once CGS_MODEL_PATH.'default'.DS.'DefaultDoccatePeer.php';
require_once CGS_SYSTEM_PATH.'system.paging.php';

class ManagerDocCate extends CgsModules{
	function __construct(){
		
	}
	
	function execute(){		
		if (Page::getRequest('IS_MANAGER_LOGIN','def',false,'SESSION')==false) {
			Page::goLink(null,'login','manager');
		}
		
		Page::header('Danh sách Danh mục Tài liệu');
		$pageNo = Page :: getRequest('page_no', int, 1, 'GET');
		$perPage = 5;
		$fistID = ($pageNo-1)*$perPage;
		$dbObj = new DefaultDoccatePeer();
		$total = $dbObj->count("doccate","","*");
		$allCate = $dbObj->select('doccate', '*', "", 'id DESC', $fistID . ','.$perPage);
		$paging = ClassPaging::paging($total, $perPage, array(), 5,'page_no', 'active', '','');
		// print portal list
		$this->block('BlockList');
		$stt = $fistID+1;
		foreach ($allCate as $row){			
			$this->assign('stt', $stt);
			$this->assign('name', $row['name']);
			$this->assign('status', ($row['status']==0)?'Ẩn':'Hiện');
			$this->assign('description', $row['description']);
			$this->assign('detail_link', Page::link(array('id'=>$row['id']),'EditDocCate','manager'));
			$this->assign('parentID', $row['parentID']);
			$this->assign('username', $row['userupdate']);
			$this->assign('updatetime', $row['updatetime']);
			$this->add_block('BlockList');
			$stt++;
		}
		$this->assign('newCate', Page::link(array('id'=>'0'),'EditDocCate','manager'));		
		$this->assign('paging',$paging);
		$html = $this->output();
		return $html;
	}
}