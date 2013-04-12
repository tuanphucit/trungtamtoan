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

class MCarticleDetail extends CgsModules {
	function __construct() {
	}

	function execute() {
		$article_id = Page :: getRequest('id', 'int', 0, 'GET');
		$dbObj = new DefaultArticlePeer();
		$rs = $dbObj->selectOne('article', '*', "`status`= 1 AND `article_id`={$article_id}");
		$subject = "bài viết";
		$introduction = "";
		$content = "";
		$time = "";
		if (!empty ($rs)) {
			Page :: header($rs['subject']);
			$subject = $rs['subject'];
			$introduction= $rs['introduction'];
			$content = $rs['content'];
			$time = $rs['updatetime'];
		}
		
			$this->assign('subject',$subject);
			$this->assign('introduction',$introduction);
			$this->assign('content',$content);
			$updateTime = date('H:i | d/m/Y', strtotime($time));
			$this->assign('updatetime',$updateTime);
			$html = $this->output();
		return $html;
	}
}