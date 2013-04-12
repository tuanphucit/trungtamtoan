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
require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultArticlePeer.php';

class MCsameNewArticle extends CgsModules {
	function __construct() {
	}

	function execute() {
		$article_id = Page :: getRequest('id', 'int', 0, 'GET');
		$dbObj = new DefaultArticlePeer();
		$rs1 = $dbObj->getRow($article_id,'category_id, updatetime');
		$this->block('BlockList');
		$this->block('BlockList1');	
		if (!empty ($rs1)) {
			$timeupdate = $rs1['updatetime'];
			//$time = time($rs1['updatetime']);
			$data = $dbObj->select("article","subject, updatetime, article_id",
			"`article_id` != {$article_id} AND `category_id` = {$rs1['category_id']} AND `updatetime` > TIMESTAMP('".$timeupdate."') AND `status` = 1",
			"updatetime DESC", "0,5");
			
			if(!empty ($data)){
				foreach ($data as $row){			
					$this->assign('subject', $row['subject']);
					$this->assign('article_link', Page::link(array('id'=>$row['article_id']),'articleDetail','mc_web'));
					$this->assign('updatetime',date('H:i | d/m/Y', strtotime($row['updatetime'])));
					$this->add_block('BlockList');
				}
			}	
			
			$data1 = $dbObj->select("article","subject, updatetime, article_id",
			"`article_id` != {$article_id} AND `category_id` = {$rs1['category_id']} AND `updatetime` < TIMESTAMP('".$timeupdate."') AND  `status` = 1",
			"updatetime DESC", "0,5");
			
			if(!empty ($data1)){
				foreach ($data1 as $row){			
					$this->assign('subject1', $row['subject']);
					$this->assign('article_link1', Page::link(array('id'=>$row['article_id']),'articleDetail','mc_web'));
					$this->assign('updatetime1',date('H:i | d/m/Y', strtotime($row['updatetime'])));
					$this->add_block('BlockList1');
				}
			}			
		}
			
		$html = $this->output();
		return $html;
	}
}