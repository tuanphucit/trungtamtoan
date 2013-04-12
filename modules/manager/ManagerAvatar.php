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
require_once CGS_MODEL_PATH.'default'.DS.'DefaultGiasuPeer.php';
require_once CGS_SYSTEM_PATH.'system.paging.php';

class ManagerAvatar extends CgsModules{
	function __construct(){
		
	}
	
	function execute(){		
		if (Page::getRequest('IS_MANAGER_LOGIN','def',false,'SESSION')==false) {
			Page::goLink(null,'login','manager');
		}
		
		Page::header('Danh sách avatar');
		$pageNo = Page :: getRequest('page_no', int, 1, 'GET');
		$perPage = 20;
		$fistID = ($pageNo-1)*$perPage;
		$dbObj = new DefaultGiasuPeer();
		$total = $dbObj->count("giasu","","*");
		$allGiasu = $dbObj->select('giasu', 'giasu_id, username, updatetime, avatar, mobile, status, validate, userupdate', "", 'updatetime DESC', $fistID . ','.$perPage);
		$paging = ClassPaging::paging($total, $perPage, array(), 5,'page_no', 'active', '','');
		// print portal list
		$this->block('BlockList');
		$stt = $fistID+1;
		foreach ($allGiasu as $row){
			$avatar = $row['avatar']!=NULL?$row['avatar']:"noavatar.gif";
			$avatarLink = Page::displayImage(CGS_AVATAR_PATH.'thumb'.DS.$avatar,"avatar","100","100");
			
			$this->assign('stt', $stt);
			$this->assign('code', "MCG_".$row['giasu_id']);
			$this->assign('avatar', $avatarLink);
			$this->assign('status', ($row['status']==0)?'Ẩn':'Hiện');
			$this->assign('username', $row['username']);
			$this->assign('userupdate', $row['userupdate']);
			$this->assign('validate', ($row['validate']==0)?'Chưa đánh giá':'Đã đánh giá');
			$this->assign('del_link', Page::link(array('id'=>$row['giasu_id']),'DelAvatar','manager'));
			$this->assign('updatetime', $row['updatetime']);
			$this->add_block('BlockList');
			$stt++;
		}
		$this->assign('paging',$paging);
		$html = $this->output();
		return $html;
	}
}