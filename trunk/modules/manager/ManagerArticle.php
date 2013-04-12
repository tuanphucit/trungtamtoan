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
require_once CGS_MODEL_PATH.'default'.DS.'DefaultArticlePeer.php';
require_once CGS_SYSTEM_PATH.'system.paging.php';

class ManagerArticle extends CgsModules{
	function __construct(){
		
	}
	
	function execute(){		
		if (Page::getRequest('IS_MANAGER_LOGIN','def',false,'SESSION')==false) {
			Page::goLink(null,'login','manager');
		}
		
		Page::header('Quản trị bài viết');
		Page::reg('js', Page::pathMod().'ManagerArticle.js');
		$pageNo = Page :: getRequest('page_no', int, 1, 'GET');
		$perPage = 20;
		$fistID = ($pageNo-1)*$perPage;
		$dbObj = new DefaultArticlePeer();
		$total = $dbObj->count("article","","*");
		$allArticles = $dbObj->select('article', '*', "", 'updatetime DESC', $fistID . ','.$perPage);
		$paging = ClassPaging::paging($total, $perPage, array(), 5,'page_no', 'active', '','');
		// print portal list
		$this->block('BlockList');
		$stt = $fistID+1;
		foreach ($allArticles as $row){
			
			$this->assign('stt', $stt);
			$this->assign('article_id', $row['article_id']);
			$this->assign('status', ($row['status']==0?'Ẩn':'Hiện'));
			$this->assign('subject', $row['subject']);
			$this->assign('article_link', Page::link(array('article_id'=>$row['article_id']),'EditArticle','manager'));
			$this->assign('userupdate', $row['userupdate']);
			$this->assign('updatetime', $row['updatetime']);
			$this->add_block('BlockList');
			$stt++;
		}
		$this->assign('paging',$paging);
		$this->assign('newArticle', Page::link(array('article_id'=>'0'),'EditArticle','manager'));
		$html = $this->output();
		return $html;
	}
}