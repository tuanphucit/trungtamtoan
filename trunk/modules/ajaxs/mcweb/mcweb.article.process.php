<?php
defined('IN_CGS') or die('Restricted Access');

class AjaxProcess extends CgsAjaxProcess {
	function execute() {
		$act = Page :: getRequest('act', 'str', '', 'POST');
		switch ($act) {
			case 'edit' :
				$this->editProcess();
				break;
			
			case 'add' :
				$this->addProcess();
				break;
				
			case 'del' :
				$this->delProcess();
				break;	
				
			default :
				$this->response('NOT_TODO');
				break;
		}
	}

	function editProcess() {
		$data = array ();
		$article_id = Page :: getRequest('article_id', 'int', 0, 'POST');
		$data['subject'] = Page :: getRequest('subject', 'str', '', 'POST');
		$data['content'] = Page :: getRequest('content', 'str', '', 'POST');
		$data['introduction'] = Page :: getRequest('introduction', 'str', '', 'POST');
		$data['headImage'] = Page :: getRequest('headImage', 'str', '', 'POST');
		$data['category_id'] = Page :: getRequest('category_id','int' , '', 'POST');	
		$data['status'] = Page :: getRequest('status','int' , '', 'POST');					
		$data['updatetime'] = current();
		$data['userupdate'] = Page::getRequest('username','str','','SESSION');
		if ($article_id) {
			require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultArticlePeer.php';
			$dbObj = new DefaultArticlePeer();
			$id = $dbObj->updateId($article_id, $data);				
			if ($id) {
				echo json_encode(array (
					"notice" => "success"
				));
				return;
			}
		}
		echo json_encode(array (
			"notice" => "not success"
		));
		return;
	}

	function delProcess() {
		$article_id = Page :: getRequest('article_id', 'int', '', 'POST');
		if ($article_id) {
			require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultArticlePeer.php';
			$dbObj = new DefaultArticlePeer();
			$id = $dbObj->deleteById($article_id);
			if ($id) {
				echo json_encode(array (
					"notice" => "success"
				));
				return;
			}
		}
		echo json_encode(array (
			"notice" => "not success"
		));
		return;
	}
	
	
	function addProcess() {
		$data = array ();
		$data['subject'] = Page :: getRequest('subject', 'str', '', 'POST');
		$data['content'] = Page :: getRequest('content', 'str', '', 'POST');
		$data['introduction'] = Page :: getRequest('introduction', 'str', '', 'POST');
		$data['headImage'] = Page :: getRequest('headImage', 'str', '', 'POST');
		$data['category_id'] = Page :: getRequest('category_id','int' , '', 'POST');	
		$data['status'] = Page :: getRequest('status','int' , '', 'POST');					
		$data['updatetime'] = current();
		if ($data) {
			require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultArticlePeer.php';
			$dbObj = new DefaultArticlePeer();			
			$id = $dbObj->insert("article",$data);
			if ($id) {
				echo json_encode(array (
					"notice" => "success"
				));
				return;
			}
		}
		echo json_encode(array (
			"notice" => "not success"
		));
		return;
	}
}