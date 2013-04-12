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
		$name = Page::getRequest('name','str','','POST');
		$brief = Page::getRequest('brief','str','','POST');
		$publish = Page::getRequest('publish','int',0,'POST');
		
		if ($name){
			require_once CGS_MODEL_PATH.'db'.DS.'DbPortalPeer.php';
			$dbObj = new DbPortalPeer();
			$data = array();
			$data['portal_name'] = $name;
			$data['brief'] = $brief;
			$data['publish_flg'] = $publish;
			$data['time_inserted'] = time();
			
			$id = $dbObj->insert('portal',$data);
			if ($id > 0){
				$this->response('SUCC');
			}
		}
		
		$this->response('NOT_SUCC');
	}
	
	function editProcess(){
		$id = Page::getRequest('id','int',0);
		$name = Page::getRequest('name','str','','POST');
		$brief = Page::getRequest('brief','str','','POST');
		$publish = Page::getRequest('publish','int',0,'POST');
		
		if ($name){
			require_once CGS_MODEL_PATH.'db'.DS.'DbPortalPeer.php';
			$dbObj = new DbPortalPeer();
			$data = array();
			$data['portal_name'] = $name;
			$data['brief'] = $brief;
			$data['publish_flg'] = $publish;
			$data['time_updated'] = time();
			
			$id = $dbObj->updateId($id,$data);
			if ($id > 0){
				$this->response('SUCC');
			}
		}
		
		$this->response('NOT_SUCC');
	}
	
	function delProcess(){
		$id = Page::getRequest('id','int',0,'POST');
		require_once CGS_MODEL_PATH.'db'.DS.'DbPortalPeer.php';
		$dbObj = new DbPortalPeer();
		$rs = $dbObj->delete('portal','id='.$id);
		if ($rs){
			$this->response('SUCC');
		}
			
		$this->response('NOT_SUCC');
	}
	
	function changePublishProcess(){
		$data = Page::getRequest('data','str','','POST');
		list($id,$publish_flg) = explode('|', $data);
		
		if ($id){
			require_once CGS_MODEL_PATH.'db'.DS.'DbPortalPeer.php';
			$dbObj = new DbPortalPeer();
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