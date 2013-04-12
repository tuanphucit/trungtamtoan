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
require_once CGS_MODEL_PATH.'default'.DS.'DefaultHocsinhPeer.php';
require_once CGS_SYSTEM_PATH.'system.paging.php';

class ManagerPupil extends CgsModules{
	function __construct(){
		
	}
	
	function execute(){		
		if (Page::getRequest('IS_MANAGER_LOGIN','def',false,'SESSION')==false) {
			Page::goLink(null,'login','manager');
		}
		
		Page::header('Danh sách học sinh');
		Page::reg('js', Page::pathMod().'ManagerArticle.js');
		$pageNo = Page :: getRequest('page_no', int, 1, 'GET');
		$perPage = 20;
		$fistID = ($pageNo-1)*$perPage;
		$dbObj = new DefaultHocsinhPeer();
		$total = $dbObj->count("hocsinh","","*");
		$allHocsinh = $dbObj->select('hocsinh', 'hocsinh_id, mothername, updatetime, mobile, status, userupdate', "", 'updatetime DESC', $fistID . ','.$perPage);
		$paging = ClassPaging::paging($total, $perPage, array(), 5,'page_no', 'active', '','');
		// print portal list
		$this->block('BlockList');
		$stt = $fistID+1;
		foreach ($allHocsinh as $row){
			
			$this->assign('stt', $stt);
			$this->assign('code', "MCH_".$row['hocsinh_id']);
			$this->assign('mobile', $row['mobile']);
			$this->assign('status', ($row['status']==0)?'Ẩn':'Hiện');
			$this->assign('mothername', $row['mothername']);
			$this->assign('userupdate', $row['userupdate']);
			$this->assign('detail_link', Page::link(array('id'=>$row['hocsinh_id']),'EditHocsinh','manager'));
			$this->assign('updatetime', $row['updatetime']);
			$this->add_block('BlockList');
			$stt++;
		}
		$this->assign('paging',$paging);
		$html = $this->output();
		return $html;
	}
}