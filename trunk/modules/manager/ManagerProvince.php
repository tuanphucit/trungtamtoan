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
require_once CGS_MODEL_PATH.'default'.DS.'DefaultProvincePeer.php';
require_once CGS_SYSTEM_PATH.'system.paging.php';

class ManagerProvince extends CgsModules{
	function __construct(){
		
	}
	
	function execute(){		
		if (Page::getRequest('IS_MANAGER_LOGIN','def',false,'SESSION')==false) {
			Page::goLink(null,'login','manager');
		}
		
		Page::header('Quản trị tỉnh thành phố');
		Page::reg('js', Page::pathMod().'ManagerProvince.js');
		$pageNo = Page :: getRequest('page_no', int, 1, 'GET');
		$perPage = 5;
		$fistID = ($pageNo-1)*$perPage;
		$dbObj = new DefaultProvincePeer();
		$total = $dbObj->count("province","","*");
		$allProvinces = $dbObj->select('province', '*', "", 'id ASC', $fistID . ','.$perPage);
		$paging = ClassPaging::paging($total, $perPage, array(), 5,'page_no', 'active', '','');
		// print portal list
		$this->block('BlockList');
		$stt = $fistID+1;
		foreach ($allProvinces as $row){
			
			$this->assign('stt', $stt);
			$this->assign('id', $row['id']);
			$this->assign('status', ($row['status']==0?'Ẩn':'Hiện'));
			$this->assign('name', $row['name']);
			$this->assign('username', $row['username']);
			$this->assign('updatetime', $row['updatetime']);
			$this->assign('detail_link', Page::link(array('id'=>$row['id']),'EditProvince','manager'));
			$this->add_block('BlockList');
			$stt++;
		}
		$this->assign('paging',$paging);
		$this->assign('newProvince', Page::link(array('id'=>'0'),'EditProvince','manager'));
		$html = $this->output();
		return $html;
	}
}