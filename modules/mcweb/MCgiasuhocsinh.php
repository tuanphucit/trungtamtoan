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
require_once CGS_SYSTEM_PATH.'cgs.func.php';

class MCgiasuhocsinh extends CgsModules {
	function __construct() {
	}

	function execute() {	
		$dbObj = new DefaultArticlePeer();
		$this->block('BlockList1');
			$data = $dbObj->select("article","*","`category_id` = 3 AND `status` = 1","updatetime DESC", "0,5");
			
			if(!empty ($data)){
				foreach ($data as $row){			
					$this->assign('subject', $row['subject']);
					$this->assign('displayImage', Page::displayImage(CGS_AVATAR_PATH.'thumb'.DS.'arrow_right.gif','',5,5));				
					$this->assign('article_link', Page::link(array('id'=>$row['article_id']),'articleDetail','mc_web'));
					$this->add_block('BlockList1');
				}
			}
			
			
			$this->block('BlockList2');
			$dataHS = $dbObj->select("article","*","`category_id` = 4 AND `status` = 1","updatetime DESC", "0,5");
			
			if(!empty ($dataHS)){
				foreach ($dataHS as $row){			
					$this->assign('subject', $row['subject']);
					$this->assign('displayImage', Page::displayImage(CGS_AVATAR_PATH.'thumb'.DS.'arrow_right.gif','',5,5));					
					$this->assign('article_link', Page::link(array('id'=>$row['article_id']),'articleDetail','mc_web'));
					$this->add_block('BlockList2');
				}
			}
						
			
		$html = $this->output();
		return $html;
	}
}