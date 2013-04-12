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

class MCdocDetail extends CgsModules{
	function __construct(){
		
	}
	
	function execute(){		
		
		$id = Page :: getRequest('id', 'int', 0, 'GET');
		
		$dbObj = new DefaultDocumentPeer();
		$doc = $dbObj->selectOne('document', '*', "`id` = {$id} AND `status` = 1 ", '','');		
		Page::header('Chi tiết tài liệu');
		$this->assign('author',$doc['author']);
		$this->assign('description',$doc['description']);
		$this->assign('updatetime',date('H:i | d/m/Y', strtotime($doc['updatetime'])));
		$this->assign('name',$doc['name']);	
		$this->assign('back',"<center><a href='#' name='back' onclick='history.go(-1);' style='color: blue;'>Quay lại</a></center>");
		$link = Page::link(array('name'=>$doc['filename']),'Download','mc_web');
		$downloadLink = "<a href='".$link."'  target='_blank' style='color: red;'>Download</a>";	
		$this->assign('downloadLink',$downloadLink);					
		$html = $this->output();
		return $html;
	}
}