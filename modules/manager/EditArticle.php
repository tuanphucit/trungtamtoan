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
require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultCategoryPeer.php';

class EditArticle extends CgsModules {
	function __construct() {
	}

	function execute() {
		if (Page::getRequest('IS_MANAGER_LOGIN','def',false,'SESSION')==false) {
			Page::goLink(null,'login','manager');
		}
		
		Page :: header('Chỉnh sửa bài viết');
		Page :: reg('js', Page :: pathMod() . 'EditArticle.js');
		Page::reg('js', CGS_WEBSKINS_PATH.'plugins/ckeditor/ckeditor.js', 'header');
		
		$article_id = Page :: getRequest('article_id', 'int', 0, 'GET');
		$dbObj = new DefaultArticlePeer();
		$rs = $dbObj->getRow($article_id);
		$form = new CgsFormsView('manager' . DS . 'EditArticle.xml');
		$view = $form->getView('EditArticleView');
		$ObjCate = new DefaultCategoryPeer();
		$allCate = $ObjCate->select('category', '*', '`status` = 1');
		$view->setListData('category_id', $allCate, 'id,name');
		if (!empty ($rs)) {
			$view->mapData($rs, array (
				'article_id' => 'article_id',
				'subject' => 'subject',
				'content' => 'content',
				'introduction' => 'introduction',
				'headImage' => 'headImage',
				'category_id' => 'category_id',
				'status' => 'status',				
			));
		}else{
			$view->mapData(array('article_id'=>0), array (
				'article_id' => 'article_id'));
		}
		$view->setValidate(true);
		$this->assign('FORM_BEGIN', $view->getFormBegin());
		$this->assign('FORM_END', $view->getFormEnd());
		$this->assign('article_id', $view->getHtml('article_id'));
		$this->assign('subject', $view->getHtml('subject'));
		$this->assign('content', $view->getHtml('content'));
		$this->assign('category_id', $view->getHtml('category_id'));
		$this->assign('headImage', $view->getHtml('headImage'));
		$this->assign('introduction', $view->getHtml('introduction'));
		$this->assign('status', $view->getHtml('status'));
		$this->assign('article_btn_OK', $view->getHtml('article_btn_OK'));
		$this->assign('article_btn_RESET', $view->getHtml('article_btn_RESET'));
		$html = $this->output();
		return $html;
	}
}