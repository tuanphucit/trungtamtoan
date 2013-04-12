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
defined('IN_CGS') or die('Restricted Access');
require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultDocumentPeer.php';

class MCsameNewDoc extends CgsModules {
	function __construct() {
	}

	function execute() {
		$id = Page :: getRequest('id', 'int', 0, 'GET');
		$dbObj = new DefaultDocumentPeer();
		$rs1 = $dbObj->getRow($id,'doc_cate_id, updatetime, classID, type, author');
		$this->block('BlockList');
		$this->block('BlockList1');	
		if (!empty ($rs1)) {
			$timeupdate = $rs1['updatetime'];
			$data = $dbObj->select("document","name, updatetime, id",
			"`id` != {$id} AND `doc_cate_id` = {$rs1['doc_cate_id']} " .
			"AND `classID` = {$rs1['classID']} " .
			"AND `updatetime` > TIMESTAMP('".$timeupdate."') " .
					"AND `status` = 1",
			"updatetime DESC", "0,5");
			
			if(!empty ($data)){
				foreach ($data as $row){			
					$this->assign('subject', $row['name']);
					$this->assign('doc_link', Page::link(array('id'=>$row['id']),'DocDetail','mc_web'));
					$this->assign('updatetime',date('H:i | d/m/Y', strtotime($row['updatetime'])));
					$this->add_block('BlockList');
				}
			}	
			
			$data1 = $dbObj->select("document","name, updatetime, id",
			"`id` != {$id} AND `doc_cate_id` = {$rs1['doc_cate_id']} " .
			"AND `classID` = {$rs1['classID']} " .
			"AND `updatetime` < TIMESTAMP('".$timeupdate."') " .
					"AND `status` = 1",
			"updatetime DESC", "0,5");
			
			if(!empty ($data1)){
				foreach ($data1 as $row){			
					$this->assign('subject1', $row['name']);
					$this->assign('doc_link1', Page::link(array('id'=>$row['id']),'DocDetail','mc_web'));
					$this->assign('updatetime1',date('H:i | d/m/Y', strtotime($row['updatetime'])));
					$this->add_block('BlockList1');
				}
			}			
		}
			
		$html = $this->output();
		return $html;
	}
}