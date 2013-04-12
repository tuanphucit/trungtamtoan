<?php
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );

class AjaxProcess extends CgsAjaxProcess {
	function execute() {
		$act = Page::getRequest('act','str','','POST');
		switch ($act){
			case 'add':
				$this->addProcess();
				break;
				
			case 'edit':
				$this->editProcess();
				break;
				
			case 'del':
				$this->delProcess();
				break;
				
			case 'change_publish':
				$this->changePublishProcess();
				break;
				
			default:
				$this->response('NOT_TODO');
				break;
		}
	}
	
	function addProcess(){
		$data = array();
		$data['page_name'] = Page::getRequest('page_name','str','','POST');
		$data['brief'] = Page::getRequest('brief','str','','POST');
		$data['layout'] = Page::getRequest('layout','str','','POST');
		$data['master_id'] = Page::getRequest('master_id','int',0,'POST');
		$data['portal_id'] = Page::getRequest('portal_id','int',0,'POST');
		$data['publish_flg'] = Page::getRequest('publish_flg','int',0,'POST');
		$data['time_inserted'] = time();
		$data['time_updated'] = 0;
		$data['title'] = Page::getRequest('title','str','','POST');
		$data['description'] = Page::getRequest('description','str','','POST');
		$data['keyword'] = Page::getRequest('keyword','str','','POST');
	
		if ($data['page_name']){
			require_once CGS_MODEL_PATH.'db'.DS.'DbPagePeer.php';
			$dbObj = new DbPagePeer();
			
			// Find page
			$page_name = addslashes($data['page_name']);
			$rs = $dbObj->selectOne('page', 'id,page_name', "`page_name`='{$page_name}' AND `portal_id`='{$data['portal_id']}'");
			if (!empty($rs)) $this->response('MSG','Đã tồn tại page này: ID='.$rs['id'].'; PAGE_NAME='.$rs['page_name']);
			
			$id = $dbObj->insert('page',$data);
			if ($id > 0){
				$this->response('SUCC');
			}
		}
		
		$this->response('NOT_SUCC');
	}
	
	// Sua thong tin chung
	function editProcess(){
		$page_id = Page::getRequest('page_id','int',0,'POST');
		$data['page_name'] = Page::getRequest('page_name','str','','POST');
		$data['brief'] = Page::getRequest('brief','str','','POST');
		$data['layout'] = Page::getRequest('layout','str','','POST');
		$data['master_id'] = Page::getRequest('master_id','int',0,'POST');
		$data['portal_id'] = Page::getRequest('portal_id','int',0,'POST');
		$data['publish_flg'] = Page::getRequest('publish_flg','int',0,'POST');
		$data['time_updated'] = time();
		$data['title'] = Page::getRequest('title','str','','POST');
		$data['description'] = Page::getRequest('description','str','','POST');
		$data['keyword'] = Page::getRequest('keyword','str','','POST');
		
		$is_empty_module = Page::getRequest('is_empty_module','int',0,'POST');
		if($is_empty_module){
			$data['modules'] = '';
		}
		
		if ($data['page_name']){
			require_once CGS_MODEL_PATH.'db'.DS.'DbPagePeer.php';
			$dbObj = new DbPagePeer();
			
			// Find page
			$page_name = addslashes($data['page_name']);
			$rs = $dbObj->selectOne('page', 'id,page_name', "`page_name`='{$page_name}' AND `portal_id`='{$data['portal_id']}'");
			if (isset($rs['id']) && $rs['id']!=$page_id) $this->response('MSG','Đã tồn tại page này: ID='.$rs['id'].'; PAGE_NAME='.$rs['page_name']);
			
			$id = $dbObj->updateId($page_id,$data);
			if ($id > 0){
				$this->response('SUCC');
			}
		}
		
		$this->response('NOT_SUCC');
	}
	
	function delProcess(){
		$id = Page::getRequest('id','int',0,'POST');
		require_once CGS_MODEL_PATH.'db'.DS.'DbPagePeer.php';
		$dbObj = new DbPagePeer();
		$rs = $dbObj->delete('page','id='.$id);
		if ($rs){
			$this->response('SUCC');
		}
			
		$this->response('NOT_SUCC');
	}
	
	function changePublishProcess(){
		$data = Page::getRequest('data','str','','POST');
		list($id,$publish_flg) = explode('|', $data);
		
		if ($id){
			require_once CGS_MODEL_PATH.'db'.DS.'DbPagePeer.php';
			$dbObj = new DbPagePeer();
			$data = array();
			$data['publish_flg'] = $publish_flg;
			$data['time_updated'] = time();
			
			$id = $dbObj->updateId($id,$data);
			if ($id > 0){
				$this->response('SUCC');
			}
		}
		
		$this->response('NOT_SUCC');
	}
}