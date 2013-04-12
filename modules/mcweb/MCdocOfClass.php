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

class MCdocOfClass extends CgsModules{
	function __construct(){
		
	}
	
	function execute(){			
		
		Page::header('Danh sách Tài liệu');
		$cateID = Page :: getRequest('cateID', 'int', 0, 'GET');
		$classID = Page :: getRequest('classID', 'int', 0, 'GET');
		$pageNo = Page :: getRequest('page_no', 'int', 1, 'GET');
		$perPage = 20;
		$fistID = ($pageNo-1)*$perPage;
		$dbObj = new DefaultDocumentPeer();
		$total = $dbObj->count("document","`doc_cate_id` = '{$cateID}' AND `classID` = '{$classID}' AND `status` = 1 ","id");
		$allDoc = $dbObj->select('document', '*', "`doc_cate_id` = '{$cateID}' AND `classID` = '{$classID}' AND `status` = 1 ", 'updatetime DESC', $fistID . ','.$perPage);
		$paging = ClassPaging::paging($total, $perPage, array('classID'=>$classID,'cateID'=>$cateID,'page_no'=>$pageNo), 5,'page_no', 'active', '','');
		$stt = $fistID+1;	
		$htmlContent = "";
		if($allDoc){
		$htmlContent = "<tr><td>STT</td><td>Tên</td><td>Ngày tạo</td><td>Định dạng</td></tr>";
		foreach($allDoc as $doc){
				$link = Page::link(array('id'=>$doc['id']),'DocDetail','mc_web');
				$htmlContent .= "<tr width='10%'><td>".$stt."</td>" .
						"<td width='60%'><span><a href='".$link."'>".$doc['name']."</a></td>" .
						"<td width='18%'>".date('d/m/Y', strtotime($doc['updatetime']))."</td>" .
						"<td width='12%'>".$doc['type']."</td></tr>";
			$stt++;			
			}
			$htmlContent .= "<tr><td colspan='4'><span class='paging'>".$paging."</span></td></tr>";
		}else{
			$htmlContent .= "<tr><td><span style = 'color: gray;'>Không có tài liệu thuộc danh mục này<td></tr>";			
		}	
		$this->assign('content',$htmlContent);
		$html = $this->output();
		return $html;
	}
}