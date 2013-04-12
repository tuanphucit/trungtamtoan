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
require_once CGS_MODEL_PATH.'default'.DS.'DefaultCommentPeer.php';
require_once CGS_SYSTEM_PATH.'system.paging.php';

class ManagerComment extends CgsModules{
	function __construct(){
		
	}
	
	function execute(){		
		if (Page::getRequest('IS_MANAGER_LOGIN','def',false,'SESSION')==false) {
			Page::goLink(null,'login','manager');
		}
		
		Page::header('Danh sách Comment');
		$pageNo = Page :: getRequest('page_no', int, 1, 'GET');
		$perPage = 20;
		$fistID = ($pageNo-1)*$perPage;
		
		$dbObj = new DefaultCommentPeer();
		
		$total = $dbObj->count("comment","","*");
		$allDoc = $dbObj->select('comment', '*', "", 'comment_time DESC', $fistID . ','.$perPage);
		$paging = ClassPaging::paging($total, $perPage, array(), 5,'page_no', 'active', '','');
		// print portal list
		$this->block('BlockList');
		$stt = $fistID+1;
		foreach ($allDoc as $row){
			$this->assign('stt', $stt);
			$this->assign('id', $row['id']);
			$this->assign('username', $row['username']);
			$this->assign('content', $row['content']);
			$this->assign('updatetime', $row['comment_time']);
			$this->assign('del_link', Page::link(array('id'=>$row['id']),'DelComment','manager'));
			$this->add_block('BlockList');
			$stt++;
		}
		$this->assign('paging',$paging);
		$html = $this->output();
		return $html;
	}
}