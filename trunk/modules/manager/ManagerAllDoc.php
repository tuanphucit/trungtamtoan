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
require_once CGS_MODEL_PATH.'default'.DS.'DefaultDocumentPeer.php';
require_once CGS_MODEL_PATH.'default'.DS.'DefaultDoccatePeer.php';
require_once CGS_MODEL_PATH.'default'.DS.'DefaultClassPeer.php';
require_once CGS_SYSTEM_PATH.'system.paging.php';

class ManagerAllDoc extends CgsModules{
	function __construct(){
		
	}
	
	function execute(){		
		if (Page::getRequest('IS_MANAGER_LOGIN','def',false,'SESSION')==false) {
			Page::goLink(null,'login','manager');
		}
		
		Page::header('Danh sách Tài liệu');
		$pageNo = Page :: getRequest('page_no', int, 1, 'GET');
		$perPage = 5;
		$fistID = ($pageNo-1)*$perPage;
		
		$dbObj = new DefaultDocumentPeer();
		$classObj = new DefaultClassPeer();
		$docCateObj = new DefaultDoccatePeer();
		
		$total = $dbObj->count("document","`filename` != 'default'","*");
		$allDoc = $dbObj->select('document', '*', "`filename` != 'default'", 'updatetime DESC', $fistID . ','.$perPage);
		$paging = ClassPaging::paging($total, $perPage, array(), 5,'page_no', 'active', '','');
		// print portal list
		$this->block('BlockList');
		$stt = $fistID+1;
		foreach ($allDoc as $row){
			$className = $classObj->getRow($row['classID'],'name');
			$docCate = $docCateObj->getRow($row['doc_cate_id'],'name');
			$this->assign('stt', $stt);
			$this->assign('id', $row['id']);
			$this->assign('url', $row['filename']);
			$this->assign('name', $row['name']);
			$this->assign('status', ($row['status']==0)?'Ẩn':'Hiện');
			$this->assign('action', ($row['status']!=0)?'Ẩn':'Hiện');
			$this->assign('author', $row['author']);
			$this->assign('className', $className['name']);
			$this->assign('doc_cate_name', $docCate['name']);
			$this->assign('userupdate', $row['userupdate']);
			$this->assign('del_link', Page::link(array('id'=>$row['id']),'DelDoc','manager'));
			$this->assign('show_link', Page::link(array('id'=>$row['id']),'ShowDoc','manager'));			
			$this->assign('updatetime', $row['updatetime']);
			$this->add_block('BlockList');
			$stt++;
		}
		$this->assign('paging',$paging);
		$html = $this->output();
		return $html;
	}
}