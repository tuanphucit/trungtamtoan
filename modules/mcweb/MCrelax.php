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

class MCrelax extends CgsModules {
	function __construct() {
	}

	function execute() {
		$dbObj = new DefaultArticlePeer();
		$this->block('BlockList1');
			$data = $dbObj->select("article","*","`category_id` = 7 AND `status` = 1","updatetime DESC", "0,3");
			
			if(!empty ($data)){
				foreach ($data as $row){			
					$this->assign('subject', $row['subject']);
					$image = $row['headImage']?$row['headImage']:'data/avatar/defaultimage.jpg';
					$this->assign('displayImage', Page::displayImage(CgsFunc::createThumbs($image,CGS_IMAGES_THUMB,100),'',50,50));
					$this->assign('article_link', Page::link(array('id'=>$row['article_id']),'articleDetail','mc_web'));
					$this->add_block('BlockList1');
				}
			}			
			
		$html = $this->output();
		return $html;
	}
}